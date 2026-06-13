@php
    $selectors = $selectors ?? ['#description'];
@endphp
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
<script src="{{ asset('assets/js/admin-tinymce.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.AdminTinyMCE) {
            window.AdminTinyMCE.init({
                selectors: @json($selectors),
                form: document.querySelector('[data-tinymce-form]')
            });
        }
    });
</script>
