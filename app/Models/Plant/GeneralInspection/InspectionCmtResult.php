<?php

namespace App\Models\Plant\GeneralInspection;

use Illuminate\Database\Eloquent\Model;

class InspectionCmtResult extends Model
{
    protected $table = 'plant_general_inspection_cmt_result';

    protected $fillable = [
        'inspection_cmt_id',
        'component',
        'performance',
        'remark',
    ];

    public $timestamps = false;
}
