<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

{{--        <title>{{ config('app.name', 'Repositorio UTN') }}</title>--}}
        <title>Repositorio Jurídico</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/tags/magicsuggest.css')}}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <x-head.tinymce-config/>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100" style="margin-bottom: -25%;">
            @include('layouts.navigation')


            <!-- Page Content -->
            <main class="">
                {{ $slot }}
            </main>
        </div>
        <script src="{{asset('assets/tags/magicsuggest.js')}}"></script>

    </body>

</html>
