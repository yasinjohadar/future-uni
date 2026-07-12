@extends('admin.layouts.master')
@section('page-title') الفصول الدراسية @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الفصول الدراسية']],
    'title' => 'الفصول الدراسية', 'subtitle' => 'إدارة الفصول والتسجيل',
    'actions' => '<a href="' . route('admin.academic.terms.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> إضافة فصل</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-calendar-line', 'label' => 'إجمالي الفصول', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'نشطة', 'value' => number_format($stats['active']), 'hint' => ''])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-star-line', 'label' => 'الفصل الحالي', 'value' => number_format($stats['current']), 'hint' => ''])
</div>
<div class="filter-panel mb-4"><form method="GET" class="row g-2">
    <div class="col-md-4"><input name="search" class="form-control" placeholder="بحث بالاسم أو الرمز..." value="{{ request('search') }}"></div>
    <div class="col-md-3"><select name="status" class="form-select"><option value="">كل الحالات</option><option value="active" @selected(request('status')==='active')>نشط</option><option value="inactive" @selected(request('status')==='inactive')>غير نشط</option></select></div>
    <div class="col-md-5 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.academic.terms.index') }}" class="btn btn-light border">مسح</a></div>
</form></div>
<div class="card custom-card"><div class="card-body p-0"><table class="table data-table mb-0">
<thead><tr><th>#</th><th>الاسم</th><th>الرمز</th><th>البداية</th><th>النهاية</th><th>الحالي</th><th>الحالة</th><th>إجراءات</th></tr></thead>
<tbody>@forelse($terms as $term)
<tr>
    <td>{{ $terms->firstItem() + $loop->index }}</td>
    <td><a href="{{ route('admin.academic.terms.edit', $term) }}" class="fw-bold text-decoration-none">{{ $term->name }}</a></td>
    <td>{{ $term->code }}</td>
    <td>{{ $term->starts_at?->format('Y-m-d') ?? '—' }}</td>
    <td>{{ $term->ends_at?->format('Y-m-d') ?? '—' }}</td>
    <td>@if($term->is_current)<span class="badge bg-success">حالي</span>@else—@endif</td>
    <td>{{ $term->is_active ? 'نشط' : 'غير نشط' }}</td>
    <td>
        <a href="{{ route('admin.academic.terms.edit', $term) }}" class="btn btn-sm btn-light"><i class="ri-pencil-line"></i></a>
        @unless($term->is_current)
        <form action="{{ route('admin.academic.terms.mark-current', $term) }}" method="POST" class="d-inline">@csrf<button class="btn btn-sm btn-light" title="تعيين كفصل حالي"><i class="ri-star-line"></i></button></form>
        @endunless
        <form action="{{ route('admin.academic.terms.destroy', $term) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button></form>
    </td>
</tr>@empty<tr><td colspan="8" class="text-center py-4 text-muted">لا توجد فصول</td></tr>@endforelse</tbody>
</table>@if($terms->hasPages())<div class="card-footer">{{ $terms->links() }}</div>@endif</div></div>
</div></div>
@endsection
