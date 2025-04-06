<?php

namespace Modules\SmartForm\helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SiteHelper
{
    private const DB_HRD = "HRD";
    private const TABLE_SITE_HRD = self::DB_HRD . ".dbo.TSite";
    private const DB_CONN2_NAME = 'sqlsrv2';

    /**
     * Get all sites from database or fallback to hardcoded values
     */
    public static function getAllSites()
    {
        return Cache::remember('site_list', 60 * 60 * 24, function () {
            try {
                try {
                    DB::connection(self::DB_CONN2_NAME)->getPdo();
                } catch (\Exception $e) {
                    Log::error('Database connection failed for sites', [
                        'error' => $e->getMessage()
                    ]);
                    return self::getFallbackSites();
                }
                
                try {
                    $sites = DB::connection(self::DB_CONN2_NAME)
                        ->table(DB::raw(self::TABLE_SITE_HRD))
                        ->select([
                            'KodeST as site_code',
                            'Nama as site_name'
                        ])
                        ->where('Aktif', 0)
                        ->get();
                    
                    if ($sites->isEmpty()) {
                        return self::getFallbackSites();
                    }
                    
                    $result = [];
                    foreach ($sites as $site) {
                        $result[strtolower($site->site_code)] = $site->site_name;
                        $result[$site->site_code] = $site->site_name;
                    }
                    
                    return $result;
                    
                } catch (\Exception $e) {
                    Log::error('Query execution failed for sites', [
                        'error' => $e->getMessage()
                    ]);
                    return self::getFallbackSites();
                }
                
            } catch (\Exception $e) {
                Log::error('Error in getAllSites: ' . $e->getMessage());
                return self::getFallbackSites();
            }
        });
    }

    /**
     * Fallback list of sites in case the database is unavailable
     */
    private static function getFallbackSites() 
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
            'msj' => 'MSJ',
            'AGM' => 'AGM',
            'MBL' => 'MBL',
            'MME' => 'MME',
            'MAS' => 'MAS',
            'PMSS' => 'PMSS',
            'TAJ' => 'TAJ',
            'BSSR' => 'BSSR',
            'TDM' => 'TDM',
            'MSJ' => 'MSJ'
        ];
    }

    /**
     * Get site name by site code
     */
    public static function getSiteNameByCode($siteCode)
    {
        if (empty($siteCode)) {
            return '';
        }
        
        $sites = self::getAllSites();
        
        if (isset($sites[$siteCode])) {
            return $sites[$siteCode];
        }
        
        $lowerSiteCode = strtolower($siteCode);
        if (isset($sites[$lowerSiteCode])) {
            return $sites[$lowerSiteCode];
        }
        
        try {
            $site = DB::connection(self::DB_CONN2_NAME)
                ->table(DB::raw(self::TABLE_SITE_HRD))
                ->select('Nama as site_name')
                ->where('KodeST', $siteCode)
                ->where('Aktif', 0)
                ->first();
                
            if ($site) {
                return $site->site_name;
            }
        } catch (\Exception $e) {
            Log::error('Error looking up site name for code: ' . $siteCode, [
                'error' => $e->getMessage()
            ]);
        }
        
        return $siteCode;
    }

    /**
     * Generate HTML options for site dropdown
     */
    public static function getSiteOptions($selectedSite = null, $isDisabled = false)
    {
        $sites = self::getAllSites();
        $options = '<option value="">-- Pilih Site --</option>';
        
        $uniqueCodes = [];
        foreach ($sites as $code => $name) {
            $upperCode = strtoupper($code);
            $uniqueCodes[$upperCode] = true;
        }
        
        foreach (array_keys($uniqueCodes) as $upperCode) {
            $selected = '';
            if ($selectedSite !== null) {
                if (strtoupper($selectedSite) === $upperCode) {
                    $selected = 'selected';
                }
            }
            
            $siteName = $sites[$upperCode] ?? $sites[strtolower($upperCode)] ?? $upperCode;
            
            $options .= "<option value=\"{$upperCode}\" {$selected}>{$upperCode} - {$siteName}</option>";
        }
        
        return $options;
    }

    /**
     * Render a complete site select element
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