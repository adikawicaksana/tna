<?php namespace App\Services;

class NotificationService
{
    protected $waApiUrl;
    protected $waApiKey;
    protected $mailConfig;

    public function __construct()
    {
        $this->waApiKey = env('notif.wa.apiKey');
        $this->waApiUrlSendText = env('notif.wa.apiUrl.sendText');
        $this->waApiUrlSendMedia = env('notif.wa.apiUrl.sendMedia');

        $this->mailConfig = [
            'host'     => env('notif.mail.host'),
            'user'     => env('notif.mail.user'),
            'pass'     => env('notif.mail.pass'),
            'port'     => env('notif.mail.port'),
            'fromName' => env('notif.mail.fromName'),
        ];
    }

  /**   
* Kirim WhatsApp (Text atau Media)
 *
 * @param string      $receiver Nomor tujuan
 * @param string      $message  Pesan teks / caption
 * @param string|null $type     Jenis pesan: 'media' atau default text
 * @param string|null $mediaUrl URL media (hanya jika type = media)
 */
public function sendWhatsApp(string $receiver, string $message, ?string $type = null, ?string $mediaUrl = null): array
{
    $client = \Config\Services::curlrequest();

    // default type ke text jika kosong / tidak valid
    $isMedia = ($type === 'media' && !empty($mediaUrl));
    $apiUrl  = $isMedia ? $this->waApiUrlSendMedia : $this->waApiUrlSendText;

    // payload dasar
    $payload = [
        'apikey'   => $this->waApiKey,
        'receiver' => $receiver,
        'mtype'    => $isMedia ? 'media' : 'text',
        'text'     => $message,
    ];

    // tambahkan URL media jika type media valid
    if ($isMedia) {
        $payload['media_url'] = $mediaUrl;
    }

    try {
        $response = $client->post($apiUrl, [
            'headers' => [
                // 'Authorization' => 'Bearer ' . $this->waApiKey,
                'Content-Type'  => 'application/x-www-form-urlencoded'
            ],
            'form_params' => $payload,
            'timeout'     => 10
        ]);

        $body = json_decode($response->getBody(), true);

        return [
            'success' => ($body['status'] ?? '') === 'success',
            'message' => $body['message'] ?? 'Gagal mengirim WhatsApp'
        ];
    } catch (\Exception $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

    /**
     * Kirim Email
     */
    public function sendEmail(string $to, string $subject, string $message): array
    {
        $email = \Config\Services::email();

        $email->initialize([
            'protocol' => 'smtp',
            'SMTPHost' => $this->mailConfig['host'],
            'SMTPUser' => $this->mailConfig['user'],
            'SMTPPass' => $this->mailConfig['pass'],
            'SMTPPort' => $this->mailConfig['port'],
            'mailType' => 'html',
            'charset'  => 'utf-8',
            'newline'  => "\r\n",
        ]);

        $email->setFrom($this->mailConfig['user'], $this->mailConfig['fromName']);
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            return ['success' => true, 'message' => 'Email berhasil dikirim'];
        } else {
            return ['success' => false, 'message' => $email->printDebugger(['headers'])];
        }
    }
}
