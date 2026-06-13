@php
    $brand = config('frontend.brand');
    $useLaravelAuth = $useLaravelAuth ?? false;
    $formAction = $formAction ?? url('/login');
    $formTitle = $formTitle ?? 'تسجيل الدخول';
    $formSubtitle = $formSubtitle ?? 'أدخل بياناتك للوصول إلى حسابك';
    $brandingTitle = $brandingTitle ?? 'مرحباً بعودتك';
    $demoAdmin = config('demo-credentials.admin');
    $showDemoAdminFill = ($showDemoAdminFill ?? false) && app()->environment('local');
@endphp

<div class="auth-container">
    <div class="auth-wrapper auth-wrapper--luxury">
        <div class="auth-branding auth-branding--luxury">
            <div class="branding-content">
                <a href="{{ route('home') }}" class="auth-logo">
                    <span class="auth-logo__mark"><i class="fas fa-university"></i></span>
                    <span class="auth-logo__text">{{ $brand['name'] }}<span class="accent">{{ $brand['accent'] }}</span></span>
                </a>

                <span class="auth-branding__eyebrow">منصة أكاديمية متكاملة</span>
                <h1 class="branding-title">{{ $brandingTitle }}</h1>
                <p class="branding-text">{{ $brand['tagline'] }}</p>

                <div class="branding-features">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-flask"></i></div>
                        <div class="feature-text">
                            <h6>بحث علمي رائد</h6>
                            <p>مراكز بحثية وبرامج دراسات عليا متقدمة</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-certificate"></i></div>
                        <div class="feature-text">
                            <h6>اعتمادات دولية</h6>
                            <p>برامج أكاديمية معتمدة وفق أعلى المعايير</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-users"></i></div>
                        <div class="feature-text">
                            <h6>مجتمع أكاديمي</h6>
                            <p>طلاب وأساتذة في بيئة تعليمية محفّزة</p>
                        </div>
                    </div>
                </div>

                <div class="auth-trust-badges">
                    <span><i class="fas fa-shield-alt"></i> اتصال آمن</span>
                    <span><i class="fas fa-lock"></i> حماية البيانات</span>
                    <span><i class="fas fa-award"></i> جودة معتمدة</span>
                </div>
            </div>
        </div>

        <div class="auth-form-section">
            <div class="auth-form-wrapper">
                <div class="auth-header-actions">
                    <a href="{{ route('home') }}" class="auth-back-home" title="العودة للموقع">
                        <i class="fas fa-home"></i>
                        <span>الرئيسية</span>
                    </a>
                    <button class="theme-toggle" type="button" aria-label="تبديل الوضع">
                        <i class="fas fa-sun"></i>
                    </button>
                </div>

                <div class="auth-mobile-logo">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-university"></i>
                        <span>{{ $brand['name'] }}<span class="accent">{{ $brand['accent'] }}</span></span>
                    </a>
                </div>

                <div class="auth-form-header">
                    <h2>{{ $formTitle }}</h2>
                    <p>{{ $formSubtitle }}</p>
                </div>

                @if($useLaravelAuth && session('status'))
                    <div class="auth-alert auth-alert--success" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if($useLaravelAuth && session('error'))
                    <div class="auth-alert auth-alert--danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($useLaravelAuth && $errors->any())
                    <div class="auth-alert auth-alert--danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form class="auth-form" id="loginForm" method="POST" action="{{ $formAction }}" @if($useLaravelAuth) novalidate @endif>
                    @if($useLaravelAuth)
                        @csrf
                    @endif

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            البريد الإلكتروني
                        </label>
                        <div class="input-wrapper">
                            <input type="email"
                                   class="form-control @if($useLaravelAuth && $errors->has('email')) is-invalid @endif"
                                   id="email"
                                   name="email"
                                   value="{{ $useLaravelAuth ? old('email') : '' }}"
                                   placeholder="name@futureuniversity.edu"
                                   dir="ltr"
                                   required
                                   autofocus
                                   autocomplete="username">
                            <span class="input-focus-border"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            كلمة المرور
                        </label>
                        <div class="input-wrapper">
                            <input type="password"
                                   class="form-control @if($useLaravelAuth && $errors->has('password')) is-invalid @endif"
                                   id="password"
                                   name="password"
                                   placeholder="••••••••"
                                   required
                                   autocomplete="current-password">
                            <button type="button" class="password-toggle" data-target="password" aria-label="إظهار كلمة المرور">
                                <i class="fas fa-eye"></i>
                            </button>
                            <span class="input-focus-border"></span>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" id="remember" name="remember" @checked($useLaravelAuth && old('remember'))>
                            <span class="checkmark"></span>
                            <span class="checkbox-label">تذكرني</span>
                        </label>
                        @if($useLaravelAuth && Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">نسيت كلمة المرور؟</a>
                        @elseif(! $useLaravelAuth)
                            <a href="{{ url('/forgot-password') }}" class="forgot-link">نسيت كلمة المرور؟</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-auth btn-auth--luxury">
                        <span class="btn-text">تسجيل الدخول</span>
                        <span class="btn-icon"><i class="fas fa-arrow-left"></i></span>
                        <span class="btn-loader"><i class="fas fa-spinner fa-spin"></i></span>
                    </button>

                    @if($showDemoAdminFill)
                        <div class="auth-demo-fill">
                            <button type="button"
                                    class="btn btn-auth-demo w-100"
                                    id="fillAdminCredentials"
                                    data-email="{{ $demoAdmin['email'] }}"
                                    data-password="{{ $demoAdmin['password'] }}">
                                <i class="fas fa-user-shield me-1"></i> تسجيل كأدمن (Seed)
                            </button>
                            <p class="auth-demo-fill__hint mb-0">
                                <span dir="ltr">{{ $demoAdmin['email'] }}</span>
                                <span class="mx-1">·</span>
                                <span dir="ltr">{{ $demoAdmin['password'] }}</span>
                            </p>
                        </div>
                    @endif
                </form>

                <div class="auth-footer">
                    <p class="text-muted fs-12 mb-0">© {{ date('Y') }} {{ $brand['name'] }}{{ $brand['accent'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
