<x-admin.confirm-modal
    :id="'deleteResearchCenter' . $center->id"
    title="تأكيد حذف مركز البحث"
    message="سيتم حذف المركز نهائياً من الموقع ولوحة التحكم."
    :subject="$center->name"
    :subject-meta="($center->college?->name ?? '—') . ' · ' . $center->projects_count . ' مشروع'"
    icon="ri-flask-line"
    :action="route('admin.research.centers.destroy', $center)"
    method="DELETE"
    confirm-text="نعم، احذف المركز"
/>
