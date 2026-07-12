@extends('admin.layouts.master')
@section('page-title') إضافة شعبة @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الشعب', 'url' => route('admin.academic.sections.index')], ['label' => 'إضافة']],
    'title' => 'إضافة شعبة دراسية',
    'actions' => '<a href="' . route('admin.academic.sections.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<form action="{{ route('admin.academic.sections.store') }}" method="POST">
@csrf
<div class="card custom-card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">المقرر *</label><select name="program_course_id" class="form-select" required><option value="">اختر المقرر</option>@foreach($programCourses as $pc)<option value="{{ $pc->id }}" @selected(old('program_course_id', $selectedProgramCourseId)==$pc->id)>{{ $pc->code }} — {{ $pc->name }} ({{ $pc->program?->name }})</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label">الفصل الدراسي *</label><select name="academic_term_id" class="form-select" required><option value="">اختر الفصل</option>@foreach($terms as $t)<option value="{{ $t->id }}" @selected(old('academic_term_id', $selectedTermId)==$t->id)>{{ $t->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label">رمز الشعبة *</label><input type="text" name="section_code" class="form-control" value="{{ old('section_code', 'A') }}" required></div>
        <div class="col-md-3"><label class="form-label">السعة</label><input type="number" name="capacity" class="form-control" value="{{ old('capacity', 40) }}" min="1"></div>
        <div class="col-md-3"><label class="form-label">القاعة</label><input type="text" name="room" class="form-control" value="{{ old('room') }}"></div>
        <div class="col-md-3"><label class="form-label">من</label><input type="time" name="starts_at" class="form-control" value="{{ old('starts_at') }}"></div>
        <div class="col-md-3"><label class="form-label">إلى</label><input type="time" name="ends_at" class="form-control" value="{{ old('ends_at') }}"></div>
        <div class="col-md-6"><label class="form-label">عضو هيئة التدريس</label><select name="staff_member_id" class="form-select"><option value="">—</option>@foreach($staffMembers as $s)<option value="{{ $s->id }}" @selected(old('staff_member_id')==$s->id)>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label">محاضر (حساب دكتور)</label><select name="instructor_user_id" class="form-select"><option value="">—</option>@foreach($doctors as $d)<option value="{{ $d->id }}" @selected(old('instructor_user_id')==$d->id)>{{ $d->name }}</option>@endforeach</select></div>
        <div class="col-12"><label class="form-label d-block">أيام المحاضرة</label>
            <div class="d-flex flex-wrap gap-3">@foreach($dayLabels as $day => $label)<div class="form-check"><input type="checkbox" name="days[]" value="{{ $day }}" class="form-check-input" id="day_{{ $day }}" @checked(in_array($day, old('days', [])))><label class="form-check-label" for="day_{{ $day }}">{{ $label }}</label></div>@endforeach</div>
        </div>
        <div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', true))><label class="form-check-label" for="is_active">نشطة</label></div></div>
    </div>
</div><div class="card-footer"><button type="submit" class="btn btn-primary">حفظ</button></div></div>
</form>
</div></div>
@endsection
