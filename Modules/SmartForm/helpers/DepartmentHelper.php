<?php

namespace Modules\SmartForm\helpers;

class DepartmentHelper
{
    /**
     * Get all departments as an associative array
     * 
     * @return array
     */
    public static function getAllDepartments()
    {
        return [
            'ENG' => 'ENGINEERING',
            'SHE' => 'SHE',
            'PRD' => 'PRODUKSI',
            'SM' => 'SM',
            'IC' => 'IC',
            'GS' => 'GS',
            'RM' => 'PLANT',
            'BDV' => 'BUSDEV',
            'FIN' => 'FINANCE',
            'ATA' => 'Accounting & Tax',
            'DTC' => 'DATA CENTER',
            'MM' => 'LOGISTIK',
            'OPR' => 'OPERATION',
            'LEG' => 'LEGAL',
            'OD' => 'ORGANIZATION DEVELOPMENT',
            'Z001' => 'ASSESSMENT CENTER',
            'Z002' => 'LABOR SUPPLY',
            'Z003' => 'MANAGEMENT CONSULTANT',
            'Z004' => 'SERTIFIKASI',
            'TC' => 'TRAINING CENTER',
            'IT' => 'IT'
        ];
    }

    /**
     * Generate HTML options for department dropdown
     * 
     * @param string|null $selectedDept The currently selected department code
     * @param bool $isDisabled Whether the select should be disabled
     * @return string HTML options for department dropdown
     */
    public static function getDepartmentOptions($selectedDept = null, $isDisabled = false)
    {
        $departments = self::getAllDepartments();
        $options = '<option value="" selected>-- Pilih Departemen --</option>';
        
        foreach ($departments as $code => $name) {
            $selected = ($selectedDept == $code) ? 'selected' : '';
            $options .= "<option value=\"{$code}\" {$selected}>{$name}</option>";
        }
        
        return $options;
    }

    /**
     * Render a complete department select element
     * 
     * @param string $name The name attribute for the select element
     * @param string|null $selectedDept The currently selected department code
     * @param bool $isDisabled Whether the select should be disabled
     * @param bool $isRequired Whether the select is required
     * @param string $id The id attribute for the select element (defaults to name)
     * @param string $class Additional CSS classes
     * @return string Complete HTML select element
     */
    public static function renderDepartmentSelect($name, $selectedDept = null, $isDisabled = false, $isRequired = true, $id = null, $class = 'form-select input-text')
    {
        $id = $id ?? $name;
        $required = $isRequired ? 'required' : '';
        $disabled = $isDisabled ? 'disabled' : '';
        
        $html = "<select class=\"{$class}\" id=\"{$id}\" name=\"{$name}\" {$required} {$disabled}>";
        $html .= self::getDepartmentOptions($selectedDept, $isDisabled);
        $html .= "</select>";
        
        return $html;
    }
}