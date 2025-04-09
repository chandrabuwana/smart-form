<?php

namespace Modules\SmartForm\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venturecraft\Revisionable\RevisionableTrait;

class CPMApproval extends Model
{
    use HasFactory, RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    public $table='cpm_approval';
    public $timestamps = true;
    protected $fillable = [
        'id_m_cpm', 'id_m_approval', 'stts', 'urutan', 'sebagai', 
        'urutan', 'created_by', 'updated_by', 'is_deleted', 'keterangan'
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(CPMMForm::class, 'id_m_cpm');
    }

    public function mApproval(): BelongsTo
    {
        return $this->belongsTo(CPMMFormApproval::class, 'id_m_approval');
    }
}
