<!DOCTYPE html>
<html lang="es" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No autorizado</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
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

<body class="h-full bg-gradient-to-b from-gray-100 to-gray-200 flex items-center justify-center">
    <section class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full mx-4">
        <div class="py-12 px-6 text-center">
            <div class=" mb-8 drop-shadow-xl animate-float">
                <img src="{{ asset('svg/forbidden.svg') }}" alt="No disponible icon"
                    class="mx-auto w-96 h-96 object-contain">
            </div>
            <h1
                class="mb-6 text-8xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-800">
                401</h1>
            <h2 class="mb-4 text-4xl font-bold text-gray-800">No autorizado</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">No tienes permiso para acceder a esta página</p>
            <p class="mb-8 text-xl text-gray-600 max-w-2xl mx-auto">Por favor inicia sesión</p>
            <div class="flex justify-center gap-6 my-8">
                <a href="{{ route('login') }}"
                    class="group flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    <img src="{{ asset('svg/login.svg') }}" alt="Regresa icono"
                        class="w-6 h-6 transition-transform duration-300 group-hover:-translate-x-1">
                    <span>Iniciar sesión</span>
                </a>


            </div>
        </div>
    </section>
</body>

</html>
