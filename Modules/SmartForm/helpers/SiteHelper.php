<?php

namespace Modules\SmartForm\helpers;

class SiteHelper
{
    /**
     * Get all sites as an array
     * 
     * @return array
     */
    public static function getAllSites()
    {
        return [
            'agm' => 'AGM',
            'mbl' => 'MBL',
            'mme' => 'MME',
            'mas' => 'MAS',
            'pmss' => 'PMSS',
            'taj' => 'TAJ',
            'bssr' => 'BSSR',
            'tdm' => 'TDM',
            'msj' => 'MSJ'
        ];
    }

    /**
     * Generate HTML options for site dropdown
     * 
     * @param string|null $selectedSite The currently selected site code
     * @param bool $isDisabled Whether the select should be disabled
     * @return string HTML options for site dropdown
     */
    public static function getSiteOptions($selectedSite = null, $isDisabled = false)
    {
        $sites = self::getAllSites();
        $options = '<option value="">-- Pilih Site --</option>';
        
        foreach ($sites as $code => $name) {
            $selected = ($selectedSite == $code) ? 'selected' : '';
            $options .= "<option value=\"{$code}\" {$selected}>{$name}</option>";
        }
        
        return $options;
    }

    /**
     * Render a complete site select element
     * 
     * @param string $name The name attribute for the select element
     * @param string|null $selectedSite The currently selected site code
     * @param bool $isDisabled Whether the select should be disabled
     * @param bool $isRequired Whether the select is required
     * @param string $id The id attribute for the select element (defaults to name)
     * @param string $class Additional CSS classes
     * @return string Complete HTML select element
     */
    public static function renderSiteSelect($name, $selectedSite = null, $isDisabled = false, $isRequired = true, $id = null, $class = 'form-select input-text')
    {
        $id = $id ?? $name;
        $required = $isRequired ? 'required' : '';
        $disabled = $isDisabled ? 'disabled' : '';
        
        $html = "<select class=\"{$class}\" id=\"{$id}\" name=\"{$name}\" {$required} {$disabled}>";
        $html .= self::getSiteOptions($selectedSite, $isDisabled);
        $html .= "</select>";
        
        return $html;
    }
}