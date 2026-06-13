@push('scripts')
<script>
(function () {
    document.querySelectorAll('.password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = this.dataset.target;
            var input = document.getElementById(target);
            var icon = this.querySelector('i');
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    document.querySelectorAll('.auth-form .input-wrapper .form-control').forEach(function (input) {
        var syncFocus = function () {
            if (input.value || document.activeElement === input) {
                input.parentElement.classList.add('focused');
            } else {
                input.parentElement.classList.remove('focused');
            }
        };
        input.addEventListener('focus', syncFocus);
        input.addEventListener('blur', syncFocus);
        syncFocus();
    });

    var form = document.getElementById('loginForm');
    if (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('.btn-auth');
            if (btn) btn.classList.add('loading');
        });
    }

    var fillAdminBtn = document.getElementById('fillAdminCredentials');
    if (fillAdminBtn) {
        fillAdminBtn.addEventListener('click', function () {
            var emailInput = document.getElementById('email');
            var passwordInput = document.getElementById('password');
            var loginForm = document.getElementById('loginForm');

            if (emailInput) {
                emailInput.value = fillAdminBtn.dataset.email || '';
                emailInput.parentElement.classList.add('focused');
            }
            if (passwordInput) {
                passwordInput.value = fillAdminBtn.dataset.password || '';
                passwordInput.parentElement.classList.add('focused');
            }

            if (loginForm) {
                loginForm.requestSubmit();
            }
        });
    }
})();
</script>
@endpush
