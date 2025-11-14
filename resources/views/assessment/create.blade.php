@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4 border-bottom pb-2">
        <h1 class="h4 fw-bold mb-1">New ICT Equipment Assessment</h1>
        <p class="text-muted">Complete each section below to register a new assessment.</p>
    </div>

    <!-- Back/Cancel button -->
    <div class="mb-3">
        <a href="{{ route('assessment.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back / Cancel
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-3 p-4 mb-4">
        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="alert alert-danger">
            <h6 class="fw-semibold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following:</h6>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('assessment.store') }}" method="POST" id="assessment-form">
            @csrf

            {{-- ================= STEP 1: BASIC INFORMATION ================= --}}
            <div class="card mb-4">
                <div class="card-header fw-semibold bg-dark text-white">
                    <i class="bi bi-1-circle me-1"></i> Basic Information
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <select name="department" id="department" class="form-select" required>
                                <option value="">Select Department</option>
                                @foreach($deptSecList as $deptCode => $divisions)
                                <option value="{{ $deptCode }}">{{ $deptCode }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6" id="division-container">
                            <!-- Populated dynamically -->
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Accountable Person</label>
                            <input type="text" name="name" id="name" maxlength="64" required class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="care_of" class="form-label">Care of</label>
                            <input type="text" name="care_of" id="care_of" maxlength="64" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= STEP 2: EQUIPMENT DETAILS ================= --}}
            <div class="card mb-4">
                <div class="card-header fw-semibold bg-dark text-white">
                    <i class="bi bi-2-circle me-1"></i> Equipment Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Equipment Type</label>
                        <select name="equipment_type" id="equipment_type" class="form-select" required>
                            <option value="">Select equipment type</option>
                            <option value="Desktop Computer">Desktop Computer</option>
                            <option value="Laptop Computer">Laptop Computer</option>
                            <option value="Network Printer / All-in-one Printer">Network Printer / All-in-one Printer</option>
                            <option value="Tablet / IPad">Tablet / iPad</option>
                            <option value="Server Computer">Server Computer</option>
                        </select>
                    </div>

                    <div id="specification-section" class="d-none">
                        <h6 class="fw-semibold mb-3">Specifications</h6>
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            <div class="col" id="model-container">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" name="model" id="model" maxlength="64" class="form-control" required>
                            </div>
                            <div class="col" id="date_acquired_container">
                                <label for="date_acquired" class="form-label">Date Acquired</label>
                                <input type="date" name="date_acquired" id="date_acquired" class="form-control" required>
                            </div>
                            <div class="col" id="date_assessed_container">
                                <label for="date_assessed" class="form-label">Date Assessed</label>
                                <input type="date" name="date_assessed" id="date_assessed" class="form-control">
                            </div>

                            {{-- Hidden fields that appear based on equipment type --}}
                            <div class="col d-none" id="field_motherboard">
                                <label for="motherboard" class="form-label">Motherboard</label>
                                <input type="text" name="motherboard" id="motherboard" maxlength="64" class="form-control">
                            </div>
                            <div class="col d-none" id="field_processor">
                                <label for="processor" class="form-label">Processor</label>
                                <input type="text" name="processor" id="processor" maxlength="64" class="form-control">
                            </div>
                            <div class="col d-none" id="field_memory">
                                <label for="memory" class="form-label">Memory</label>
                                <input type="text" name="memory" id="memory" maxlength="64" class="form-control">
                            </div>
                            <div class="col d-none" id="field_harddisk">
                                <label for="harddisk_capacity" class="form-label">Storage Device</label>
                                <input type="text" name="harddisk_capacity" id="harddisk_capacity" maxlength="64" class="form-control">
                            </div>
                            <div class="col d-none" id="field_os">
                                <label for="os" class="form-label">Operating System</label>
                                <input type="text" name="os" id="os" maxlength="64" class="form-control">
                            </div>
                            <div class="col d-none" id="field_ms_office">
                                <label for="ms_office" class="form-label">MS Office</label>
                                <input type="text" name="ms_office" id="ms_office" maxlength="64" class="form-control">
                            </div>
                        </div>

                        {{-- Network section --}}
                        <div id="field_network" class="mt-3 d-none">
                            <h6 class="fw-semibold mb-2">Network Connectivity</h6>
                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                <div class="col">
                                    <label for="lan_connected" class="form-label">LAN Connected</label>
                                    <select name="lan_connected" id="lan_connected" class="form-select">
                                        <option value="">Select...</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="internet_connected" class="form-label">Internet Connected</label>
                                    <select name="internet_connected" id="internet_connected" class="form-select">
                                        <option value="">Select...</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= STEP 3: ANALYSIS & RECOMMENDATION ================= --}}
            <div class="card mb-4">
                <div class="card-header fw-semibold bg-dark text-white">
                    <i class="bi bi-3-circle me-1"></i> Analysis & Recommendation
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3 g-3">
                        <div class="col">
                            <label for="condition" class="form-label">Condition</label>
                            <select name="condition" id="condition" class="form-select" required>
                                <option value="">Select condition</option>
                                <option value="serviceable">Serviceable</option>
                                <option value="for_repair">For Repair</option>
                                <option value="unserviceable">Unserviceable</option>
                            </select>
                        </div>
                        <div class="col d-none" id="section_analysis">
                            <label class="form-label">Analysis</label>
                            <div id="analysis_output"></div>
                        </div>
                        <div class="col d-none" id="section_recommendation">
                            <label class="form-label">Recommendation</label>
                            <div id="recommendation_output"></div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 d-none" id="section_remarks">
                            <label for="remarks" class="form-label">Remarks (Optional)</label>
                            <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Additional notes...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= ASSESSED BY ================= --}}
            <div class="card mb-4">
                <div class="card-header fw-semibold bg-dark text-white">
                    <i class="bi bi-person-badge me-1"></i> Assessment Details
                </div>
                <div class="card-body">
                    <label for="assessed_by" class="form-label">Assessed By</label>
                    <input type="text" name="assessed_by" id="assessed_by" maxlength="64" class="form-control" placeholder="e.g., MIS Team / Date">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-send"></i> Submit Assessment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Success</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Assessment added successfully!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ==================== DEPARTMENT / DIVISION ====================
    const department = document.getElementById('department');
    const divisionContainer = document.getElementById('division-container');
    const deptSecList = @json($deptSecList);

    function updateDivisions() {
        const selectedDept = department.value;
        divisionContainer.innerHTML = '<label class="form-label">Division</label>';

        if (!selectedDept) {
            divisionContainer.innerHTML += '<div class="form-control bg-light">Select a department first</div>';
            return;
        }

        const divisions = deptSecList[selectedDept] || [];
        if (divisions.length === 0) {
            divisionContainer.innerHTML += '<div class="form-control bg-light">No divisions available</div>';
            return;
        }

        if (divisions.length === 1) {
            divisionContainer.innerHTML += `
                <div class="form-control bg-light">${divisions[0]}</div>
                <input type="hidden" name="division" value="${divisions[0]}">
            `;
            return;
        }

        const select = document.createElement('select');
        select.name = 'division';
        select.className = 'form-select';
        select.required = true;
        select.innerHTML = '<option value="">Select Division</option>' +
            divisions.map(d => `<option value="${d}">${d}</option>`).join('');
        divisionContainer.appendChild(select);
    }

    if (department) {
        department.addEventListener('change', updateDivisions);
        updateDivisions();
    }

    // ==================== EQUIPMENT TYPE ====================
    const equipmentType = document.getElementById('equipment_type');
    const specSection = document.getElementById('specification-section');
    const fieldMap = {
        motherboard: 'field_motherboard',
        processor: 'field_processor',
        memory: 'field_memory',
        harddisk: 'field_harddisk',
        network: 'field_network',
        os: 'field_os',
        ms_office: 'field_ms_office'
    };

    const config = {
        'Desktop Computer': ['motherboard', 'processor', 'memory', 'harddisk', 'network', 'os', 'ms_office'],
        'Laptop Computer': ['processor', 'memory', 'harddisk', 'network', 'os', 'ms_office'],
        'Network Printer / All-in-one Printer': ['network'],
        'Tablet / IPad': [],
        'Server Computer': ['motherboard', 'processor', 'memory', 'harddisk', 'network', 'os']
    };

    function updateFields() {
        const selected = equipmentType.value;
        const show = config[selected] || [];
        specSection.classList.toggle('d-none', !selected);

        // Reset all fields
        Object.values(fieldMap).forEach(id => {
            const field = document.getElementById(id);
            field.classList.add('d-none');
            field.querySelectorAll('input, select').forEach(i => {
                if (i.tagName === 'SELECT') i.selectedIndex = 0;
                else i.value = '';
            });
        });

        ['model', 'date_acquired', 'date_assessed'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });

        ['lan_connected', 'internet_connected'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.selectedIndex = 0;
        });

        // Show relevant fields
        show.forEach(key => document.getElementById(fieldMap[key]).classList.remove('d-none'));
    }

    if (equipmentType) {
        equipmentType.addEventListener('change', updateFields);
        updateFields();
    }

    // ==================== CONDITION / ANALYSIS / RECOMMENDATION ====================
    const condition = document.getElementById('condition');
    const analysisOutput = document.getElementById('analysis_output');
    const recommendationOutput = document.getElementById('recommendation_output');

    // Hidden inputs to store values for submission
    const hiddenAnalysisInput = document.createElement('input');
    hiddenAnalysisInput.type = 'hidden';
    hiddenAnalysisInput.name = 'analysis';
    document.body.appendChild(hiddenAnalysisInput);

    const hiddenRecommendationInput = document.createElement('input');
    hiddenRecommendationInput.type = 'hidden';
    hiddenRecommendationInput.name = 'recommendation';
    document.body.appendChild(hiddenRecommendationInput);

    const opts = {
        serviceable: {
            analysis: [
                { value: 'good_condition', label: 'Good condition' },
                { value: 'medium_dependable', label: 'Medium but dependable' },
                { value: 'slow_poor', label: 'Slow / Poor' }
            ],
            recommendation: {
                good_condition: [{ value: 'no_need_new_unit', label: 'No need to acquire new unit' }],
                medium_dependable: [
                    { value: 'no_need_new_unit', label: 'No need to acquire new unit' },
                    { value: 'needs_upgrading', label: 'Needs upgrading' }
                ],
                slow_poor: [
                    { value: 'needs_upgrading', label: 'Needs upgrading' },
                    { value: 'recommended_replacement', label: 'Recommended for replacement' }
                ]
            }
        },
        for_repair: {
            analysis: [
                { value: 'in_house', label: 'In-house repair' },
                { value: 'out_source', label: 'Out-source' }
            ],
            recommendation: [
                { value: 'no_need_new_unit', label: 'No need to acquire new unit after reparation.' },
                { value: 'recommended_replacement', label: 'Recommended for replacement' }
            ]
        },
        unserviceable: {
            analysis: [{ value: 'return_to_property', label: 'For Return to Property' }],
            recommendation: [{ value: 'return_to_property', label: 'For Return to Property' }]
        }
    };

    function populateAnalysis(cond) {
        const condObj = opts[cond];
        if (!condObj) {
            // Reset both analysis and recommendation dropdowns
            analysisOutput.innerHTML = `<select name="analysis" class="form-select" required>
                <option value="">Select an analysis</option>
            </select>`;
            recommendationOutput.innerHTML = `<select name="recommendation" class="form-select" required>
                <option value="">Select a recommendation</option>
            </select>`;
            return;
        }

        // Populate analysis dropdown
        const analysisOptions = condObj.analysis;
        analysisOutput.innerHTML = `<select name="analysis" class="form-select" required>
            <option value="">Select</option>
            ${analysisOptions.map(a => `<option value="${a.value}">${a.label}</option>`).join('')}
        </select>`;

        const analysisSelect = analysisOutput.querySelector('select');
        if (analysisOptions.length === 1) {
            // Auto-select the only option and gray out the dropdown
            analysisSelect.value = analysisOptions[0].value;
            analysisSelect.disabled = true;

            // Update hidden input
            hiddenAnalysisInput.value = analysisOptions[0].value;
        } else {
            analysisSelect.disabled = false; // Ensure dropdown is enabled
            hiddenAnalysisInput.value = ''; // Clear hidden input
        }

        // Reset recommendation dropdown
        populateRecommendation(cond, null);

        // Add event listener to update recommendation when analysis changes
        analysisSelect.addEventListener('change', e => {
            hiddenAnalysisInput.value = e.target.value; // Update hidden input
            populateRecommendation(cond, e.target.value);
        });
    }

    function populateRecommendation(cond, analysisVal) {
        const condObj = opts[cond];
        if (!condObj) return;

        let recOptions = [];
        if (Array.isArray(condObj.recommendation)) {
            recOptions = condObj.recommendation;
        } else if (analysisVal && condObj.recommendation[analysisVal]) {
            recOptions = condObj.recommendation[analysisVal];
        }

        recommendationOutput.innerHTML = `<select name="recommendation" class="form-select" required>
            <option value="">Select</option>
            ${recOptions.map(r => `<option value="${r.value}">${r.label}</option>`).join('')}
        </select>`;

        const recommendationSelect = recommendationOutput.querySelector('select');
        if (recOptions.length === 1) {
            // Auto-select the only option and gray out the dropdown
            recommendationSelect.value = recOptions[0].value;
            recommendationSelect.disabled = true;

            // Update hidden input
            hiddenRecommendationInput.value = recOptions[0].value;
        } else {
            recommendationSelect.disabled = false; // Ensure dropdown is enabled
            hiddenRecommendationInput.value = ''; // Clear hidden input
        }

        // Add event listener to update hidden input when recommendation changes
        recommendationSelect.addEventListener('change', e => {
            hiddenRecommendationInput.value = e.target.value; // Update hidden input
        });
    }

    if (condition) {
        // Keep analysis and recommendation always visible
        document.getElementById('section_analysis').classList.remove('d-none');
        document.getElementById('section_recommendation').classList.remove('d-none');

        // Add event listener to update analysis and recommendation when condition changes
        condition.addEventListener('change', e => {
            populateAnalysis(e.target.value);
        });

        // Initialize with default values
        populateAnalysis(condition.value);
    }

    // ==================== AJAX FORM SUBMISSION ====================
    const form = document.getElementById('assessment-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Create FormData object
            const formData = new FormData(form);

            // Manually add hidden inputs to FormData
            formData.set('analysis', hiddenAnalysisInput.value);
            formData.set('recommendation', hiddenRecommendationInput.value);

            // Get the HTTP method
            const method = form.querySelector('input[name=_method]')?.value || form.method;

            fetch(form.action, {
                method: method.toUpperCase(),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                if (!res.ok) {
                    const text = await res.text();
                    console.error('Laravel error:', text);
                    throw new Error('HTTP ' + res.status);
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();

                    // Reset the form after successful submission
                    form.reset();
                    hiddenAnalysisInput.value = ''; // Clear hidden analysis input
                    hiddenRecommendationInput.value = ''; // Clear hidden recommendation input
                    populateAnalysis(condition.value); // Reinitialize analysis and recommendation
                } else {
                    alert(data.message || 'Failed to submit assessment.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred while submitting.');
            });
        });
    }
});
</script>
@endpush
