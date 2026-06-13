@extends('admin.layouts.master')

@section('page-title') إعدادات المكتبة @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'المكتبة'],
                ['label' => 'الإعدادات'],
            ],
            'title' => 'إعدادات المكتبة',
            'subtitle' => 'إحصائيات شريط المكتبة في الواجهة الأمامية',
        ])

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="{{ route('admin.library.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card custom-card form-card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">المراجع الرقمية</label>
                                <input type="text" name="digital_references" class="form-control form-input-enhanced @error('digital_references') is-invalid @enderror" value="{{ old('digital_references', $settings->digital_references) }}" required>
                                @error('digital_references')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <p class="text-muted fs-12 mb-0 mt-1">مثال: 850+</p>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">مقاعد المطالعة</label>
                                <input type="number" name="reading_seats" min="0" class="form-control form-input-enhanced @error('reading_seats') is-invalid @enderror" value="{{ old('reading_seats', $settings->reading_seats) }}" required>
                                @error('reading_seats')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-wave"><i class="ri-save-line me-1"></i> حفظ الإعدادات</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
