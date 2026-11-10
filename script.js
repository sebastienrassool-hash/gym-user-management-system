
// Function 1: Validate forms
function validateForm(form, event) {
    if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }

    form.classList.add('was-validated');
}

// Function 2: Update membership plan information
function updatePlanHint() {
    const planSelect = document.getElementById('planSelect');
    const planHint = document.getElementById('planHint');

    if (planSelect && planHint) {
        planHint.textContent = planSelect.value + ' plan selected.';
    }
}

// Function 3: Add button hover effects
function addButtonShadow(button) {
    button.classList.add('shadow');
}

// Function 4: Remove button hover effects
function removeButtonShadow(button) {
    button.classList.remove('shadow');
}

// Run when the page loads
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.needs-validation').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            validateForm(form, event);
        });
    });

    const planSelect = document.getElementById('planSelect');

    if (planSelect) {
        planSelect.addEventListener('change', updatePlanHint);
    }

    document.querySelectorAll('.btn-success').forEach(function (button) {
        button.addEventListener('mouseover', function () {
            addButtonShadow(button);
        });

        button.addEventListener('mouseout', function () {
            removeButtonShadow(button);
        });
    });

});

