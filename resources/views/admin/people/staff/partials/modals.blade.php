@foreach($staffMembers as $member)
    @include('admin.people.staff.partials.delete', ['member' => $member])
@endforeach
