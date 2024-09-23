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
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',

        // customize the format menu
        menu: {
            format: {
                title: 'Formato',
                items: 'bold italic underline strikethrough superscript subscript | styles blocks fontsize align lineheight | forecolor backcolor | language | removeformat'
            }
        },
        content_style: "@import url('https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap'); body { font-family: 'Figtree', sans-serif; }"
    })

    tinymce.init({
        selector: 'textarea.editor-display',
        readonly: true,
        menubar: false,
        toolbar: false,
        branding: false,
        license_key: 'gpl',
        plugins: 'lists',
        language: 'es',
        content_style: "@import url('https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap'); body { font-family: 'Figtree', sans-serif; }",
    });

    tinymce.init({
        selector: 'textarea.editor-modal',
        readonly: true,
        menubar: false,
        toolbar: false,
        branding: false,
        license_key: 'gpl',
        plugins: 'lists',
        language: 'es',
        resize: false,
        height: 200,
        content_style: "@import url('https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap'); body { font-family: 'Figtree', sans-serif; }",
    });
</script>
