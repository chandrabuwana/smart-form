<?php

namespace Modules\SmartForm\helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DepartmentHelper
{
    private const DB_HRD = "HRD";
    private const TABLE_DEPARTMENT_HRD = self::DB_HRD . ".dbo.tdepartement";  // lowercase as seen in your database
    private const DB_CONN2_NAME = 'sqlsrv2';

    /**
     * Get all departments as an associative array
     * 
     * @return array
     */
    public static function getAllDepartments()
    {
        return Cache::remember('all_departments', 60 * 60 * 24, function () {
            try {
                try {
                    DB::connection(self::DB_CONN2_NAME)->getPdo();
                } catch (\Exception $e) {
                    Log::error('Database connection failed for departments', [
                        'error' => $e->getMessage()
                    ]);
                    return self::getFallbackDepartments();
                }
                
                try {
                    $departments = DB::connection(self::DB_CONN2_NAME)
                        ->table(DB::raw(self::TABLE_DEPARTMENT_HRD))
                        ->select([
                            'KodeDP as dept_code',
                            'Nama as dept_name'
                        ])
                        ->get();
                    
                    if ($departments->isEmpty()) {
                        return self::getFallbackDepartments();
                    }
                    
                    $result = [];
                    foreach ($departments as $dept) {
                        $result[strtolower($dept->dept_code)] = $dept->dept_name;
                        $result[$dept->dept_code] = $dept->dept_name;
                    }
                    
                    return $result;
                    
                } catch (\Exception $e) {
                    Log::error('Query execution failed for departments', [
                        'error' => $e->getMessage()
                    ]);
                    
                    try {
                        $sql = "SELECT KodeDP as dept_code, Nama as dept_name FROM " . self::TABLE_DEPARTMENT_HRD;
                        $departments = DB::connection(self::DB_CONN2_NAME)->select($sql);
                        
                        if (empty($departments)) {
                            return self::getFallbackDepartments();
                        }
                        
                        $result = [];
                        foreach ($departments as $dept) {
                            $result[strtolower($dept->dept_code)] = $dept->dept_name;
                            $result[$dept->dept_code] = $dept->dept_name;
                        }
                        
                        return $result;
                    } catch (\Exception $innerE) {
                        Log::error('Direct SQL query failed: ' . $innerE->getMessage());
                        return self::getFallbackDepartments();
                    }
                }
                
            } catch (\Exception $e) {
                Log::error('Error in getAllDepartments: ' . $e->getMessage());
                return self::getFallbackDepartments();
            }
        });
    }

    /**
     * Fallback departments in case of database error
     * 
     * @return array
     */
    private static function getFallbackDepartments()
    {
        $departments = [
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
        
        $result = [];
        foreach ($departments as $code => $name) {
            $result[$code] = $name;
            $result[strtolower($code)] = $name;
        }
        
        return $result;
    }

    /**
     * Get department name by department code
     * 
     * @param string $deptCode The department code to look up
     * @return string The department name or the original code if not found
     */
    public static function getDepartmentNameByCode($deptCode)
    {
        if (empty($deptCode)) {
            return '';
        }
        
        $departments = self::getAllDepartments();
        
        if (isset($departments[$deptCode])) {
            return $departments[$deptCode];
        }
        
        $lowerDeptCode = strtolower($deptCode);
        if (isset($departments[$lowerDeptCode])) {
            return $departments[$lowerDeptCode];
        }
        
        try {
            $dept = DB::connection(self::DB_CONN2_NAME)
                ->table(DB::raw(self::TABLE_DEPARTMENT_HRD))
                ->select('Nama as dept_name')
                ->where('KodeDP', $deptCode)
                ->first();
                
            if ($dept) {
                return $dept->dept_name;
            }
        } catch (\Exception $e) {
            Log::error('Error looking up department name for code: ' . $deptCode, [
                'error' => $e->getMessage()
            ]);
        }
        
        return $deptCode;
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
        $options = '<option value="">-- Pilih Departemen --</option>';
        
        $uniqueCodes = [];
        foreach ($departments as $code => $name) {
            $upperCode = strtoupper($code);
            $uniqueCodes[$upperCode] = true;
        }
        
        foreach (array_keys($uniqueCodes) as $upperCode) {
            $selected = '';
            if ($selectedDept !== null) {
                if (strtoupper($selectedDept) === $upperCode) {
                    $selected = 'selected';
                }
            }
            
            $deptName = $departments[$upperCode] ?? $departments[strtolower($upperCode)] ?? $upperCode;
            
            $options .= "<option value=\"{$upperCode}\" {$selected}>{$upperCode} - {$deptName}</option>";
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
    
    /**
     * Get department name with code
     * 
     * @param string $deptCode The department code to look up
     * @return string The department code and name or just the code if not found
     */
    public static function getDepartmentNameWithCode($deptCode)
    {
        if (empty($deptCode)) {
            return '';
        }
        
        $deptName = self::getDepartmentNameByCode($deptCode);
        
        if ($deptName !== $deptCode) {
            return $deptCode . ' - ' . $deptName;
        }
        
        return $deptCode;
    }
}