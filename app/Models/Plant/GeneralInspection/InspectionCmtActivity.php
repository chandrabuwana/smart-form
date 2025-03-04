<?php

namespace App\Models\Plant\GeneralInspection;

use Illuminate\Database\Eloquent\Model;

class InspectionCmtActivity extends Model
{
    protected $table = 'plant_general_inspection_cmt_activity';

    protected $fillable = [
        'inspection_cmt_id',
        'activity',
        'critical_point',
        'pre_inspect',
        'final_inspect',
        'delivery_inspect'
    ];

    public $timestamps = false;
}
