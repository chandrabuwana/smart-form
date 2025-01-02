<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TRJ extends Model
{
    public $table = 'training_rekomendasi_justifikasi';
    public $timestamps = false;
    protected $fillable = [
        'pengajuan_training_id', 'tanggal', 'jam', 'tempat', 'jenis', 
        'keterangan','kodeDP', 'KodeST', 'status'
    ];
}
