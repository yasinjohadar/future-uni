<x-admin.confirm-modal
    :id="'deleteCollege' . $college->id"
    title="تأكيد حذف الكلية"
    message="لا يمكن التراجع عن هذا الإجراء. تأكد أن الكلية لا تحتوي على أقسام مرتبطة قبل الحذف."
    :subject="$college->name"
    :subject-meta="$college->slug . ' · ' . $college->departments_count . ' أقسام · ' . $college->programs_count . ' برامج'"
    :avatar-initial="mb_strtoupper(mb_substr($college->name, 0, 1))"
    icon="ri-building-2-line"
    :action="route('admin.academic.colleges.destroy', $college)"
    method="DELETE"
    confirm-text="نعم، احذف الكلية"
/>
