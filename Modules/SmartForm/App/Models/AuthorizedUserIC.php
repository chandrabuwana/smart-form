<?php

namespace Modules\SmartForm\App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizedUserIC extends Model
{
    public $table='authorized_user';
    public $timestamps = false;
    protected $fillable = [
        'nik', 'nama'
    ];
}
