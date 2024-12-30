<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MApprovalRole extends Model
{
    public $table='m_approval_role';
    public $timestamps = false;
    protected $fillable = [
        'approval_role', 'nama', 'keterangan'
    ];
}
