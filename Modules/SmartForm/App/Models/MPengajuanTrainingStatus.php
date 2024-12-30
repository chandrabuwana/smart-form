<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MPengajuanTrainingStatus extends Model
{
    public $table='m_pengajuan_training_status';
    public $timestamps = false;
    protected $fillable = [
        'status_id', 'nama', 'keterangan'
    ];
}
