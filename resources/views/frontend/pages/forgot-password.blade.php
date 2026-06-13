@extends('frontend.layouts.auth')

@section('title', 'بوابة الطلاب — جامعة المستقبل - استعادة كلمة المرور')
@section('body_class', 'auth-page')

@section('content')
    @include('frontend.pages.partials.forgot-password.background')
    @include('frontend.pages.partials.forgot-password.form')
@endsection

@push('vendor_scripts')
    <script src="{{ $fe }}/js/main.js"></script>
@endpush

@push('scripts')
<script>
// Password visibility toggle
        document.querySelectorAll('.password-toggle').forEach(btn => {
            btn.addEventListener('click', function () {
                const target = this.dataset.target;
                const input = document.getElementById(target);
                const icon = this.querySelector('i');

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

        // Password strength checker
        const passwordInput = document.getElementById('newPassword');
        if (passwordInput) {
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');

            passwordInput.addEventListener('input', function () {
                const password = this.value;
                let strength = 0;

                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;

                const percentage = (strength / 5) * 100;
                strengthFill.style.width = percentage + '%';

                if (percentage <= 20) {
                    strengthFill.className = 'strength-fill weak';
                    strengthText.textContent = 'ضعيفة جداً';
                    strengthText.className = 'strength-text weak';
                } else if (percentage <= 40) {
                    strengthFill.className = 'strength-fill weak';
                    strengthText.textContent = 'ضعيفة';
                    strengthText.className = 'strength-text weak';
                } else if (percentage <= 60) {
                    strengthFill.className = 'strength-fill medium';
                    strengthText.textContent = 'متوسطة';
                    strengthText.className = 'strength-text medium';
                } else if (percentage <= 80) {
                    strengthFill.className = 'strength-fill strong';
                    strengthText.textContent = 'قوية';
                    strengthText.className = 'strength-text strong';
                } else {
                    strengthFill.className = 'strength-fill very-strong';
                    strengthText.textContent = 'قوية جداً';
                    strengthText.className = 'strength-text very-strong';
                }
            });
        }

        // Password match checker
        const confirmPasswordInput = document.getElementById('confirmNewPassword');
        if (confirmPasswordInput) {
            const passwordMatch = document.getElementById('passwordMatch');

            confirmPasswordInput.addEventListener('input', function () {
                const password = passwordInput.value;
                const confirmPassword = this.value;

                if (confirmPassword === '') {
                    passwordMatch.textContent = '';
                    passwordMatch.className = 'password-match';
                } else if (password === confirmPassword) {
                    passwordMatch.innerHTML = '<i class="fas fa-check-circle"></i> كلمات المرور متطابقة';
                    passwordMatch.className = 'password-match match';
                } else {
                    passwordMatch.innerHTML = '<i class="fas fa-times-circle"></i> كلمات المرور غير متطابقة';
                    passwordMatch.className = 'password-match no-match';
                }
            });
        }

        // Step navigation
        function showStep(stepId) {
            document.querySelectorAll('.auth-step').forEach(step => {
                step.classList.remove('active');
            });
            document.getElementById(stepId).classList.add('active');
        }

        // Forgot password form submission
        const forgotForm = document.getElementById('forgotForm');
        if (forgotForm) {
            forgotForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const btn = this.querySelector('.btn-auth');
                const email = document.getElementById('email').value;

                btn.classList.add('loading');

                setTimeout(() => {
                    btn.classList.remove('loading');
                    document.getElementById('sentEmail').textContent = email;
                    showStep('step2');
                    startCountdown();
                }, 1500);
            });
        }

        // Reset password form submission
        const resetForm = document.getElementById('resetForm');
        if (resetForm) {
            resetForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const btn = this.querySelector('.btn-auth');

                if (passwordInput.value !== confirmPasswordInput.value) {
                    alert('كلمات المرور غير متطابقة');
                    return;
                }

                btn.classList.add('loading');

                setTimeout(() => {
                    btn.classList.remove('loading');
                    showStep('step4');
                }, 1500);
            });
        }

        // Resend button
        const resendBtn = document.getElementById('resendBtn');
        if (resendBtn) {
            resendBtn.addEventListener('click', function () {
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin ms-1"></i> جاري الإرسال...';

                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-redo ms-1"></i> إعادة الإرسال';
                    startCountdown();
                }, 2000);
            });
        }

        // Countdown timer
        function startCountdown() {
            const countdownEl = document.getElementById('countdown');
            const countEl = document.getElementById('countdownCount');
            const resendBtn = document.getElementById('resendBtn');

            countdownEl.style.display = 'flex';
            resendBtn.style.display = 'none';

            let count = 60;
            countEl.textContent = count;

            const interval = setInterval(() => {
                count--;
                countEl.textContent = count;

                if (count <= 0) {
                    clearInterval(interval);
                    countdownEl.style.display = 'none';
                    resendBtn.style.display = 'inline-flex';
                }
            }, 1000);
        }

        // Input focus animation
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function () {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Demo: Show step3 if URL has ?reset=1
        if (window.location.search.includes('reset=1')) {
            showStep('step3');
        }
</script>
@endpush
