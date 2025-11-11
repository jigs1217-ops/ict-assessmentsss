<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Assessment;
use App\Helpers\DeptSecHelper;

class DashboardController extends Controller
{
    public function index()
    {
        // 1) Get aggregated counts from DB for the current user
        $userId = auth()->id();

        $rows = Assessment::select(
                'department',
                'division',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN date_assessed IS NULL THEN 1 ELSE 0 END) as pending')
            )
            ->where('user_id', $userId)
            ->groupBy('department', 'division')
            ->orderBy('department')
            ->orderBy('division')
            ->get();

        // If there are no rows at all, return empty
        if ($rows->isEmpty()) {
            return view('dashboard', ['dashboardData' => []]);
        }

        // 2) Load DeptSec helper for mapping department code -> display name (if available)
        $deptSecList = DeptSecHelper::DeptSecList();

        // 3) Build a grouped structure: department_code => [ department_name, divisions[...] ]
        $grouped = [];

        foreach ($rows as $r) {
            $deptCode = $r->department;
            $divisionName = $r->division;
            $total = (int) $r->total;
            $pending = (int) $r->pending;

            // find display name from helper if exists; fallback to deptCode
            $displayName = $deptCode;
            if (isset($deptSecList[$deptCode]) && count($deptSecList[$deptCode]) > 0) {
                $displayName = $deptSecList[$deptCode][0];
            }

            if (!isset($grouped[$deptCode])) {
                $grouped[$deptCode] = [
                    'department_code' => $deptCode,
                    'department_name' => $displayName,
                    'divisions' => [],
                ];
            }

            $grouped[$deptCode]['divisions'][] = [
                'division' => $divisionName,
                'total' => $total,
                'pending' => $pending,
            ];
        }

        // Convert grouped map to indexed array for blade
        $dashboardData = array_values($grouped);

        return view('dashboard', compact('dashboardData'));
    }
}
