@extends('admin.layouts.master')

@section('page-title') {{ Str::limit($book->title, 40) }} @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'كتب المكتبة', 'url' => route('admin.library.books.index')],
                ['label' => Str::limit($book->title, 30)],
            ],
            'title' => $book->title,
            'subtitle' => $book->author,
            'actions' => '<a href="' . route('admin.library.books.edit', $book) . '" class="btn btn-primary btn-wave me-2"><i class="ri-pencil-line me-1"></i> تعديل</a><a href="' . route('library.book.show', $book->slug) . '" class="btn btn-light border btn-wave" target="_blank"><i class="ri-external-link-line me-1"></i> عرض في الموقع</a>',
        ])

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card custom-card form-card mb-4">
                    <div class="card-header"><h6 class="mb-0 fw-semibold">الوصف</h6></div>
                    <div class="card-body"><p class="mb-0 text-secondary">{{ $book->description ?: '—' }}</p></div>
                </div>
                @if(! empty($book->chapters))
                    <div class="card custom-card form-card mb-4">
                        <div class="card-header"><h6 class="mb-0 fw-semibold">فهرس المحتويات</h6></div>
                        <div class="card-body">
                            <ol class="mb-0">@foreach($book->chapters as $chapter)<li>{{ $chapter }}</li>@endforeach</ol>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="card custom-card form-card mb-4">
                    <div class="card-header"><h6 class="mb-0 fw-semibold">معلومات</h6></div>
                    <div class="card-body">
                        <p class="mb-2"><strong>التصنيف:</strong> {{ $book->category?->name ?? '—' }}</p>
                        <p class="mb-2"><strong>ISBN:</strong> <span dir="ltr">{{ $book->isbn ?? '—' }}</span></p>
                        <p class="mb-2"><strong>النسخ:</strong> {{ $book->copies_available }}/{{ $book->copies_total }}</p>
                        <p class="mb-2"><strong>التقييم:</strong> {{ number_format($book->rating, 1) }}/5</p>
                        <p class="mb-0"><strong>Slug:</strong> <span dir="ltr">{{ $book->slug }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
