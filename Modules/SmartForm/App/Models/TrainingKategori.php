<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingKategori extends Model
{
    public $timestamps = false;
    public $table='training_kategori';
    protected $fillable = [
        'code', 'nama'
    ];
}
