<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Equipment condition counts
        $conditionData = Assessment::select('condition', DB::raw('COUNT(*) as total'))
            ->groupBy('condition')
            ->pluck('total', 'condition');

        // Department counts (replace 'department' with actual column if needed)
        $departmentData = Assessment::select('department', DB::raw('COUNT(*) as total'))
            ->groupBy('department')
            ->pluck('total', 'department');

        return view('dashboard', compact('conditionData', 'departmentData'));
    }
}
