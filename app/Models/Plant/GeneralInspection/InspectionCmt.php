<?php

namespace App\Models\Plant\GeneralInspection;

use Illuminate\Database\Eloquent\Model;

class InspectionCmt extends Model
{
    protected $table = 'plant_general_inspection_cmt';

    protected $fillable = [
        'site', 'model_unit', 'cn', 'hm'
    ];

    public function inspectionActivity()
    {
        return $this->hasMany(InspectionCmtActivity::class, 'inspection_cmt_id');
    }

    public function inspectionResult()
    {
        return $this->hasMany(InspectionCmtResult::class, 'inspection_cmt_id');
    }
}
