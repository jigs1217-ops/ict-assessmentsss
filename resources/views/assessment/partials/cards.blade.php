@php
    $total = $assessments->total();
    $counter = $total - ($assessments->currentPage() - 1) * $assessments->perPage();
@endphp

<div class="row g-3 justify-content-start">
    @forelse($assessments as $assessment)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="card assessment-card shadow-sm border-0 flex-fill h-100" style="max-width: 100%;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center p-2">
                    <div>
                        <span class="badge bg-secondary rounded-pill me-2">#{{ $counter-- }}</span>
                        <span class="badge {{ $assessment->condition === 'serviceable' ? 'bg-success' : ($assessment->condition === 'for_repair' ? 'bg-warning' : 'bg-danger') }} rounded-pill fs-7">
                            {{ ucfirst(str_replace('_', ' ', $assessment->condition)) }}
                        </span>
                    </div>
                    <small class="text-muted">
                        {{ $assessment->date_acquired ? \Carbon\Carbon::parse($assessment->date_acquired)->format('M j, Y') : '—' }} |
                        {{ $assessment->date_assessed ? \Carbon\Carbon::parse($assessment->date_assessed)->format('M j, Y') : '—' }}
                    </small>
                </div>

                <div class="card-body p-2">
                    <div><strong>Name:</strong> <span class="text-muted">{{ $assessment->name }}</span></div>
                    <div><strong>Care Of:</strong> <span class="text-muted">{{ $assessment->care_of ?? '—' }}</span></div>
                    <div><strong>Dept:</strong> <span class="text-muted">{{ $assessment->department }}</span></div>
                    <div><strong>Div:</strong> <span class="text-muted">{{ $assessment->division }}</span></div>
                    <div><strong>Eqpt:</strong> <span class="text-muted">{{ $assessment->equipment_type }}</span></div>
                </div>

                <div class="card-footer bg-light border-0 d-flex gap-1 mt-auto">
                    <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 view-btn"
                            data-id="{{ $assessment->id }}"
                            data-name="{{ $assessment->name }}">
                        <i class="bi bi-eye"></i> View
                    </button>
                    <a href="{{ route('assessment.edit', $assessment->id) }}"
                       class="btn btn-sm btn-outline-secondary flex-grow-1">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-outline-danger flex-grow-1 delete-btn"
                            data-id="{{ $assessment->id }}"
                            data-name="{{ $assessment->name }}">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-muted col-12">
            <i class="bi bi-inbox display-5 d-block mb-2"></i>
            No assessments found.
        </div>
    @endforelse
</div>

@if(method_exists($assessments, 'hasPages') && $assessments->hasPages())
    <div class="mt-3">
        {{ $assessments->links() }}
    </div>
@endif