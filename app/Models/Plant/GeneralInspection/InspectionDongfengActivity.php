<?php

namespace App\Models\Plant\GeneralInspection;

use Illuminate\Database\Eloquent\Model;

class InspectionDongfengActivity extends Model
{
    protected $table = 'plant_general_inspection_dongfeng_activity';

    protected $fillable = [
        'inspection_dongfeng_id',
        'activity',
        'critical_point',
        'pre_inspect',
        'final_inspect',
        'delivery_inspect'
    ];

    public $timestamps = false;
}
