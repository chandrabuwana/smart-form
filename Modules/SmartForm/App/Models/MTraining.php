<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MTraining extends Model
{
    public $table='m_training';
    protected $fillable = [
        'nama', 'slug', 'estimasi_sertifikat_keluar', 'harga', 'training_kategori_code',
        'keterangan', 'kode_material', 'kondisi_saat_ini', 'materi_yg_diiginkan', 'metode_evaluasi'
    ];
}
