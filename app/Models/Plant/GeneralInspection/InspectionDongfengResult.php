<?php

namespace App\Models\Plant\GeneralInspection;

use Illuminate\Database\Eloquent\Model;

class InspectionDongfengResult extends Model
{
    protected $table = 'plant_general_inspection_dongfeng_result';

    protected $fillable = [
        'inspection_dongfeng_id',
        'component',
        'performance',
        'remark',
    ];

    public $timestamps = false;
}
