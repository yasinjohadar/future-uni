@foreach($centers as $center)
    @include('admin.research.centers.partials.delete', ['center' => $center])
@endforeach
