<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Captcha extends BaseController
{
    public function generate()
{
     helper('text');
    $random_str = random_string('alnum', 6);

    // Simpan ke session
    session()->set('captcha', [
        'hash'   => password_hash(strtoupper($random_str), PASSWORD_DEFAULT),
        'expire' => time() + 120
    ]);

    $width  = 200;
    $height = 70;
    $image  = imagecreatetruecolor($width, $height);

    // Background terang random
    $bgColor = imagecolorallocate($image, rand(220,255), rand(220,255), rand(220,255));
    imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

    // Noise titik
    for ($i = 0; $i < 500; $i++) {
        $noiseColor = imagecolorallocate($image, rand(150,220), rand(150,220), rand(150,220));
        imagesetpixel($image, rand(0,$width), rand(0,$height), $noiseColor);
    }

    // Garis lurus acak
    for ($i = 0; $i < 12; $i++) {
        $lineColor = imagecolorallocate($image, rand(80,180), rand(80,180), rand(80,180));
        imageline($image, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $lineColor);
    }

    // Garis zig-zag
    $zigzagColor = imagecolorallocate($image, rand(50,150), rand(50,150), rand(50,150));
    $points = [];
    $step = 20;
    for ($x = 0; $x <= $width; $x += $step) {
        $y = rand(10, $height - 10);
        $points[] = $x;
        $points[] = $y;
    }
    imagepolygon($image, $points, count($points)/2, $zigzagColor);

    // Font list
    $fonts = [
        FCPATH . 'assets/fonts/arial.ttf',
        FCPATH . 'assets/fonts/heavitas.ttf',
    ];

    $fontSize = 26;
    $x = 15;
    $y = 50;

    // Tulis huruf dengan shadow random
    for ($i = 0; $i < strlen($random_str); $i++) {
        $letter = strtoupper($random_str[$i]);
        $angle = rand(-25, 25);
        $font = $fonts[array_rand($fonts)];

        $textColor   = imagecolorallocate($image, rand(0,120), rand(0,120), rand(0,120));
        $shadowColor = imagecolorallocate($image, rand(100,180), rand(100,180), rand(100,180));

        // Random ketebalan shadow (1–3 pixel)
        $offset = rand(1,3);
        imagettftext($image, $fontSize, $angle, $x+$offset, $y+$offset, $shadowColor, $font, $letter);
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $font, $letter);

        $x += 30;
    }

    // Output
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
}
}
