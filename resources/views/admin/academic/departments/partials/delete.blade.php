<x-admin.confirm-modal
    :id="'deleteDepartment' . $department->id"
    title="تأكيد حذف القسم"
    message="لا يمكن التراجع عن هذا الإجراء. تأكد أن القسم لا يحتوي على برامج مرتبطة قبل الحذف."
    :subject="$department->name"
    :subject-meta="($department->college?->name ?? '—') . ' · ' . $department->programs_count . ' برامج'"
    :avatar-initial="mb_strtoupper(mb_substr($department->name, 0, 1))"
    icon="ri-node-tree"
    :action="route('admin.academic.departments.destroy', $department)"
    method="DELETE"
    confirm-text="نعم، احذف القسم"
/>
