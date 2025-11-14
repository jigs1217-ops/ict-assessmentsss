<!-- Global View Modal -->
<div class="modal fade" id="viewbtModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-sm rounded-4 border-0">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Assessment Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="p-4 space-y-6 text-gray-800">
                    <!-- Assessment Details -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Assessment Details</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                            <div><strong>Date Acquired:</strong></div>
                            <div id="modalDateAcquired">Loading...</div>

                            <div><strong>Date Assessed:</strong></div>
                            <div id="modalDateAssessed">Loading...</div>

                            <div><strong>Assessed By:</strong></div>
                            <div id="modalAssessedBy">Loading...</div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Basic Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                            <div><strong>Accountable Person:</strong></div>
                            <div id="modalName">Loading...</div>

                            <div><strong>Care Of:</strong></div>
                            <div id="modalCareOf">Loading...</div>

                            <div><strong>Department:</strong></div>
                            <div id="modalDepartment">Loading...</div>

                            <div><strong>Division:</strong></div>
                            <div id="modalDivision">Loading...</div>
                        </div>
                    </div>

                    <!-- Equipment Details -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Equipment Details</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                            <div><strong>Equipment Type:</strong></div>
                            <div id="modalEquipmentType">Loading...</div>

                            <div><strong>Model:</strong></div>
                            <div id="modalModel">Loading...</div>

                            <div id="motherboardRow" style="display:none;">
                                <div><strong>Motherboard:</strong></div>
                                <div id="modalMotherboard">Loading...</div>
                            </div>

                            <div id="processorRow" style="display:none;">
                                <div><strong>Processor:</strong></div>
                                <div id="modalProcessor">Loading...</div>
                            </div>

                            <div id="memoryRow" style="display:none;">
                                <div><strong>Memory:</strong></div>
                                <div id="modalMemory">Loading...</div>
                            </div>

                            <div id="storageRow" style="display:none;">
                                <div><strong>Storage Device:</strong></div>
                                <div id="modalHarddiskCapacity">Loading...</div>
                            </div>

                            <div id="osRow" style="display:none;">
                                <div><strong>Operating System:</strong></div>
                                <div id="modalOs">Loading...</div>
                            </div>

                            <div id="msOfficeRow" style="display:none;">
                                <div><strong>MS Office:</strong></div>
                                <div id="modalMsOffice">Loading...</div>
                            </div>

                            <div><strong>LAN Connected:</strong></div>
                            <div id="modalLanConnected">Loading...</div>

                            <div><strong>Internet Connected:</strong></div>
                            <div id="modalInternetConnected">Loading...</div>
                        </div>
                    </div>

                    <!-- Assessment & Recommendation -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Analysis & Recommendation</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                            <div><strong>Condition:</strong></div>
                            <div id="modalCondition">Loading...</div>

                            <div><strong>Analysis:</strong></div>
                            <div id="modalAnalysis">Loading...</div>

                            <div><strong>Recommendation:</strong></div>
                            <div id="modalRecommendation">Loading...</div>

                            <div><strong>Remarks:</strong></div>
                            <div id="modalRemarks">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex flex-wrap justify-content-end gap-2">
                <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- Mobile friendly adjustments and button padding -->
<style>
#viewbtModal .modal-footer .btn {
    padding: 6px 12px; /* button padding */
    font-size: 1rem;    /* normal font size */
}

@media (max-width: 576px) {
    #viewbtModal .modal-dialog {
        margin: 1rem; /* small margin on sides */
    }
    #viewbtModal .modal-footer {
        flex-direction: column;
        gap: 0.5rem;
    }
    #viewbtModal .modal-footer .btn {
        width: 100%;
    }
}
</style>