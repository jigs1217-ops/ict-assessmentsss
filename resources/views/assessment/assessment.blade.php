@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-dark mb-0">
            <i class="bi bi-clipboard2-data me-2"></i> Assessment Records
        </h4>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form id="filterForm" class="row g-2 align-items-end">
                <!-- Filter Type -->
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label fw-semibold text-secondary">Filter Type</label>
                    <select name="filter_type" id="filterType" class="form-select form-select-sm">
                        <option value="all">All Assessments</option>
                        <option value="only_acquired">Only Acquired</option>
                        <option value="only_assessed">Only Assessed</option>
                    </select>
                </div>

                <!-- Accountable Person -->
                <div class="col-12 col-md-6 col-lg-3">
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Accountable Person">
                </div>

                <!-- Care Of -->
                <div class="col-12 col-md-6 col-lg-3">
                    <input type="text" name="care_of" class="form-control form-control-sm" placeholder="Care Of">
                </div>

                <!-- Department -->
                <div class="col-12 col-md-6 col-lg-3">
                    <select name="department" id="department" class="form-select form-select-sm">
                        <option value="">All Departments</option>
                        @foreach($deptSecList as $deptCode => $divisions)
                            <option value="{{ $deptCode }}">{{ $deptCode }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Division -->
                <div class="col-12 col-md-6 col-lg-3">
                    <select name="division" id="division" class="form-select form-select-sm" disabled>
                        <option value="">All Divisions</option>
                    </select>
                </div>

                <!-- Date Acquired -->
                <div class="col-12 col-md-6 col-lg-3" id="acquiredDateFilter">
                    <div class="d-flex gap-2">
                        <select name="acquired_year" class="form-select form-select-sm flex-grow-1">
                            <option value="">Acquired Year</option>
                            @foreach($acquiredYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <select name="acquired_month" class="form-select form-select-sm acquired-month-container d-none" style="width: auto;">
                            <option value="">Month</option>
                            <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </select>
                    </div>
                </div>

                <!-- Date Assessed -->
                <div class="col-12 col-md-6 col-lg-3" id="assessedDateFilter">
                    <div class="d-flex gap-2">
                        <select name="assessed_year" class="form-select form-select-sm flex-grow-1">
                            <option value="">Assessed Year</option>
                            @foreach($assessedYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <select name="assessed_month" class="form-select form-select-sm assessed-month-container d-none" style="width: auto;">
                            <option value="">Month</option>
                            <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Filter Footer -->
        <div class="card-footer bg-light d-flex justify-content-end gap-2 py-2">
            <button type="button" id="applyFilter" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-funnel me-1"></i> Apply Filter
            </button>
            <button type="button" id="resetFilter" class="btn btn-outline-secondary btn-sm px-3">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
            </button>
        </div>
    </div>
    

    <!-- Cards Container -->
    <div id="cardContainer">
        @include('assessment.partials.cards', ['assessments' => $assessments])
    </div>

    <!-- Delete Modal -->
    @include('assessment.partials.deletebt')
    <!-- View Modal -->
@include('assessment.partials.viewbt')

</div>
@endsection

@push('scripts')
<script>
$(function() {
    const container = $('#cardContainer');
    const deptSecList = @json($deptSecList);

    // ---------------- Department / Division
    $('#department').on('change', function() {
        const dept = $(this).val();
        const divisionSelect = $('#division');

        divisionSelect.empty().append('<option value="">All Divisions</option>');

        if (dept && deptSecList[dept]) {
            deptSecList[dept].forEach(div => divisionSelect.append(`<option value="${div}">${div}</option>`));
            divisionSelect.prop('disabled', false);
        } else {
            divisionSelect.prop('disabled', true);
        }
        // Note: No auto-filter — user must click "Apply"
    });

    // ---------------- Year / Month dropdowns (toggle visibility only)
    $('select[name="acquired_year"]').on('change', function(){
        toggleMonthDropdown('.acquired-month-container', $(this).val());
    });
    $('select[name="assessed_year"]').on('change', function(){
        toggleMonthDropdown('.assessed-month-container', $(this).val());
    });

    function toggleMonthDropdown(selector, yearVal){
        const monthDropdown = $(selector);
        if(yearVal) {
            monthDropdown.removeClass('d-none');
        } else {
            monthDropdown.addClass('d-none').val('');
        }
        // No auto-filter
    }

    // ---------------- Filter Type (show/hide date sections only)
    $('#filterType').on('change', function(){
        const type = $(this).val();
        $('#acquiredDateFilter, #assessedDateFilter').show();
        if(type === 'only_acquired') {
            $('#assessedDateFilter').hide();
        } else if(type === 'only_assessed') {
            $('#acquiredDateFilter').hide();
        }
        // No auto-filter
    });

    // ---------------- APPLY FILTER BUTTON
    $('#applyFilter').on('click', function(){
        triggerFilter(1); // Always go to page 1 when applying new filters
    });

    // ---------------- Reset button
    $('#resetFilter').on('click', function(){
        $('#filterForm')[0].reset();
        $('#division').empty().append('<option value="">All Divisions</option>').prop('disabled', true);
        $('.acquired-month-container, .assessed-month-container').addClass('d-none').val('');
        $('#filterType').val('all');
        $('#acquiredDateFilter, #assessedDateFilter').show();
        triggerFilter(1); // Reset = go to page 1
    });

    // ---------------- AJAX filter + pagination
    function triggerFilter(page = 1) {
        $.ajax({
            url: "{{ route('assessment.index') }}",
            type: 'GET',
            data: $('#filterForm').serialize() + '&page=' + page,
            beforeSend: () => {
                container.html('<div class="text-center p-4"><div class="spinner-border text-dark"></div></div>');
            },
            success: function (res) {
                container.html(res.html);
                attachPaginationListeners();
            },
            error: () => {
                container.html('<div class="alert alert-danger">Failed to load assessments.</div>');
            }
        });
    }

    // ---------------- Pagination Handling
    function attachPaginationListeners() {
        $('#cardContainer').off('click', '.pagination a').on('click', '.pagination a', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const page = new URL(url, window.location.href).searchParams.get('page') || 1;
            triggerFilter(page);
        });
    }

    // Initial load (on page load, show current data — no AJAX needed if server-rendered)
    // But we still need to attach pagination listeners
    attachPaginationListeners();

    // ---------------- Delete Modal
    let currentId = null;
    $(document).on('click', '.delete-btn', function(){
        currentId = $(this).data('id');
        $('#modalAssessmentName').text($(this).data('name'));
        $('#deleteForm').attr('action', `/assessment/${currentId}/deletebt`);
        new bootstrap.Modal(document.getElementById('deletebtModal')).show();
    });

    $('#deleteForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    bootstrap.Modal.getInstance(document.getElementById('deletebtModal')).hide();
                    $(`.delete-btn[data-id='${currentId}']`).closest('.assessment-card').remove();
                    // Optional: Re-fetch current page to update counters
                    const currentPage = new URL(window.location).searchParams.get('page') || 1;
                    triggerFilter(currentPage);
                } else {
                    alert('Failed to delete.');
                }
            },
            error: function(){
                alert('Error deleting assessment.');
            }
        });
    });
// ---------------- View Modal
let currentViewId = null;
$(document).on('click', '.view-btn', function(){
    currentViewId = $(this).data('id');
    const assessmentName = $(this).data('name');
    
    // Show loading state
    $('#viewbtModal').find('.modal-body *').each(function() {
        if ($(this).is('div') && $(this).attr('id') && $(this).attr('id').startsWith('modal')) {
            $(this).text('Loading...');
        }
    });
    
    // Make AJAX call to get assessment details using your existing route
    $.ajax({
        url: `/assessment/${currentViewId}/viewbt`,
        type: 'GET',
        dataType: 'json', // Ensure we're expecting JSON
        success: function(data) {
            // Populate modal fields
            $('#modalDateAcquired').text(data.date_acquired);
            $('#modalDateAssessed').text(data.date_assessed || '—');
            $('#modalAssessedBy').text(data.assessed_by || '—');
            $('#modalName').text(data.name);
            $('#modalCareOf').text(data.care_of || '—');
            $('#modalDepartment').text(data.department);
            $('#modalDivision').text(data.division);
            $('#modalEquipmentType').text(data.equipment_type);
            $('#modalModel').text(data.model);
            
            // Handle optional fields
            if(data.motherboard) {
                $('#modalMotherboard').text(data.motherboard);
                $('#motherboardRow').show();
            } else {
                $('#motherboardRow').hide();
            }
            
            if(data.processor) {
                $('#modalProcessor').text(data.processor);
                $('#processorRow').show();
            } else {
                $('#processorRow').hide();
            }
            
            if(data.memory) {
                $('#modalMemory').text(data.memory);
                $('#memoryRow').show();
            } else {
                $('#memoryRow').hide();
            }
            
            if(data.harddisk_capacity) {
                $('#modalHarddiskCapacity').text(data.harddisk_capacity);
                $('#storageRow').show();
            } else {
                $('#storageRow').hide();
            }
            
            if(data.os) {
                $('#modalOs').text(data.os);
                $('#osRow').show();
            } else {
                $('#osRow').hide();
            }
            
            if(data.ms_office) {
                $('#modalMsOffice').text(data.ms_office);
                $('#msOfficeRow').show();
            } else {
                $('#msOfficeRow').hide();
            }
            
            $('#modalLanConnected').text(data.lan_connected ? data.lan_connected.charAt(0).toUpperCase() + data.lan_connected.slice(1) : '—');
            $('#modalInternetConnected').text(data.internet_connected ? data.internet_connected.charAt(0).toUpperCase() + data.internet_connected.slice(1) : '—');
            $('#modalCondition').text(data.condition ? data.condition.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : '—');
            $('#modalAnalysis').text(data.analysis ? data.analysis.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : '—');
            $('#modalRecommendation').text(data.recommendation ? data.recommendation.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : '—');
            $('#modalRemarks').text(data.remarks || 'None');
            
            // Show modal
            new bootstrap.Modal(document.getElementById('viewbtModal')).show();
        },
        error: function(xhr, status, error) {
            alert('Error loading assessment details: ' + error);
            console.error('AJAX Error:', xhr.responseText);
        }
    });
});
});
</script>
@endpush