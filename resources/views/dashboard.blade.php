<x-app-dash-layout title="Panel">
    {{--    <x-slot name="header"> --}}
    {{--        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight"> --}}
    {{--            {{ __('Dashboard') }} --}}
    {{--        </h2> --}}
    {{--    </x-slot> --}}

    <div class="flex">
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Bienvenido, {{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Aquí está el resumen del sistema.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <x-row-count
                    href="{{route('users.index')}}"
                    icon="svg/users.svg"
                    title="Usuarios"
                    count={{$usersCount}}
                />
                <x-row-count
                    href="{{route('subjects.index')}}"
                    icon="svg/subjects.svg"
                    title="Materias"
                    count={{$subjectsCount}}
                />
                <x-row-count
                    href="{{route('trials.index')}}"
                    icon="svg/trials.svg"
                    title="Juicios"
                    count={{$trialsCount}}
                />
                <x-row-count
                    href="{{route('cases.index')}}"
                    icon="svg/cases.svg"
                    title="Casos"
                    count={{$casesCount}}
                />
                </div>


                <div class="mt-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 ">
                            <h3 class="text-lg font-medium mb-4 text-gray-900 dark:text-gray-100">Actividad
                                Reciente</h3>
                            @if (count($cases) == 0)
                                <p class="text-gray-600 dark:text-gray-400">No hay actividad reciente para mostrar.</p>
                            @else
                                <div class="max-h-96 overflow-y-auto p-5">
                                    <ol class="relative border-s border-gray-200 dark:border-gray-700">
                                        @foreach ($cases as $case)
                                            <li class="mb-10 ms-6">

                                                @if ($case->status == 'Aceptado')
                                                    <span
                                                        class="absolute flex items-center justify-center w-6 h-6 bg-green-300 rounded-full -start-3 ring-8 ring-white">
                                                        <img src="{{ asset('svg/approved.svg') }}" class="w-5 h-5"
                                                            alt="icon" />
                                                    </span>
                                                @elseif($case->status == 'Pendiente')
                                                    <span
                                                        class="absolute flex items-center justify-center w-6 h-6 bg-blue-300 rounded-full -start-3 ring-8 ring-white">
                                                        <img src="{{ asset('svg/pending.svg') }}" class="w-11"
                                                            alt="icon" />
                                                    </span>
                                                @elseif($case->status == 'Rechazado')
                                                    <span
                                                        class="absolute flex items-center justify-center w-6 h-6 bg-red-300 rounded-full -start-3 ring-8 ring-white">
                                                        <img src="{{ asset('svg/rejected.svg') }}" class="w-4 h-4"
                                                            alt="icon" />
                                                    </span>
                                                @endif

                                                <div
                                                    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                                                    <time
                                                        class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
                                                        {{ $case->updated_at->diffForHumans() }}
                                                    </time>
                                                    @if ($case->status == 'Aceptado')
                                                        <div
                                                            class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                            Se ha aceptado el caso
                                                            <a href="{{ route('cases.show', $case->id) }}"
                                                                class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $case->title }}
                                                            </a>
                                                        </div>
                                                    @elseif($case->status == 'Rechazado')
                                                        <div
                                                            class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                            Se ha rechazado el caso
                                                            <a href="{{ route('cases.show', $case->id) }}"
                                                                class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $case->title }}
                                                            </a>
                                                        </div>
                                                    @elseif($case->status == 'Pendiente')
                                                        <div
                                                            class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                            <p class="font-semibold inline-block">
                                                                {{ $case->user->name }} {{ $case->user->last_name }}
                                                            </p>
                                                            ha subido el caso
                                                            <a href="{{ route('cases.show', $case->id) }}"
                                                                class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $case->title }}
                                                            </a>
                                                        </div>
                                                    @endif


                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>

                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-dash-layout>
