<?php

namespace Modules\SmartForm\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CPMMFormDtl extends Model
{
    use HasFactory;

    public $table='cpm_m_form_dtl';
    public $timestamps = true;
    protected $fillable = [
        'id_m_obj', 'id_m_cpm', 'UOM', 'HIG_HIB' ,'created_by', 'updated_by', 'is_deleted', 'stts', 
        'plan_b_1', 'act_b_1', 'plan_b_2', 'act_b_2', 'plan_b_3', 'act_b_3', 'plan_b_4', 'act_b_4', 
        'plan_b_5', 'act_b_5', 'plan_b_6', 'act_b_6', 'plan_b_7', 'act_b_7', 'plan_b_8', 'act_b_8',
        'plan_b_9', 'act_b_9', 'plan_b_10', 'act_b_10', 'plan_b_11', 'act_b_11', 'plan_b_12', 'act_b_12',
        'plan_q1', 'act_q1', 'plan_q2', 'act_q2', 'plan_q3', 'act_q3', 'plan_q4', 'act_q4',
        'plan_yearly', 'act_yearly'
    ];
    protected $attributes = [
        'is_deleted' => 0,
        'stts' => 0,
        'act_b_1' => 0,
        'act_b_2' => 0,
        'act_b_3' => 0,
        'act_b_4' => 0,
        'act_b_5' => 0,
        'act_b_6' => 0,
        'act_b_7' => 0,
        'act_b_8' => 0,
        'act_b_9' => 0,
        'act_b_10' => 0,
        'act_b_11' => 0,
        'act_b_12' => 0
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(CPMMForm::class, 'id_m_cpm');
    }

    public function objective(): BelongsTo
    {
        return $this->belongsTo(CPMMForm::class, 'id_m_cpm');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'stts' => 'integer',
            'id_m_cpm' => 'integer',
            'id_m_obj' => 'integer',
        ];
    }
}
