<?php

namespace Modules\SmartForm\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Venturecraft\Revisionable\RevisionableTrait;

class CPMMForm extends Model
{
    use HasFactory, RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    public $table='cpm_m_form';
    public $timestamps = true;
    protected $fillable = [
        'created_by', 'updated_by', 'is_deleted', 'stts', 'KodeST', 'TanggalSubmit', 'keterangan'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(CPMMFormDtl::class, 'id_m_cpm');
    }

    // protected function casts(): array
    // {
    //     return [
    //         'created_at' => 'datetime',
    //         'updated_at' => 'datetime',
    //         'stts' => 'integer',
    //         'id_m_cpm' => 'integer',
    //         'id_m_obj' => 'integer',
    //     ];
    // }
}
