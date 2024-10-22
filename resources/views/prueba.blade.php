<x-app-layout title="Inicio">
    <x-success-error-alert/>
    <!-- Start block -->
    <section class="min-h-screen flex items-center">


        {{-- Breadcrumbs can be added here if needed --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center lg:gap-16">
            <!-- Left content: Heading and text -->
            <div class="space-y-6 text-center md:text-left lg:space-y-8">
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-tight tracking-tight text-gray-900 lg:leading-none">
                    Repositorio <span class="text-red-600">Jurídico</span> <br class="hidden sm:inline">
                </h1>
                <p class="text-sm font-light text-gray-500 max-w-2xl mx-auto md:mx-0 lg:text-base lg:max-w-xl">
                    Este es un esfuerzo mancomunado por la Corte Provincial de Justicia de Imbabura y la Escuela de
                    Derecho UTN
                </p>
                <p class="text-lg sm:text-xl font-medium text-gray-700 max-w-2xl mx-auto md:mx-0 lg:text-2xl lg:max-w-xl">
                    Acceso simplificado a casos legales, análisis y resoluciones para estudiantes, docentes y público
                    general.
                </p>
                <div class="pt-4 lg:pt-6">
                    <a href="{{ route('cases.list') }}"
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 lg:text-xl lg:px-10 lg:py-5">
                        <img class="w-7 h-7 mr-3 invert" src="{{ asset('svg/hammer.svg') }}" alt="logo martillo">
                        Explorar Casos
                    </a>
                </div>
            </div>

            <!-- Right content: Image -->
            <div class="mt-8 md:mt-0 lg:mt-0 lg:flex lg:justify-end">
                <img src="{{ asset('svg/justice.svg') }}" alt="hero image"
                     class="w-full h-auto max-w-md mx-auto drop-shadow-xl animate-float lg:max-w-lg lg:mr-0">
            </div>
        </div>
     
    </section>
    <!-- End block -->
</x-app-layout>

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

    /* Custom styles for larger screens */
    @media (min-width: 1024px) {
        h1 {
            font-size: 4.5rem; /* Bigger font for large screens */
            line-height: 1.2; /* Improve line spacing */
        }

        p {
            max-width: 48rem; /* Increase max width for better readability */
        }

        .container {
            max-width: 1280px; /* Add more space on large screens */
        }

        a {
            padding-left: 2.5rem; /* Increase padding for button */
            padding-right: 2.5rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        img {
            max-width: 24rem; /* Larger image size on bigger screens */
        }
    }
</style>
