<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MandatoryType extends Model
{
    public $table='mandatory_type';
    public $timestamps = false;
    protected $fillable = [
        'id', 'nama'
    ];
}
