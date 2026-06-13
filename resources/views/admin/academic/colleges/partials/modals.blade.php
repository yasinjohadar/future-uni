@foreach($colleges as $college)
    @include('admin.academic.colleges.partials.delete', ['college' => $college])
@endforeach
