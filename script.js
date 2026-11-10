// Bootstrap client-side validation and small interactive behaviours.
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.needs-validation').forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });

  const planSelect = document.getElementById('planSelect');
  const planHint = document.getElementById('planHint');
  if (planSelect && planHint) {
    planSelect.addEventListener('change', () => {
      planHint.textContent = planSelect.value + ' plan selected.';
    });
  }

  document.querySelectorAll('.btn-success').forEach(button => {
    button.addEventListener('mouseover', () => button.classList.add('shadow'));
    button.addEventListener('mouseout', () => button.classList.remove('shadow'));
  });
});
