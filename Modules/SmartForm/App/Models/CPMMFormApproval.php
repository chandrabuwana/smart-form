<?php

namespace Modules\SmartForm\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Venturecraft\Revisionable\RevisionableTrait;

class CPMMFormApproval extends Model
{
    use HasFactory, RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    public $table='cpm_m_form_approval';
    public $timestamps = true;
    protected $fillable = [
        'nik', 'KodeST', 'KodeDP', 'urutan', 'sebagai'
    ];

}
