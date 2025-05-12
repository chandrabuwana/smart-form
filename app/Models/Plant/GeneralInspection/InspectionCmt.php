<?php

namespace App\Models\Plant\GeneralInspection;

use Illuminate\Database\Eloquent\Model;

class InspectionCmt extends Model {
    protected $table = 'plant_general_inspection_cmt';

    protected $fillable = [
        'site', 'model_unit', 'cn', 'hm', 'dilakukan1', 'dilakukan2', 'note', 'date_inspection', 'diperiksa', 'creator', 'diketahui', 'date_sign1', 'date_sign2', 'date_sign3', 'status', 'status_form', 'created_at', 'updated_at'
    ];

    public function inspectionActivity() {
        return $this->hasMany( InspectionCmtActivity::class, 'inspection_cmt_id' );
    }

    public function inspectionResult() {
        return $this->hasMany( InspectionCmtResult::class, 'inspection_cmt_id' );
    }
}
