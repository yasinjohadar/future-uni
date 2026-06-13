<x-admin.confirm-modal
    :id="'deleteStaff' . $member->id"
    title="تأكيد حذف العضو"
    message="لا يمكن التراجع عن هذا الإجراء. سيتم حذف سجل العضو من النظام."
    :subject="$member->name"
    :subject-meta="($member->type?->label() ?? '—') . ' · ' . ($member->position ?: 'بدون منصب')"
    :avatar-initial="mb_strtoupper(mb_substr($member->name, 0, 1))"
    icon="ri-team-line"
    :action="route('admin.people.staff.destroy', $member)"
    method="DELETE"
    confirm-text="نعم، احذف العضو"
/>
