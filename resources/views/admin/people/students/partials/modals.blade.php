@foreach($students as $student)
    @include('admin.people.students.partials.delete', ['student' => $student])
@endforeach
