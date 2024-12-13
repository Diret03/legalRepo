<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Diego Recalde">

    {{--        <title>{{ config('app.name', 'Repositorio UTN') }}</title> --}}
    <title>Acerca</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/tags/magicsuggest.css') }}">

    <!-- Icon -->
    <link rel="shortcut icon" href="{{asset('img/logo-utn.png')}}" type="image/x-icon">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    @include('layouts.navigation')
    <section class="pb-36 lg:pb-20 bg-gray-50">
        <div class="text-center mb-16 py-12 bg-zinc-700 shadow-lg">
            <h1 class="font-extrabold text-4xl lg:text-5xl text-white mb-4">Acerca de Nosotros</h1>
            <p class=" text-xl text-white max-w-3xl mx-auto">
                Bienvenido al Repositorio Jurídico, una plataforma diseñada para facilitar el acceso y
                estudio de casos legales relevantes. Este es un esfuerzo mancomunado por la Corte Provincial de Justicia
                de Imbabura y la Escuela de Derecho UTN
            </p>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch mb-20">
                <div class="order-2 lg:order-1 rounded-xl shadow-lg p-8 lg:p-12 border-2 lg:border-4 border-zinc-700">
                    <h2 class="font-bold text-3xl text-gray-900 mb-6">Nuestra Misión</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        La Universidad Técnica del Norte y la Corte Provincial de Imbabura se unen firmemente para
                        fortalecer la transparencia y la participación ciudadana en el ámbito judicial. Nuestro objetivo
                        es convertirnos en una herramienta esencial para estudiantes y profesionales, promoviendo la
                        investigación, el aprendizaje y la práctica del Derecho a través del estudio de casos prácticos
                        relevantes de la provincia.
                    </p>
                </div>
                <div class="order-1 lg:order-2 h-full">
                    <img src="{{ asset('img/ecuador.jpg') }}" alt="Imagen consultorio juridico"
                        class="w-full h-full object-cover rounded-lg shadow-xl">
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8 lg:p-12 mb-20 border-2 lg:border-4 border-zinc-700">
                <h2 class="font-bold text-3xl text-gray-900 mb-6">Nuestra Visión</h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Aspiramos a ser el repositorio jurídico virtual líder en la provincia, reconocido por nuestra
                    exhaustividad y calidad en la recopilación, análisis y presentación de casos prácticos reales.
                    Buscamos fomentar una cultura de conocimiento jurídico y excelencia académica, apoyando a las
                    futuras generaciones de juristas en su desarrollo académico y profesional, al tiempo que
                    contribuimos a la transparencia y accesibilidad de la justicia.
                </p>
            </div>

            <div>
                <h2 class=" font-bold text-3xl text-gray-900 mb-8 text-center">Valores Institucionales</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center border-2 lg:border-4 border-red-650">
                        <div class="flex justify-center gap-3 p-4">
                            <img src="{{ asset('svg/respect.svg') }}" alt="Respeto icono" class="w-10">
                            <h3 class="font-semibold text-xl text-gray-900 mb-2 my-auto">Respeto</h3>
                        </div>
                        <p class=" text-gray-600">Valoramos y honramos la dignidad de cada individuo.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 text-center border-2 lg:border-4 border-red-650">
                        <div class="flex justify-center gap-3 p-4">
                            <img src="{{ asset('svg/social-justice.svg') }}" alt="Justicia social icono" class="w-10">
                            <h3 class="font-semibold text-xl text-gray-900 mb-2 my-auto">Justicia Social</h3>
                        </div>
                        <p class=" text-gray-600">Promovemos la equidad y la igualdad en todos los ámbitos.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 text-center border-2 lg:border-4 border-red-650">
                        <div class="flex justify-center gap-3 p-4">
                            <img src="{{ asset('svg/loyalty.svg') }}" alt="Lealtad icono" class="w-10">
                            <h3 class="font-semibold text-xl text-gray-900 mb-2 my-auto">Lealtad</h3>
                        </div>
                        <p class=" text-gray-600">Mantenemos un compromiso firme con nuestros principios e
                            institución.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 text-center border-2 lg:border-4 border-red-650">
                        <div class="flex justify-center gap-3 p-4">
                            <img src="{{ asset('svg/equity.svg') }}" alt="Equidad icono" class="w-10">
                            <h3 class="font-semibold text-xl text-gray-900 mb-2 my-auto">Equidad</h3>
                        </div>
                        <p class=" text-gray-600">Aseguramos un trato justo e imparcial para todos.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 text-center border-2 lg:border-4 border-red-650">
                        <div class="flex justify-center gap-3 p-4">
                            <img src="{{ asset('svg/transparency.svg') }}" alt="Transpariencia icono" class="w-10">
                            <h3 class="font-semibold text-xl text-gray-900 mb-2 my-auto">Transparencia</h3>
                        </div>
                        <p class=" text-gray-600">Actuamos con claridad y facilitamos el acceso a la
                            información.</p>
                    </div>
                </div>
            </div>

            @if(count($judges) > 0)
                <section class="mt-20">
                    <h2 class=" font-bold text-3xl text-gray-900 mb-8 text-center">Jueces involucrados</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($judges as $judge)
                            <div class="flex flex-col items-center">
                                <div class="w-48 h-48 mb-4 overflow-hidden rounded-full border-2 lg:border-4 border-zinc-700">
                                    <img src="{{ $judge->image ? asset($judge->image) : asset('svg/person.svg') }}" alt="{{ $judge->name }} {{ $judge->last_name }}" class="w-full h-full object-cover object-center">
                                </div>
                                <h3 class="font-bold text-xl mb-2 text-center">{{ $judge->name }} {{ $judge->last_name }}</h3>
                                <p class="text-gray-700 text-base text-center">{{ $judge->job_title }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>

    <footer class="bg-zinc-700 text-white py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Contáctenos</h3>
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ asset('svg/address.svg') }}" alt="Direccion icono" class="w-7 invert">
                        <p> Av. 17 de Julio 5-21, Ibarra,
                            Ecuador
                        </p>
                    </div>
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ asset('svg/telephone.svg') }}" alt="Telefono icono" class="w-6 invert">
                        <p>+593 06 2997800</p>
                    </div>
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ asset('svg/email.svg') }}" alt="Email icono" class="w-5 invert">
                        <p>repositoriojuridico@utn.edu.ec</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Enlaces Rápidos</h3>
                    <ul>
                        <li class="mb-2">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('svg/home.svg') }}" alt="Inicio icono" class="w-5 invert">
                                <a href="{{ route('home') }}" class="hover:text-gray-300">Inicio</a>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('svg/cases.svg') }}" alt="Casos icono" class="w-5 invert">
                                <a href="{{ route('cases.list') }}" class="hover:text-gray-300">Casos</a>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('svg/subjects.svg') }}" alt="Materias icono" class="w-5 invert">
                                <a href="{{ route('subjects.list') }}" class="hover:text-gray-300">Materias</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('svg/tags.svg') }}" alt="Etiquetas icono" class="w-5 invert">
                                <a href="{{ route('tags.list') }}" class="hover:text-gray-300">Etiquetas</a>
                            </div>
                        </li>
                    </ul>
                </div>
                {{-- <div>
                <h3 class="text-xl font-bold mb-4">Redes Sociales</h3>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-gray-300"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-gray-300"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-gray-300"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="hover:text-gray-300"><i class="fab fa-instagram"></i></a>
                </div>
            </div> --}}
                <div>
                    <h3 class="text-xl font-bold mb-4">Buzón de sugerencias</h3>
                    <p class="mb-4">Escríbenos para dejar tu feedback y mejorar la aplicación.</p>
                    <form class="flex">


                        <a href="mailto:repositoriojuridico@utn.edu.ec"
                            class="flex items-start gap-2 group bg-red-650 text-white px-4 py-2 rounded-r-md hover:bg-white hover:text-black transition duration-300">
                            <img src="{{ asset('svg/feedback.svg') }}" alt="Feedback icono"
                                class="w-5 invert group-hover:invert-0">
                            Escríbenos
                        </a>


                    </form>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-white text-center">
                <p>&copy; {{ date('Y') }} Repositorio Jurídico UTN. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>

</html>
