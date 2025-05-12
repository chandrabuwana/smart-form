<?php

namespace App\Models\Plant\GeneralInspection;

use Illuminate\Database\Eloquent\Model;

class InspectionDongfeng extends Model {
    protected $table = 'plant_general_inspection_dongfeng';

    protected $fillable = [
        'site', 'model_unit', 'cn', 'hm', 'dilakukan1', 'dilakukan2', 'diperiksa', 'note', 'date_inspection', 'creator', 'diketahui', 'date_sign1', 'date_sign2', 'date_sign3', 'status', 'created_at', 'updated_at'
    ];

    public function inspectionActivity() {
        return $this->hasMany( InspectionDongfengActivity::class, 'inspection_dongfeng_id' );
    }

    public function inspectionResult() {
        return $this->hasMany( InspectionDongfengResult::class, 'inspection_dongfeng_id' );
    }
}
