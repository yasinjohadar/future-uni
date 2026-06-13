<!-- Animated Background -->
    

    <!-- Auth Container -->
    <div class="auth-container">
        <div class="auth-wrapper auth-wrapper-centered">
            <!-- Forgot Password Card -->
            <div class="auth-card-only">
                <!-- Theme Toggle -->
                <div class="auth-header-actions">
                    <button class="theme-toggle" aria-label="Toggle Dark Mode">
                        <i class="fas fa-sun"></i>
                    </button>
                </div>

                <!-- Logo -->
                <div class="auth-logo-centered">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-university"></i>
                        <span>جامعة<span class="accent">المستقبل</span></span>
                    </a>
                </div>

                <!-- Icon -->
                <div class="auth-icon-wrapper">
                    <div class="auth-icon-circle">
                        <i class="fas fa-key"></i>
                    </div>
                </div>

                <div class="auth-form-header text-center">
                    <h2>نسيت كلمة المرور؟</h2>
                    <p>لا تقلق! أدخل بريدك الإلكتروني وسنرسل لك رابطاً لإعادة تعيين كلمة المرور</p>
                </div>

                <!-- Multi-Step Form -->
                <div class="auth-steps-container">
                    <!-- Step 1: Email Input -->
                    <div class="auth-step active" id="step1">
                        <form class="auth-form" id="forgotForm">
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    البريد الإلكتروني
                                </label>
                                <div class="input-wrapper">
                                    <input type="email" class="form-control" id="email" placeholder="example@email.com"
                                        required>
                                    <span class="input-focus-border"></span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-auth btn-block">
                                <span class="btn-text">إرسال رابط الاستعادة</span>
                                <span class="btn-icon"><i class="fas fa-paper-plane"></i></span>
                                <span class="btn-loader"><i class="fas fa-spinner fa-spin"></i></span>
                            </button>
                        </form>
                    </div>

                    <!-- Step 2: Email Sent Confirmation -->
                    <div class="auth-step" id="step2">
                        <div class="email-sent-animation">
                            <div class="email-icon">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <div class="checkmark-circle">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div class="email-sent-content">
                            <h4>تم إرسال البريد الإلكتروني!</h4>
                            <p>لقد أرسلنا رابط إعادة تعيين كلمة المرور إلى</p>
                            <div class="sent-email" id="sentEmail">example@email.com</div>
                            <p class="small text-secondary mt-3">
                                لم تستلم البريد؟ تحقق من مجلد البريد المزعج أو
                            </p>
                            <button class="btn btn-glass btn-sm mt-2" id="resendBtn">
                                <i class="fas fa-redo ms-1"></i>
                                إعادة الإرسال
                            </button>
                        </div>
                        <div class="countdown-text" id="countdown">
                            <span>إعادة الإرسال خلال</span>
                            <span class="count" id="countdownCount">60</span>
                            <span>ثانية</span>
                        </div>
                    </div>

                    <!-- Step 3: Reset Password (after clicking email link) -->
                    <div class="auth-step" id="step3">
                        <form class="auth-form" id="resetForm">
                            <div class="form-group">
                                <label for="newPassword" class="form-label">
                                    <i class="fas fa-lock"></i>
                                    كلمة المرور الجديدة
                                </label>
                                <div class="input-wrapper">
                                    <input type="password" class="form-control" id="newPassword" placeholder="••••••••"
                                        required>
                                    <button type="button" class="password-toggle" data-target="newPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <span class="input-focus-border"></span>
                                </div>
                                <!-- Password Strength Indicator -->
                                <div class="password-strength">
                                    <div class="strength-bar">
                                        <div class="strength-fill" id="strengthFill"></div>
                                    </div>
                                    <span class="strength-text" id="strengthText">قوة كلمة المرور</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirmNewPassword" class="form-label">
                                    <i class="fas fa-lock"></i>
                                    تأكيد كلمة المرور الجديدة
                                </label>
                                <div class="input-wrapper">
                                    <input type="password" class="form-control" id="confirmNewPassword"
                                        placeholder="••••••••" required>
                                    <button type="button" class="password-toggle" data-target="confirmNewPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <span class="input-focus-border"></span>
                                </div>
                                <div class="password-match" id="passwordMatch"></div>
                            </div>

                            <button type="submit" class="btn btn-auth btn-block">
                                <span class="btn-text">حفظ كلمة المرور الجديدة</span>
                                <span class="btn-icon"><i class="fas fa-check"></i></span>
                                <span class="btn-loader"><i class="fas fa-spinner fa-spin"></i></span>
                            </button>
                        </form>
                    </div>

                    <!-- Step 4: Success -->
                    <div class="auth-step" id="step4">
                        <div class="success-animation">
                            <div class="success-checkmark">
                                <div class="check-icon">
                                    <span class="icon-line line-tip"></span>
                                    <span class="icon-line line-long"></span>
                                    <div class="icon-circle"></div>
                                    <div class="icon-fix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="success-content">
                            <h4>تم تغيير كلمة المرور بنجاح!</h4>
                            <p>يمكنك الآن تسجيل الدخول باستخدام كلمة المرور الجديدة</p>
                            <a href="{{ url('/login') }}" class="btn btn-auth mt-4">
                                <span class="btn-text">تسجيل الدخول</span>
                                <span class="btn-icon"><i class="fas fa-arrow-left"></i></span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="auth-footer text-center">
                    <a href="{{ url('/login') }}" class="back-to-login">
                        <i class="fas fa-arrow-right"></i>
                        العودة لتسجيل الدخول
                    </a>
                </div>
            </div>
        </div>
    </div>
