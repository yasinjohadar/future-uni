@extends('frontend.layouts.auth')

@section('title', 'بوابة الطلاب — جامعة المستقبل - إنشاء حساب جديد')
@section('body_class', 'auth-page')

@section('content')
    @include('frontend.pages.partials.register.background')
    @include('frontend.pages.partials.register.form')
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
        const passwordInput = document.getElementById('password');
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

        // Password match checker
        const confirmPasswordInput = document.getElementById('confirmPassword');
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

        // Form submission with loading state
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password !== confirmPassword) {
                alert('كلمات المرور غير متطابقة');
                return;
            }

            const btn = this.querySelector('.btn-auth');
            btn.classList.add('loading');

            // Simulate registration process
            setTimeout(() => {
                btn.classList.remove('loading');
                // Redirect or show success message
                window.location.href = 'login.html';
            }, 2000);
        });

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
</script>
@endpush
