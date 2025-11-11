<div class="p-4 space-y-6 text-gray-800">

    <!-- Header -->
    <div class="border-b pb-2 mb-3">
        <h2 class="text-lg font-semibold text-gray-900">Assessment Details</h2>
    </div>
    
    <!-- Assessment Details -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="font-semibold text-gray-700 mb-3">Assessment Details</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
            <div><strong>Date Acquired:</strong></div>
            <div>{{ \Carbon\Carbon::parse($assessment->date_acquired)->format('F j, Y') }}</div>

            <div><strong>Date Assessed:</strong></div>
            <div>{{ \Carbon\Carbon::parse($assessment->date_assessed)->format('F j, Y') }}</div>

            <div><strong>Assessed By:</strong></div>
            <div>{{ $assessment->assessed_by ?? '—' }}</div>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="font-semibold text-gray-700 mb-3">Basic Information</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
            <div><strong>Accountable Person:</strong></div>
            <div>{{ $assessment->name }}</div>

            <div><strong>Care Of:</strong></div>
            <div>{{ $assessment->care_of ?? '—' }}</div>

            <div><strong>Department:</strong></div>
            <div>{{ $assessment->department }}</div>

            <div><strong>Division:</strong></div>
            <div>{{ $assessment->division }}</div>
        </div>
    </div>

    <!-- Equipment Details -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="font-semibold text-gray-700 mb-3">Equipment Details</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
            <div><strong>Equipment Type:</strong></div>
            <div>{{ $assessment->equipment_type }}</div>

            <div><strong>Model:</strong></div>
            <div>{{ $assessment->model }}</div>

            @if($assessment->motherboard)
                <div><strong>Motherboard:</strong></div>
                <div>{{ $assessment->motherboard }}</div>
            @endif

            @if($assessment->processor)
                <div><strong>Processor:</strong></div>
                <div>{{ $assessment->processor }}</div>
            @endif

            @if($assessment->memory)
                <div><strong>Memory:</strong></div>
                <div>{{ $assessment->memory }}</div>
            @endif

            @if($assessment->harddisk_capacity)
                <div><strong>Storage Device:</strong></div>
                <div>{{ $assessment->harddisk_capacity }}</div>
            @endif

            @if($assessment->os)
                <div><strong>Operating System:</strong></div>
                <div>{{ $assessment->os }}</div>
            @endif

            @if($assessment->ms_office)
                <div><strong>MS Office:</strong></div>
                <div>{{ $assessment->ms_office }}</div>
            @endif

            <div><strong>LAN Connected:</strong></div>
            <div>{{ ucfirst($assessment->lan_connected ?? '—') }}</div>

            <div><strong>Internet Connected:</strong></div>
            <div>{{ ucfirst($assessment->internet_connected ?? '—') }}</div>
        </div>
    </div>

    <!-- Assessment & Recommendation -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="font-semibold text-gray-700 mb-3">Analysis & Recommendation</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
            <div><strong>Condition:</strong></div>
            <div>{{ ucfirst(str_replace('_', ' ', $assessment->condition)) }}</div>

            <div><strong>Analysis:</strong></div>
            <div>{{ ucfirst(str_replace('_', ' ', $assessment->analysis)) }}</div>

            <div><strong>Recommendation:</strong></div>
            <div>{{ ucfirst(str_replace('_', ' ', $assessment->recommendation)) }}</div>

            <div><strong>Remarks:</strong></div>
            <div>{{ $assessment->remarks ?? 'None' }}</div>
        </div>
    </div>

    

</div>
