<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Helpers\DeptSecHelper;

class AssessmentController extends Controller
{
    /** Main assessment page + AJAX filtering */
public function assessment(Request $request)
{
    $deptSecList = DeptSecHelper::DeptSecList();
    $baseQuery = Assessment::where('user_id', auth()->id());

    // Get dynamic years for filters (only from user's own assessments)
    $acquiredYears = (clone $baseQuery)
        ->whereNotNull('date_acquired')
        ->pluck(\DB::raw('YEAR(date_acquired)'))
        ->unique()
        ->sortDesc()
        ->values()
        ->toArray();

    $assessedYears = (clone $baseQuery)
        ->whereNotNull('date_assessed')
        ->pluck(\DB::raw('YEAR(date_assessed)'))
        ->unique()
        ->sortDesc()
        ->values()
        ->toArray();

    // Build filtered query
    $query = clone $baseQuery;

    // Standard filters
    if ($request->filled('department')) $query->where('department', $request->department);
    if ($request->filled('division')) $query->where('division', $request->division);
    if ($request->filled('name')) $query->where('name', 'like', '%' . $request->name . '%');
    if ($request->filled('care_of')) $query->where('care_of', 'like', '%' . $request->care_of . '%');

    // Filter by type: "All", "Only Acquired", "Only Assessed"
    $filterType = $request->input('filter_type', 'all'); // Default to "all"
    if ($filterType === 'only_acquired') {
        $query->whereNull('date_assessed'); // Only acquired, not assessed
    } elseif ($filterType === 'only_assessed') {
        $query->whereNotNull('date_assessed'); // Only assessed (and therefore also acquired)
    }

    // Date Acquired: Year + Month
    if ($request->filled('acquired_year')) {
        $query->whereYear('date_acquired', $request->acquired_year);
        if ($request->filled('acquired_month')) {
            $query->whereMonth('date_acquired', $request->acquired_month);
        }
    }

    // Date Assessed: Year + Month
    if ($request->filled('assessed_year')) {
        $query->whereYear('date_assessed', $request->assessed_year);
        if ($request->filled('assessed_month')) {
            $query->whereMonth('date_assessed', $request->assessed_month);
        }
    }

    // Newest first for display
    $assessments = $query->orderByDesc('created_at')->paginate(12);

    // Dynamic numbering based on oldest = 1
    $allAssessments = $query->orderBy('created_at')->pluck('id')->toArray(); // oldest → newest
    $numbersMap = array_flip($allAssessments); // map id → index

    if ($request->ajax()) {
        return response()->json([
            'html' => view('assessment.partials.cards', compact('assessments', 'numbersMap'))->render(),
            'pagination' => (string) $assessments->appends($request->query())->links(),
        ]);
    }

    return view('assessment.assessment', compact(
        'assessments',
        'deptSecList',
        'acquiredYears',
        'assessedYears',
        'numbersMap'
    ));

}

    public function create()
    {
        $deptSecList = DeptSecHelper::DeptSecList();

        return view('assessment.create', compact('deptSecList'));
    }

    public function edit($id)
{
    $assessment = Assessment::findOrFail($id);
    $deptSecList = DeptSecHelper::DeptSecList(); // <- get department/division list

    return view('assessment.edit', compact('assessment', 'deptSecList'));
}

    public function store(Request $request)
    {
        $validated = $this->validateAssessment($request);
        $validated['user_id'] = auth()->id();

        $assessment = Assessment::create($validated);
        return response()->json(['success' => true, 'message' => 'Assessment added successfully!', 'assessment' => $assessment]);
    }

    public function viewbt(Assessment $assessment)
    {
        if ($assessment->user_id !== auth()->id()) abort(403);
        return response()->json([
            'html' => view('assessment.partials.viewbt', compact('assessment'))->render(),
        ]);
    }

    public function update(Request $request, Assessment $assessment)
    {
        if ($assessment->user_id !== auth()->id()) abort(403);

        $validated = $this->validateAssessment($request);
        $assessment->update($validated);

        return redirect()->route('assessment.index')->with('success', 'Assessment updated successfully!');

    }


    public function deletebt(Assessment $assessment)
    {
        if ($assessment->user_id !== auth()->id()) abort(403);
        $assessment->delete();

        return response()->json(['success' => true, 'message' => 'Assessment deleted successfully!']);
    }

    /** Validation logic */
    private function validateAssessment(Request $request)
    {
        $rules = [
            'department' => 'required|string',
            'division' => 'required|string',
            'name' => 'required|string|max:64',
            'care_of' => 'nullable|string|max:64',
            'equipment_type' => 'required|in:Desktop Computer,Laptop Computer,Network Printer / All-in-one Printer,Tablet / IPad,Server Computer',
            'model' => 'required|string|max:64',
            'date_acquired' => 'required|date',
            'date_assessed' => 'nullable|date',
            'condition' => 'required|in:serviceable,for_repair,unserviceable',
            'analysis' => 'required|string',
            'recommendation' => 'required|string',
            'remarks' => 'nullable|string|max:64',
            'assessed_by' => 'nullable|string|max:64',
        ];

        $equipment = $request->equipment_type;

        if (in_array($equipment, ['Desktop Computer', 'Server Computer'])) {
            $rules['motherboard'] = 'required|string|max:64';
        }
        if (in_array($equipment, ['Desktop Computer', 'Laptop Computer', 'Server Computer'])) {
            $rules['processor'] = 'required|string|max:64';
            $rules['memory'] = 'required|string|max:64';
            $rules['harddisk_capacity'] = 'required|string|max:64';
            $rules['os'] = 'required|string|max:64';
        }
        if (in_array($equipment, ['Desktop Computer', 'Laptop Computer'])) {
            $rules['ms_office'] = 'required|string|max:64';
        }
        if (in_array($equipment, [
            'Desktop Computer',
            'Laptop Computer',
            'Network Printer / All-in-one Printer',
            'Server Computer'
        ])) {
            $rules['lan_connected'] = 'required|in:yes,no';
            $rules['internet_connected'] = 'required|in:yes,no';
        }

        return $request->validate($rules);
    }
}
