<x-app-layout>

    <div class="flex">
        <x-sidebar/>
        <!-- Main Content -->
        <div class="flex-1 m-10 relative">
            <div class="flex items-center flex-wrap mb-8">
                <h2 class="text-4xl mr-2 font-extrabold">Mis casos</h2>
            </div>
            <div class="flex items-center justify-between flex-wrap -mx-2 mb-4">
                <div class="flex items-center flex-wrap">
                    <a id="accepted-link" type="button" href="{{route('cases.mycases',Auth::user()->id)}}?status=accepted"
                       class="flex items-center px-4 py-2 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm mx-1 mb-2">
                        <img src="{{asset('svg/approved.svg')}}" class="h-6 w-6 mr-2 invert" alt="Aceptado icon">
                        Aceptados
                    </a>
                    <a id="pending-link" type="button" href="{{route('cases.mycases',Auth::user()->id)}}?status=pending"
                       class="flex items-center px-4 py-1 focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm mx-1 mb-2">
                        <img src="{{asset('svg/pending.svg')}}" class="h-8 w-8 mr-2 invert" alt="Pendiente icon">
                        Pendientes
                    </a>
                    <a id="rejected-link" type="button" href="{{route('cases.mycases',Auth::user()->id)}}?status=rejected"
                       class="flex items-center px-4 py-2 focus:outline-none text-white bg-red-650 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm mx-1 mb-2">
                        <img src="{{asset('svg/rejected.svg')}}" class="h-6 w-6 mr-2 invert" alt="Rechazado icon">
                        Rechazados
                    </a>
                    <a type="button" href="{{route('cases.mycases',Auth::user()->id)}}?status=all"
                       class="px-4 py-2 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm mx-1 mb-2">
                        Todos
                    </a>
                </div>

                <div class="flex items-center">
                    @can('crear casos')
                        <a href="{{route('cases.create')}}"
                           class="flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 mr-5">
                            <img src="{{asset('svg/add.svg')}}" class="size-7 mr-3" alt="Agregar icon">
                            <p>Subir Caso</p>
                        </a>
                    @endcan
                    <div class="relative">
                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="search" name="search"
                               class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Buscar casos">
                    </div>
                </div>
            </div>


            <div class="flex-grow">
                @if($cases->count() == 0)
                    <div
                        class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            @if(request('status') == 'rejected')
                                No tienes casos rechazados.
                            @elseif(request('status') == 'pending')
                                No tienes casos pendientes.
                            @elseif(request('status') == 'approved')
                                No tienes casos aprobados.
                            @else
                                Aún no has subido casos.
                            @endif
                        </div>
                    </div>
                @else
                    <div id="cases-data" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                        @include('cases.partials.mylist', ['cases' => $cases])
                    </div>

                    <div class="pagination pb-10">
                        {{ $cases->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#search').on('keyup', function () {
                let query = $(this).val();

                if (query.length > 0) {
                    // hide pagination links container
                    $('.pagination').hide();
                } else {
                    // show pagination links container when input is empty
                    $('.pagination').show();
                }

                $.ajax({
                    url: "{{ route('cases.search') }}",
                    type: "GET",
                    data: {
                        'search': query,
                        'view': "mycases",
                    },

                    success: function (data) {
                        $('#cases-data').html(data)
                        // setupToggleDescriptionListeners();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al buscar:', error);
                        console.error('Detalles del error:', xhr, status);
                    }
                });
            });

        });
    </script>
</x-app-layout>
