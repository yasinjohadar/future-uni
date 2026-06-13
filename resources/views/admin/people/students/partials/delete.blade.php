<x-admin.confirm-modal
    :id="'deleteStudent' . $student->id"
    title="تأكيد حذف الطالب"
    message="لا يمكن التراجع عن هذا الإجراء. سيتم حذف سجل الطالب من النظام."
    :subject="$student->user?->name ?? $student->student_number"
    :subject-meta="$student->student_number . ' · ' . ($student->program?->name ?? 'بدون برنامج')"
    :avatar-initial="mb_strtoupper(mb_substr($student->user?->name ?? $student->student_number, 0, 1))"
    icon="ri-graduation-cap-line"
    :action="route('admin.people.students.destroy', $student)"
    method="DELETE"
    confirm-text="نعم، احذف الطالب"
/>
