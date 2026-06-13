@foreach($departments as $department)
    @include('admin.academic.departments.partials.delete', ['department' => $department])
@endforeach
