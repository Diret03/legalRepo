<!DOCTYPE html>
<html lang="es" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error del servidor</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Icon -->
    <link rel="shortcut icon" href="{{ asset('img/logo-utn.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body class="mih-h-screen bg-gradient-to-b from-gray-100 to-gray-200 flex items-center justify-center">
    <section class="my-8 bg-white rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full mx-4">
        <div class="py-12 px-6 text-center">
            <div class=" mb-4 lg:mb-8  drop-shadow-xl animate-float">
                <img src="{{ asset('svg/server-error.svg') }}" alt="Prohibido icon"
                    class="mx-auto w-96 hd-96 object-contain">
            </div>
            <h1
                class="mb-6 text-8xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-800">
                500</h1>
            <h2 class="mb-4 text-4xl font-bold text-gray-800">Error interno del servidor</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">El servidor no pudo completar tu solicitud.</p>
            <p class="mb-8 text-xl text-gray-600 max-w-2xl mx-auto">Puedes
                intentar recargar la página o encontrar
                más contenido al regresar a:</p>
            <div class="flex justify-center gap-6 my-8">
                <a @if (url()->previous() != url()->current()) href="{{ url()->previous() }}"
                @else
                    href="{{ route('home') }}" @endif
                    class="group flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    <img src="{{ asset('svg/return.svg') }}" alt="Regresa icono"
                        class="w-6 h-6 invert transition-transform duration-300 group-hover:-translate-x-1">
                    <span>Página anterior</span>
                </a>

                <a href="{{ route('home') }}"
                    class="group flex items-center space-x-2 bg-zinc-700 hover:bg-zinc-900 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    <img src="{{ asset('svg/home.svg') }}" alt="Inicio icono"
                        class="w-6 h-6 invert transition-transform duration-300 group-hover:rotate-12">
                    <span>Inicio</span>
                </a>
            </div>
        </div>
    </section>
</body>

</html>
