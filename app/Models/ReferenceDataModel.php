<?php
namespace App\Models;

use CodeIgniter\Model;

class ReferenceDataModel extends Model
{
    public function getJenjangPendidikan()
    {
        $jenjangPendidikan = [
        'tk'       => 'Taman Kanak-kanak (TK)',
        'sd'       => 'Sekolah Dasar (SD)',
        'smp'      => 'Sekolah Menengah Pertama (SMP)',
        'sma-smk'  => 'Sekolah Menengah Atas / SMK (SMA/SMK)',
        'd1'       => 'Diploma 1 (D1)',
        'd2'       => 'Diploma 2 (D2)',
        'd3'       => 'Diploma 3 (D3)',
        'd4'       => 'Diploma 4 (D4)',
        's1'       => 'Sarjana (S1)',
        's2'       => 'Magister (S2)',
        's3'       => 'Doktor (S3)',
        ];

        return $jenjangPendidikan;
    }

    public function getJurusanProfesi()
    {
        $jurusanProfesi = [
        // Tenaga Medis
        'dokter-umum'           => 'Dokter Umum',
        'dokter-spesialis'      => 'Dokter Spesialis',
        'dokter-gigi'           => 'Dokter Gigi',
        'dokter-gigi-spesialis' => 'Dokter Gigi Spesialis',
        'bidan'                 => 'Bidan',
        'perawat'               => 'Perawat',
        'perawat-gigi'          => 'Perawat Gigi',

        // Tenaga Kesehatan Lain
        'farmasi'               => 'Apoteker (Farmasi)',
        'asisten-apoteker'      => 'Tenaga Teknis Kefarmasian',
        'analis-kesehatan'      => 'Analis Kesehatan / Teknologi Laboratorium Medis',
        'sanitarian'            => 'Sanitarian (Kesehatan Lingkungan)',
        'gizi'                  => 'Ahli Gizi / Nutrisionis',
        'radiografer'           => 'Radiografer',
        'fisioterapis'          => 'Fisioterapis',
        'terapis-okupasi'       => 'Terapis Okupasi',
        'terapis-wicara'        => 'Terapis Wicara',
        'rekam-medis'           => 'Perekam Medis dan Informasi Kesehatan',
        'psikolog-klinis'       => 'Psikolog Klinis',
        'skm'                   => 'Sarjana Kesehatan Masyarakat (SKM)',

        // Lainnya
        'lainnya'               => 'Lainnya'
            ];

        return $jurusanProfesi;
    }
}