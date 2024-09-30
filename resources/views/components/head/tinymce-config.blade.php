{{--<script src="https://cdn.tiny.cloud/1/7bqonvnrcjk10cz5i3nrxsahk0xzrgnzpy64pi3au8v5cedn/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>--}}
{{--<script src="/path/to/tinymce/tinymce.min.js"></script>--}}
<script src="{{asset('assets/tinymce/tinymce.min.js')}}"></script>
<script>
    tinymce.init({
        selector: 'textarea.editor',
        plugins: 'lists paste',  // Ensure the 'paste' plugin is included
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
                items: 'bold italic underline strikethrough superscript subscript | styles blocks fontfamily fontsize align lineheight | forecolor backcolor | language | removeformat',
            }
        },

        //Figtree as the top font in the font family list
        font_family_formats: 'Figtree=figtree; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Tahoma=tahoma,arial,helvetica,sans-serif; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings;',

        // Figtree font as default
        content_style: "@import url('https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap'); body { font-family: 'Figtree', sans-serif; }",

    });



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
