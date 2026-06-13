@extends('admin.layouts.master')
@section('page-title') إضافة دورة قبول @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'دورات القبول', 'url' => route('admin.admission.cycles.index')], ['label' => 'إضافة']],
    'title' => 'إضافة دورة قبول',
    'actions' => '<a href="' . route('admin.admission.cycles.index') . '" class="btn btn-light border">رجوع</a>',
])
<form action="{{ route('admin.admission.cycles.store') }}" method="POST">@csrf
<div class="card custom-card"><div class="card-body row g-3">
    <div class="col-md-6"><label class="form-label">الاسم *</label><input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label class="form-label">السنة الأكاديمية *</label><input name="academic_year" class="form-control @error('academic_year') is-invalid @enderror" value="{{ old('academic_year', now()->year . '/' . (now()->year + 1)) }}" required>@error('academic_year')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label class="form-label">تاريخ البداية</label><input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">@error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label class="form-label">تاريخ الانتهاء</label><input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">@error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-12"><label class="form-label">الوصف</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
    <div class="col-12"><div class="form-check"><input type="checkbox" name="is_open" value="1" class="form-check-input" id="is_open" @checked(old('is_open'))><label for="is_open">القبول مفتوح</label></div></div>
    <div class="col-12"><button class="btn btn-primary">حفظ</button></div>
</div></div></form>
</div></div>
@endsection
