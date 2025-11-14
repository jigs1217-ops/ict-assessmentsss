<!-- Global Delete Modal -->
<div class="modal fade" id="deletebtModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-sm rounded-4 border-0">

            <!-- Modal Header -->
            <div class="modal-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Delete Assessment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                Are you sure you want to delete <strong id="modalAssessmentName"></strong>?
                <p class="text-danger mt-2 mb-0">This action cannot be undone.</p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex flex-wrap justify-content-end gap-2">
                <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="m-0 flex-fill">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Delete</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Mobile friendly adjustments and button padding -->
<style>
#deletebtModal .modal-footer .btn {
    padding: 6px 12px; /* button padding */
    font-size: 1rem;    /* normal font size */
}

@media (max-width: 576px) {
    #deletebtModal .modal-dialog {
        margin: 1rem; /* small margin on sides */
    }
    #deletebtModal .modal-footer {
        flex-direction: column;
        gap: 0.5rem;
    }
    #deletebtModal .modal-footer .btn,
    #deletebtModal .modal-footer form {
        width: 100%;
    }
}
</style>
