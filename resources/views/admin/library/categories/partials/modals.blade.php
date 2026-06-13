@foreach($categories as $category)
    <x-admin.confirm-modal
        :id="'deleteLibraryCategory' . $category->id"
        title="حذف التصنيف"
        :message="'هل أنت متأكد من حذف «' . $category->name . '»؟'"
        :action="route('admin.library.categories.destroy', $category)"
        method="DELETE"
        confirm-text="نعم، احذف"
        variant="danger"
    />
@endforeach
