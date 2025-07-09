<?php

namespace Modules\SmartForm\helpers;

class ShiftHelper
{
    /**
     * Get all shifts as an associative array
     * 
     * @return array
     */
    public static function getAllShifts()
    {
        return [
            'DS' => 'DS',
            'NS' => 'NS'
        ];
    }

    /**
     * Generate HTML options for shift dropdown
     * 
     * @param string|null $selectedShift The currently selected shift code
     * @param bool $isDisabled Whether the select should be disabled
     * @return string HTML options for shift dropdown
     */
    public static function getShiftOptions($selectedShift = null, $isDisabled = false)
    {
        $shifts = self::getAllShifts();
        $options = '<option value="">-- Pilih Shift --</option>';
        
        foreach ($shifts as $code => $name) {
            $selected = ($selectedShift == $code) ? 'selected' : '';
            $options .= "<option value=\"{$code}\" {$selected}>{$name}</option>";
        }
        
        return $options;
    }

    /**
     * Render a complete shift select element
     * 
     * @param string $name The name attribute for the select element
     * @param string|null $selectedShift The currently selected shift code
     * @param bool $isDisabled Whether the select should be disabled
     * @param bool $isRequired Whether the select is required
     * @param string $id The id attribute for the select element (defaults to name)
     * @param string $class Additional CSS classes
     * @return string Complete HTML select element
     */
    public static function renderShiftSelect($name, $selectedShift = null, $isDisabled = false, $isRequired = true, $id = null, $class = 'form-control')
    {
        $id = $id ?? $name;
        $required = $isRequired ? 'required' : '';
        $disabled = $isDisabled ? 'disabled' : '';
        
        $html = "<select class=\"{$class}\" id=\"{$id}\" name=\"{$name}\" {$required} {$disabled}>";
        $html .= self::getShiftOptions($selectedShift, $isDisabled);
        $html .= "</select>";
        
        return $html;
    }
}