@php
    $statusLabels = [
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'graduated' => 'متخرج',
        'suspended' => 'موقوف',
    ];
@endphp

<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table data-table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 220px;">الطالب</th>
                    <th style="min-width: 140px;">رقم الطالب</th>
                    <th style="min-width: 200px;">البرنامج</th>
                    <th style="min-width: 110px;">الحالة</th>
                    <th style="min-width: 120px;">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php
                        $name = $student->user?->name ?? '—';
                        $initial = mb_strtoupper(mb_substr($name, 0, 1));
                        $statusClass = match ($student->status) {
                            'active' => 'badge-soft-success',
                            'graduated' => 'badge-soft-primary',
                            'suspended' => 'badge-soft-danger',
                            default => 'badge-soft-secondary',
                        };
                    @endphp
                    <tr>
                        <td class="text-muted fw-medium">{{ $students->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="row-avatar {{ $loop->even ? 'row-avatar--alt' : '' }}">{{ $initial }}</span>
                                <div>
                                    <a href="{{ route('admin.people.students.edit', $student) }}"
                                       class="fw-bold row-title-link text-decoration-none d-block">
                                        {{ $name }}
                                    </a>
                                    @if($student->user?->email)
                                        <span class="text-muted fs-11" dir="ltr">{{ $student->user->email }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-soft badge-soft-info" dir="ltr">
                                <i class="ri-hashtag me-1"></i>{{ $student->student_number }}
                            </span>
                        </td>
                        <td>
                            @if($student->program)
                                <span class="badge-soft badge-soft-primary">
                                    <i class="ri-book-open-line me-1"></i>{{ $student->program->name }}
                                </span>
                                @if($student->program->college)
                                    <span class="text-muted fs-11 d-block mt-1">{{ $student->program->college->name }}</span>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-soft {{ $statusClass }}">
                                {{ $statusLabels[$student->status] ?? $student->status }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btn-group">
                                <a href="{{ route('admin.people.students.edit', $student) }}"
                                   class="action-btn action-btn--edit" title="تعديل">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <button type="button"
                                        class="action-btn action-btn--delete"
                                        title="حذف"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteStudent{{ $student->id }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="ri-graduation-cap-line"></i></div>
                                @if(request()->hasAny(['search', 'program_id', 'status']))
                                    <h5 class="fw-bold mb-2">لا توجد نتائج</h5>
                                    <p class="text-muted mb-3">لم يتم العثور على طلاب مطابقين للبحث.</p>
                                    <button type="button" class="btn btn-light border btn-sm" data-ajax-reset>
                                        <i class="ri-refresh-line me-1"></i> إعادة تعيين
                                    </button>
                                @else
                                    <h5 class="fw-bold mb-2">لا يوجد طلاب بعد</h5>
                                    <p class="text-muted mb-3">ابدأ بإضافة أول طالب إلى السجل الأكاديمي.</p>
                                    <a href="{{ route('admin.people.students.create') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-user-add-line me-1"></i> إضافة طالب
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
        <div class="card-footer border-top bg-transparent py-3 ajax-pagination">
            {{ $students->withQueryString()->links() }}
        </div>
    @endif
</div>
