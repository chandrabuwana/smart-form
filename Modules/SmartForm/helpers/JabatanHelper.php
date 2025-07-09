<?php

namespace Modules\SmartForm\helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class JabatanHelper
{
    private const DB_HRD = "HRD";
    private const TABLE_JABATAN_HRD = self::DB_HRD . ".dbo.tjabatan";  // lowercase as seen in your database
    private const DB_CONN2_NAME = 'sqlsrv2';

    /**
     * Get all positions/job titles as an associative array
     * 
     * @return array
     */
    public static function getAllJabatan()
    {
        return Cache::remember('all_jabatan', 60 * 60 * 24, function () {
            try {
                try {
                    DB::connection(self::DB_CONN2_NAME)->getPdo();
                } catch (\Exception $e) {
                    Log::error('Database connection failed for jabatan', [
                        'error' => $e->getMessage()
                    ]);
                    return self::getFallbackJabatan();
                }
                
                try {
                    $positions = DB::connection(self::DB_CONN2_NAME)
                        ->table(DB::raw(self::TABLE_JABATAN_HRD))
                        ->select([
                            'KodeJB as jabatan_code',
                            'Nama as jabatan_name'
                        ])
                        ->orderBy('KodeJB')
                        ->get();
                    
                    if ($positions->isEmpty()) {
                        Log::warning('No positions found in database with standard query');
                        return self::getFallbackJabatan();
                    }
                    
                    $result = [];
                    foreach ($positions as $position) {
                        $originalCode = $position->jabatan_code;
                        $result[$originalCode] = $position->jabatan_name;
                        $result[strtolower($originalCode)] = $position->jabatan_name;
                    }
                    
                    return $result;
                    
                } catch (\Exception $e) {
                    Log::error('Query execution failed for jabatan: ' . $e->getMessage());
                    
                    try {
                        $sql = "SELECT KodeJB as jabatan_code, Nama as jabatan_name FROM " . self::TABLE_JABATAN_HRD;
                        $positions = DB::connection(self::DB_CONN2_NAME)->select($sql);
                        
                        if (empty($positions)) {
                            Log::warning('No positions found with direct SQL query');
                            return self::getFallbackJabatan();
                        }
                        
                        $result = [];
                        foreach ($positions as $position) {
                            $originalCode = $position->jabatan_code;
                            $result[$originalCode] = $position->jabatan_name;
                            $result[strtolower($originalCode)] = $position->jabatan_name;
                        }
                        
                        return $result;
                    } catch (\Exception $innerE) {
                        Log::error('Direct SQL query failed for jabatan: ' . $innerE->getMessage());
                        return self::getFallbackJabatan();
                    }
                }
                
            } catch (\Exception $e) {
                Log::error('Error in getAllJabatan: ' . $e->getMessage());
                return self::getFallbackJabatan();
            }
        });
    }

    /**
     * Fallback positions/job titles in case of database error
     * 
     * @return array
     */
    private static function getFallbackJabatan()
    {
        $positions = [
            'DIR' => 'DIRECTOR',
            'GM' => 'GENERAL MANAGER',
            'MGR' => 'MANAGER',
            'SPVR' => 'SUPERVISOR',
            'COORD' => 'COORDINATOR',
            'STAFF' => 'STAFF',
            'OPR' => 'OPERATOR',
            'FOREMN' => 'FOREMAN',
            'HD' => 'HEAD',
            'ADMIN' => 'ADMINISTRATOR',
            'SUPT' => 'SUPERINTENDENT',
            'SEC' => 'SECRETARY',
            'DRV' => 'DRIVER',
            'ENG' => 'ENGINEER',
            'TECH' => 'TECHNICIAN',
            'MECH' => 'MECHANIC',
            'ASST' => 'ASSISTANT'
        ];
        
        $result = [];
        foreach ($positions as $code => $name) {
            $result[$code] = $name;
            $result[strtolower($code)] = $name;
        }
        
        return $result;
    }

    /**
     * Get position/job title name by code
     * 
     * @param string $jabatanCode The position code to look up
     * @return string The position name or the original code if not found
     */
    public static function getJabatanNameByCode($jabatanCode)
    {
        if (empty($jabatanCode)) {
            return '';
        }
        
        $positions = self::getAllJabatan();
        
        if (isset($positions[$jabatanCode])) {
            return $positions[$jabatanCode];
        }
        
        $lowerJabatanCode = strtolower($jabatanCode);
        if (isset($positions[$lowerJabatanCode])) {
            return $positions[$lowerJabatanCode];
        }
        
        try {
            $position = DB::connection(self::DB_CONN2_NAME)
                ->table(DB::raw(self::TABLE_JABATAN_HRD))
                ->select('Nama as jabatan_name')
                ->where('KodeJB', $jabatanCode)
                ->first();
                
            if ($position) {
                return $position->jabatan_name;
            }
        } catch (\Exception $e) {
            Log::error('Error looking up position name for code: ' . $jabatanCode, [
                'error' => $e->getMessage()
            ]);
        }
        
        return $jabatanCode;
    }

    /**
     * Generate HTML options for position/job title dropdown
     * 
     * @param string|null $selectedJabatan The currently selected position code
     * @param bool $isDisabled Whether the select should be disabled
     * @return string HTML options for position dropdown
     */
    public static function getJabatanOptions($selectedJabatan = null, $isDisabled = false)
    {
        $positions = self::getAllJabatan();
        $options = '<option value="">-- Pilih Jabatan --</option>';
        
        $uniqueCodes = [];
        foreach ($positions as $code => $name) {
            $upperCode = strtoupper($code);
            $uniqueCodes[$upperCode] = true;
        }
        
        foreach (array_keys($uniqueCodes) as $upperCode) {
            $selected = '';
            if ($selectedJabatan !== null) {
                if (strtoupper($selectedJabatan) === $upperCode) {
                    $selected = 'selected';
                }
            }
            
            $jabatanName = $positions[$upperCode] ?? $positions[strtolower($upperCode)] ?? $upperCode;
            
            $options .= "<option value=\"{$upperCode}\" {$selected}>{$upperCode} - {$jabatanName}</option>";
        }
        
        return $options;
    }

    /**
     * Render a complete position/job title select element
     * 
     * @param string $name The name attribute for the select element
     * @param string|null $selectedJabatan The currently selected position code
     * @param bool $isDisabled Whether the select should be disabled
     * @param bool $isRequired Whether the select is required
     * @param string $id The id attribute for the select element (defaults to name)
     * @param string $class Additional CSS classes
     * @return string Complete HTML select element
     */
    public static function renderJabatanSelect($name, $selectedJabatan = null, $isDisabled = false, $isRequired = true, $id = null, $class = 'form-select input-text')
    {
        $id = $id ?? $name;
        $required = $isRequired ? 'required' : '';
        $disabled = $isDisabled ? 'disabled' : '';
        
        $html = "<select class=\"{$class}\" id=\"{$id}\" name=\"{$name}\" {$required} {$disabled}>";
        $html .= self::getJabatanOptions($selectedJabatan, $isDisabled);
        $html .= "</select>";
        
        return $html;
    }
    
    /**
     * Get position/job title name with code
     * 
     * @param string $jabatanCode The position code to look up
     * @return string The position code and name or just the code if not found
     */
    public static function getJabatanNameWithCode($jabatanCode)
    {
        if (empty($jabatanCode)) {
            return '';
        }
        
        $jabatanName = self::getJabatanNameByCode($jabatanCode);
        
        if ($jabatanName !== $jabatanCode) {
            return $jabatanCode . ' - ' . $jabatanName;
        }
        
        return $jabatanCode;
    }
}