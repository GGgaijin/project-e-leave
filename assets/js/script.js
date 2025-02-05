document.addEventListener('DOMContentLoaded', function () {
    // Leave Application Form Validation
    const leaveForm = document.querySelector('form[action="process_leave.php"]');
    if (leaveForm) {
        leaveForm.addEventListener('submit', function (event) {
            const startDateInput = document.querySelector('input[name="start_date"]');
            const endDateInput = document.querySelector('input[name="end_date"]');
            const reasonInput = document.querySelector('textarea[name="reason"]');

            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            // Check if start date is after end date
            if (startDate > endDate) {
                event.preventDefault(); // Prevent form submission
                alert('Start date cannot be later than end date.');
                return;
            }

            // Check if reason is empty
            if (!reasonInput.value.trim()) {
                event.preventDefault(); // Prevent form submission
                alert('Reason for leave cannot be empty.');
                return;
            }
        });
    }

    // Login Form Validation
    const loginForm = document.querySelector('form[action="process_login.php"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            const usernameInput = document.querySelector('input[name="username"]');
            const passwordInput = document.querySelector('input[name="password"]');

            if (!usernameInput.value.trim() || !passwordInput.value.trim()) {
                event.preventDefault(); // Prevent form submission
                alert('Username and password are required.');
                return;
            }
        });
    }
});
