<aside class="entity-show-sidebar">
    <div class="entity-show-panel">
        <div class="entity-show-panel__head">
            <span class="entity-show-panel__icon"><i class="ri-graduation-cap-line"></i></span>
            <div>
                <h6 class="entity-show-panel__title mb-1">{{ $program->name }}</h6>
                <p class="entity-show-panel__slug mb-0" dir="ltr">{{ $program->slug }}</p>
            </div>
        </div>
        <div class="entity-show-panel__badges">
            <span class="badge bg-primary-transparent">{{ $program->level_label }}</span>
            @if($program->is_active)
                <span class="badge bg-success-transparent">نشط</span>
            @else
                <span class="badge bg-secondary-transparent">غير نشط</span>
            @endif
        </div>
    </div>

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-information-line ms-1"></i> معلومات البرنامج</h6>
        @if($program->college)
        <div class="entity-show-info-row">
            <span>الكلية</span>
            <strong>{{ $program->college->name }}</strong>
        </div>
        @endif
        @if($program->department)
        <div class="entity-show-info-row">
            <span>القسم</span>
            <strong>{{ $program->department->name }}</strong>
        </div>
        @endif
        @if($program->duration)
        <div class="entity-show-info-row">
            <span>المدة</span>
            <strong>{{ $program->duration }}</strong>
        </div>
        @endif
        @if($program->credits)
        <div class="entity-show-info-row">
            <span>الساعات المعتمدة</span>
            <strong dir="ltr">{{ $program->credits }}</strong>
        </div>
        @endif
        @if($program->students_count)
        <div class="entity-show-info-row">
            <span>الطلاب</span>
            <strong dir="ltr">{{ $program->students_count }}</strong>
        </div>
        @endif
        <div class="entity-show-info-row">
            <span>المقررات</span>
            <strong dir="ltr">{{ $program->courses->count() }}</strong>
        </div>
        <div class="entity-show-info-row">
            <span>الترتيب</span>
            <strong dir="ltr">{{ $program->sort_order }}</strong>
        </div>
    </div>

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-links-line ms-1"></i> روابط سريعة</h6>
        <div class="d-grid gap-2">
            <a href="{{ route('programs.show', $program->slug) }}" class="btn btn-light btn-sm text-start" target="_blank">
                <i class="ri-external-link-line ms-1"></i> معاينة في الموقع
            </a>
            @if($program->college)
            <a href="{{ route('admin.academic.colleges.show', $program->college) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-building-2-line ms-1"></i> صفحة الكلية
            </a>
            @endif
            @if($program->department && $program->college)
            <a href="{{ route('admin.academic.departments.show', $program->department) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-node-tree ms-1"></i> صفحة القسم
            </a>
            @endif
            <a href="{{ route('admin.academic.programs.index', array_filter(['college_id' => $program->college_id, 'department_id' => $program->department_id])) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-book-open-line ms-1"></i> كل البرامج
            </a>
            <a href="{{ route('admission') }}" class="btn btn-light btn-sm text-start" target="_blank">
                <i class="ri-user-add-line ms-1"></i> صفحة القبول
            </a>
        </div>
    </div>
</aside>
