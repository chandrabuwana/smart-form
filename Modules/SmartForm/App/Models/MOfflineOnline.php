<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MOfflineOnline extends Model
{
    public $table='m_offline_online';
    public $timestamps = false;
    protected $fillable = [
        'id', 'nama'
    ];
}
