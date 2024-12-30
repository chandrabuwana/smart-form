<?php

namespace Modules\SmartForm\App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisApproval extends Model
{
    public $table='jenis_approval';
    public $timestamps = false;
    protected $fillable = [
        'kdoe', 'nama', 'urutan'
    ];
}
