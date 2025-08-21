<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterTrainingModel extends Model
{
    protected $table = 'master_training';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; 
    protected $allowedFields = [
    'id',
    'kategori_pelatihan',
    'jenis_pelatihan',
    'nama_pelatihan',
    'tahun',
    'instansi_pengusul',
    'metode',
    'organisasi_profesi',
    'nakes_pks',
    'jpl',
    'angka_kredit',
    'skp',
    'maks_per_kelas',
    'tujuan',
    'kompetensi',
    'kriteria_peserta',
    'kriteria_pelatih',
    'status_aktif',
    'status_publish',
    'tgl_perubahan',
    'catatan',
    'kurikulum_klasikal',
    'kurikulum_full_online',
    'kurikulum_blended',
    'modul_klasikal',
    'modul_full_online',
    'modul_blended',
    'skenario_klasikal',
    'skenario_full_online',
    'skenario_blended'
    ];
}