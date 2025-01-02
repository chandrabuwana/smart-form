<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSyarat extends Model
{
    public $table='training_syarat';
    protected $fillable = ['nama', 'nilai', 'operasi', 'uom'];
}
