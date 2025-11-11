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