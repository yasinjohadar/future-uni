@foreach($books as $book)
    <x-admin.confirm-modal
        :id="'deleteLibraryBook' . $book->id"
        title="حذف الكتاب"
        :message="'هل أنت متأكد من حذف «' . $book->title . '»؟'"
        :action="route('admin.library.books.destroy', $book)"
        method="DELETE"
        confirm-text="نعم، احذف"
        variant="danger"
    />
@endforeach
