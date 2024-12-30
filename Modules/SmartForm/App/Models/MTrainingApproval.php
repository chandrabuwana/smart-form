<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MTrainingApproval extends Model
{
    public $table='m_training_approval';
    public $timestamps = false;
    protected $fillable = [
        'nik', 'KodeDP', 'KodeST', 'approval_role'
    ];
}
