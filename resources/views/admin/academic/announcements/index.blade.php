@extends('admin.layouts.master')
@section('page-title') الإعلانات @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الإعلانات']],
    'title' => 'الإعلانات الأكاديمية', 'subtitle' => 'إدارة إعلانات بوابة الطالب',
    'actions' => '<a href="' . route('admin.academic.announcements.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> إضافة إعلان</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-megaphone-line', 'label' => 'إجمالي الإعلانات', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'نشطة', 'value' => number_format($stats['active']), 'hint' => ''])
</div>
<div class="filter-panel mb-4"><form method="GET" class="row g-2">
    <div class="col-md-4"><input name="search" class="form-control" placeholder="بحث..." value="{{ request('search') }}"></div>
    <div class="col-md-3"><select name="audience" class="form-select"><option value="">كل الجماهير</option><option value="all" @selected(request('audience')==='all')>الجميع</option><option value="college" @selected(request('audience')==='college')>الكلية</option><option value="program" @selected(request('audience')==='program')>البرنامج</option></select></div>
    <div class="col-md-5 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.academic.announcements.index') }}" class="btn btn-light border">مسح</a></div>
</form></div>
<div class="card custom-card"><div class="card-body p-0"><table class="table data-table mb-0">
<thead><tr><th>#</th><th>العنوان</th><th>الجمهور</th><th>النشر</th><th>الحالة</th><th>إجراءات</th></tr></thead>
<tbody>@forelse($announcements as $announcement)
<tr>
    <td>{{ $announcements->firstItem() + $loop->index }}</td>
    <td><a href="{{ route('admin.academic.announcements.edit', $announcement) }}" class="fw-bold text-decoration-none">{{ $announcement->title }}</a></td>
    <td>@if($announcement->audience==='all')الجميع@elseif($announcement->audience==='college'){{ $announcement->college?->name }}@else{{ $announcement->program?->name }}@endif</td>
    <td>{{ $announcement->published_at?->format('Y-m-d H:i') ?? '—' }}</td>
    <td>{{ $announcement->is_active ? 'نشط' : 'غير نشط' }}</td>
    <td>
        <a href="{{ route('admin.academic.announcements.edit', $announcement) }}" class="btn btn-sm btn-light"><i class="ri-pencil-line"></i></a>
        <form action="{{ route('admin.academic.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button></form>
    </td>
</tr>@empty<tr><td colspan="6" class="text-center py-4 text-muted">لا توجد إعلانات</td></tr>@endforelse</tbody>
</table>@if($announcements->hasPages())<div class="card-footer">{{ $announcements->links() }}</div>@endif</div></div>
</div></div>
@endsection
