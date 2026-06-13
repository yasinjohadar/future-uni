@extends('frontend.layouts.master')

@section('title', 'تم إلغاء الاشتراك | ياسين جوخدار')
@section('description', 'تم إلغاء اشتراكك في النشرة البريدية بنجاح.')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="glass-panel text-center animate-on-scroll" style="padding: 3rem 2rem;">
                    <div class="unsubscribe-icon mb-3">
                        <i class="fas fa-envelope-open-text" style="font-size: 3rem; color: var(--clr-primary);"></i>
                    </div>
                    <h2 class="mb-3">تم إلغاء الاشتراك بنجاح</h2>
                    <p class="text-muted mb-4">تم إلغاء اشتراكك في النشرة البريدية. لن تصلك رسائلنا بعد الآن.</p>
                    <p class="small text-muted mb-4">يمكنك إعادة الاشتراك في أي وقت من خلال نموذج النشرة البريدية في الموقع.</p>
                    <a href="{{ route('home') }}" class="btn-primary-custom">
                        <i class="fas fa-home"></i> العودة للرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
