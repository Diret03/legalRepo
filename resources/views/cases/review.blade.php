<x-app-dash-layout>

    <div class="flex">
        <x-sidebar />
        <!-- Main Content -->
        <div class="flex-1 m-10 relative">
            <div class="flex items-center flex-wrap mb-8">
                <h2 class="text-4xl mr-2 font-extrabold">Revisión de casos</h2>
            </div>
            <div class="flex items-center justify-between flex-wrap -mx-2 mb-4">
                <div class="flex items-center flex-wrap -mx-2 mb-4">
                    @php
                        $bgAccepted = '';
                        $bgPending = '';
                        $bgRejected = '';
                        $bgAll = '';
                        if (request('status') == 'accepted') {
                            $bgAccepted = 'bg-green-900';
                        } else {
                            $bgAccepted = 'bg-green-500';
                        }

                        if (request('status') == 'pending' || request('status') == '') {
                            $bgPending = 'bg-blue-900';
                        } else {
                            $bgPending = 'bg-blue-600';
                        }

                        if (request('status') == 'rejected') {
                            $bgRejected = 'bg-red-900';
                        } else {
                            $bgRejected = 'bg-red-650';
                        }

                        if (request('status') == 'all') {
                            $bgAll = 'bg-purple-900';
                        } else {
                            $bgAll = 'bg-purple-500';
                        }
                    @endphp
                    <a id="pending-link" type="button" href="{{ route('cases.review') }}?status=pending"
                        class="flex items-center px-4 py-1 focus:outline-none text-white {{ $bgPending }} hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm mx-1 mb-2">
                        <img src="{{ asset('svg/pending.svg') }}" class="h-8 w-8 mr-2 invert" alt="Pendiente icon">
                        Pendientes
                    </a>
                    <a id="accepted-link" type="button" href="{{ route('cases.review') }}?status=accepted"
                        class="flex items-center px-4 py-2 focus:outline-none text-white {{ $bgAccepted }} hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm mx-1 mb-2">
                        <img src="{{ asset('svg/approved.svg') }}" class="h-6 w-6 mr-2 invert" alt="Aceptado icon">
                        Aceptados
                    </a>
                    <a id="rejected-link" type="button" href="{{ route('cases.review') }}?status=rejected"
                        class="flex items-center px-4 py-2 focus:outline-none text-white {{ $bgRejected }} hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm mx-1 mb-2">
                        <img src="{{ asset('svg/rejected.svg') }}" class="h-6 w-6 mr-2 invert" alt="Rechazado icon">
                        Rechazados
                    </a>
                    <a type="button" href="{{ route('cases.review') }}?status=all"
                        class="px-4 py-2 focus:outline-none text-white {{ $bgAll }} hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm mx-1 mb-2">
                        Todos
                    </a>
                </div>

                <div class="flex items-center">
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="search" name="search"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar casos">
                    </div>
                </div>
            </div>
            <div role="status" id="loading-spinner"
                class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-red-650"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>


            <x-success-error-alert/>

            <div class="flex-grow">
                @if ($cases->count() == 0)
                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            No hay casos existentes.
                        </div>
                    </div>
                @else
                    <div id="cases-data" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                        @include('cases.partials.reviewlist', ['cases' => $cases])
                    </div>

                    <div class="pagination pb-10">
                        {{ $cases->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const $loadingSpinner = $('#loading-spinner');
            const $casesData = $('#cases-data');
            let debounceTimer;

            $('#search').on('keyup', function() {
                let query = $(this).val();
                // Clear the previous timer
                clearTimeout(debounceTimer);

                if (query.length > 0) {
                    $('.pagination').hide();
                } else {
                    $('.pagination').show();
                }

                // Set a new timer
                debounceTimer = setTimeout(function() {
                    // Show the loading spinner
                    $loadingSpinner.removeClass('hidden');

                    $.ajax({
                        url: "{{ route('cases.search') }}",
                        type: "GET",
                        data: {
                            'search': query,
                            'view': "review",
                        },
                        success: function(data) {
                            $casesData.html(data);
                        },
                        complete: function() {
                            // Hide the loading spinner
                            $loadingSpinner.addClass('hidden');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al buscar:', error);
                            console.error('Detalles del error:', xhr, status);
                            // Hide the loading spinner in case of error
                            $loadingSpinner.addClass('hidden');
                        }
                    });
                }, 300); // delay time
            });
        });
    </script>
</x-app-dash-layout>
