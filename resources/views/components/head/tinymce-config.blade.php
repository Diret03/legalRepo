{{--<script src="https://cdn.tiny.cloud/1/7bqonvnrcjk10cz5i3nrxsahk0xzrgnzpy64pi3au8v5cedn/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>--}}
{{--<script src="/path/to/tinymce/tinymce.min.js"></script>--}}
<script src="{{asset('assets/tinymce/tinymce.min.js')}}"></script>
<script>
    tinymce.init({
        selector: 'textarea.editor',
        plugins: ' lists',
        menubar: 'edit format',
        branding: false,
        language: 'es',
        license_key: 'gpl',
        promotion: false,
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    })

    tinymce.init({
        selector: 'textarea.editor-display',
        readonly: true,
        menubar: false,
        toolbar: false,
        branding: false,
        plugins: 'lists',
        language: 'es'
    });
</script>
