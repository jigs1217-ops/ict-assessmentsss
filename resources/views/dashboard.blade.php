@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Chart 1: Equipment Condition -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Equipment Condition Summary</h5>
                    <div id="chartCondition" style="height:400px;"></div>
                </div>
            </div>
        </div>

        <!-- Chart 2: Department Count -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Equipment Count by Department</h5>
                    <div id="chartDepartment" style="height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script>
function renderChart(elementId, labels, values, color, emptyMessage) {
    var chart = echarts.init(document.getElementById(elementId));

    if (labels.length === 0 || values.length === 0) {
        // If no data, show "No assessment"
        chart.setOption({
            title: {
                text: emptyMessage,
                left: 'center',
                top: 'middle',
                textStyle: { fontSize: 18, color: '#888' }
            }
        });
    } else {
        chart.setOption({
            tooltip: {},
            xAxis: { type: 'category', data: labels },
            yAxis: { type: 'value' },
            series: [{
                type: 'bar',
                data: values,
                itemStyle: { color: color }
            }]
        });
    }

    window.addEventListener('resize', () => chart.resize());
    return chart;
}

// Chart 1
renderChart(
    'chartCondition',
    {!! json_encode($conditionData->keys()->all()) !!},
    {!! json_encode($conditionData->values()->all()) !!},
    '#0d6efd',
    'No assessment'
);

// Chart 2
renderChart(
    'chartDepartment',
    {!! json_encode($departmentData->keys()->all()) !!},
    {!! json_encode($departmentData->values()->all()) !!},
    '#198754',
    'No assessment'
);
</script>
@endpush
