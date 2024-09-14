<x-app-layout>
    <!-- Start block -->
    <section class="bg-white min-h-screen flex items-center">
        <div class="container mx-auto px-4 py-8 sm:py-14 lg:py-10">
{{--            {{ Breadcrumbs::render('home') }}--}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-6 text-center md:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-gray-900">
                        Repositorio <span class="text-red-600">Jurídico</span> <br class="hidden sm:inline">UTN
                    </h1>
                    <p class="text-lg sm:text-xl font-medium text-gray-700 max-w-2xl mx-auto md:mx-0">
                        Acceso simplificado a casos legales, análisis y resoluciones para estudiantes, docentes y público general.
                    </p>
                    <div class="pt-4">
                        <a href="{{route('cases.list')}}"
                           class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                            <img class="w-6 h-6 mr-2 invert" src="{{asset('svg/hammer.svg')}}" alt="logo martillo">
                            Explorar Casos
                        </a>
                    </div>
                </div>
                <div class="mt-8 md:mt-0">
                    <img src="{{ asset('svg/justice.svg') }}" alt="hero image" class="w-full h-auto max-w-md mx-auto drop-shadow-xl animate-float">
                </div>
            </div>
        </div>
    </section>
    <!-- End block -->
</x-app-layout>

<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
</style>
