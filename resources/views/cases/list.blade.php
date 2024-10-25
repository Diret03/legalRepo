<x-app-layout title="Todos los casos">

    <div class="flex items-center flex-wrap mb-4">
        <x-go-back route="{{ route('home') }}" />
        <h2 class="text-4xl mr-2 font-extrabold">Todos los casos</h2>
    </div>

    <div class="flex flex-col md:flex-row">
        <!-- Filter Toggle Button (visible only on small screens) -->
        <button id="filterToggle"
            class="md:hidden text-gray-500 mb-4 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
            Mostrar Filtros
        </button>

        <!-- Left Filter Container -->
        <div id="filterContainer" class="w-full md:w-1/4 pr-4 mb-4 md:mb-0 hidden md:block">
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <img src="{{ asset('svg/filter.svg') }}" class="size-6 mr-1 " alt="Filtro icon">
                        <h3 class="text-2xl font-bold">Filtros</h3>
                    </div>
                    <button id="cleanFilters" class="text-sm text-gray-500 hover:text-gray-700">
                        <div class="flex items-center">
                            <img src="{{ asset('svg/clean.svg') }}" class="size-5 mr-1 " alt="Limpiar icon">
                            Limpiar
                        </div>
                    </button>
                </div>

                <!-- Subjects Filter -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('svg/subjects.svg') }}" class="size-5 mr-1 " alt="Materias icon">
                            <h4 class="font-medium">Materias</h4>
                        </div>
                        <button id="toggleSubjects" class="text-sm text-gray-500 hover:text-gray-700">
                            Ocultar
                        </button>
                    </div>
                    <div id="subjectsContainer" class="space-y-2">
                        @foreach ($subjects as $subject)
                            <div class="flex items-center">
                                <input id="subject-{{ $subject->id }}" name="subject_ids[]" type="checkbox"
                                    value="{{ $subject->id }}"
                                    class="subject-checkbox w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2" />
                                <label for="subject-{{ $subject->id }}" class="ml-2 text-sm">
                                    {{ $subject->name }} ({{ $subject->cases_count }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Trials Filter -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('svg/trials.svg') }}" class="size-5 mr-1" alt="Juicios icon">
                            <h4 class="font-medium">Juicios</h4>
                        </div>
                        <button id="toggleTrials" class="text-sm text-gray-500 hover:text-gray-700">
                            Ocultar
                        </button>
                    </div>
                    <div id="trialsContainer" class="space-y-2">
                        @foreach ($trials as $trial)
                            <div class="flex items-center">
                                <input id="trial-{{ $trial->id }}" name="trial_ids[]" type="checkbox"
                                    value="{{ $trial->id }}"
                                    class="trial-checkbox w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2" />
                                <label for="trial-{{ $trial->id }}" class="ml-2 text-sm">
                                    {{ $trial->name }} ({{ $trial->cases_count }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <div class="mb-4 flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <div>
                    <button id="dropdownActionButton2" data-dropdown-toggle="dropdownAction2"
                        class="w-full h-full sm:w-auto inline-flex items-center justify-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5"
                        type="button">
                        <span class="sr-only">Action button</span>
                        Ordenar
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown menu (hidden by default) -->
                    <div id="dropdownAction2"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownActionButton2">
                            <li>
                                <a href="{{ route('cases.list', ['sort' => 'updated_at', 'direction' => 'desc']) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white
                                           {{ $sortField == 'updated_at' && $sortDirection == 'desc' ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                                    Más recientes
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cases.list', ['sort' => 'updated_at', 'direction' => 'asc']) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white
                                           {{ $sortField == 'updated_at' && $sortDirection == 'asc' ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                                    Más antiguos
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="relative w-full sm:w-[600px]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search" name="search"
                        class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Buscar casos">
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

            <div class="flex-grow">
                @if (count($cases) == 0)
                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            No hay casos registrados.
                        </div>
                    </div>
                @else
                    <div id="cases-data">
                        @include('cases.partials.all-list', ['cases' => $cases])
                    </div>
                    <div id="pagination" class="pagination pb-10">
                        {{ $cases->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const $filter = $('#filterToggle');
        const $subjectCheckboxes = $('.subject-checkbox');
        const $trialCheckboxes = $('.trial-checkbox');

        function getCheckedValues(checkboxes) {
            return checkboxes.filter(':checked').map(function() {
                return this.value;
            }).get();
        }


        $(document).ready(function() {
            const $loadingSpinner = $('#loading-spinner');
            const $casesData = $('#cases-data');
            let debounceTimer;

            $('#search').on('keyup', function() {
                const subjectIds = getCheckedValues($subjectCheckboxes);
                const trialIds = getCheckedValues($trialCheckboxes);
                let query = $(this).val();
                const searchParams = new URLSearchParams(window.location.search);
                let page = searchParams.get('page');
                let sort = searchParams.get('sort') || 'id';
                let direction = searchParams.get('direction') || 'asc';

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
                            'view': 'all-list',
                            'subject_ids': subjectIds,
                            'trial_ids': trialIds,
                            'page': page,
                            'sort': sort,
                            'direction': direction
                        },
                        success: function(data) {
                            $('#cases-data').html(data);
                            // Update URL with current parameters
                            const newUrl = new URL(window.location);
                            newUrl.searchParams.set('page', page);
                            newUrl.searchParams.set('sort', sort);
                            newUrl.searchParams.set('direction', direction);
                            if (query) newUrl.searchParams.set('search', query);
                            else newUrl.searchParams.delete('search');
                            window.history.pushState({}, '', newUrl);


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



            function updateResults() {
                const query = $filter.val();
                const subjectIds = getCheckedValues($subjectCheckboxes);
                const trialIds = getCheckedValues($trialCheckboxes);
                let querySearch = $('#search').val();
                const searchParams = new URLSearchParams(window.location.search);
                let page = searchParams.get('page') || 1;
                let sort = searchParams.get('sort') || 'id';
                let direction = searchParams.get('direction') || 'asc';

                clearTimeout(debounceTimer);

                if (subjectIds.length > 0 || trialIds.length > 0) {
                    $('.pagination').hide();
                } else {
                    $('.pagination').show();
                }

                debounceTimer = setTimeout(function() {
                    $loadingSpinner.removeClass('hidden');

                    $.ajax({
                        url: "{{ route('cases.filter') }}",
                        type: "GET",
                        data: {
                            'subject_ids': subjectIds,
                            'trial_ids': trialIds,
                            'search': querySearch,
                            'page': page,
                            'sort': sort,
                            'direction': direction
                        },
                        success: function(data) {
                            $('#cases-data').html(data);
                            // Update URL with current parameters
                            const newUrl = new URL(window.location);
                            newUrl.searchParams.set('page', page);
                            newUrl.searchParams.set('sort', sort);
                            newUrl.searchParams.set('direction', direction);
                            if (query) newUrl.searchParams.set('search', query);
                            else newUrl.searchParams.delete('search');
                            window.history.pushState({}, '', newUrl);
                        },
                        complete: function() {
                            // Hide the loading spinner
                            $loadingSpinner.addClass('hidden');

                            console.log("SEARCH QUERY");
                            console.log(querySearch);
                            if (querySearch) {
                                $('.pagination').hide();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al buscar:', error);
                            console.error('Detalles del error:', xhr, status);
                            // Hide the loading spinner in case of error
                            $loadingSpinner.addClass('hidden');
                        }
                    })
                }, 300);
            }
            // Event listeners
            $filter.on('input', updateResults);
            $subjectCheckboxes.on('change', updateResults);
            $trialCheckboxes.on('change', updateResults);
        });


        document.addEventListener('DOMContentLoaded', function() {

            const filterToggle = document.getElementById('filterToggle');
            const filterContainer = document.getElementById('filterContainer');
            const toggleSubjects = document.getElementById('toggleSubjects');
            const subjectsContainer = document.getElementById('subjectsContainer');
            const toggleTrials = document.getElementById('toggleTrials');
            const trialsContainer = document.getElementById('trialsContainer');
            const cleanFilters = document.getElementById('cleanFilters');

            filterToggle.addEventListener('click', function() {
                filterContainer.classList.toggle('hidden');
                filterToggle.textContent = filterContainer.classList.contains('hidden') ?
                    'Mostrar Filtros' : 'Ocultar Filtros';
            });

            toggleSubjects.addEventListener('click', function() {
                subjectsContainer.classList.toggle('hidden');
                this.textContent = subjectsContainer.classList.contains('hidden') ? 'Mostrar' : 'Ocultar';
            });

            toggleTrials.addEventListener('click', function() {
                trialsContainer.classList.toggle('hidden');
                this.textContent = trialsContainer.classList.contains('hidden') ? 'Mostrar' : 'Ocultar';
            });



            cleanFilters.addEventListener('click', function() {
                const subjectCheckboxes = Array.from(document.getElementsByClassName('subject-checkbox'));
                const trialCheckboxes = Array.from(document.getElementsByClassName('trial-checkbox'));
                const loadingSpinner = document.getElementById("loading-spinner");
                const paginationBtn = document.getElementById("pagination");

                subjectCheckboxes.forEach(element => {
                    element.checked = false;
                });

                trialCheckboxes.forEach(element => {
                    element.checked = false;
                });

                const cases_data = document.getElementById("cases-data");
                const searchParams = new URLSearchParams(window.location.search);
                let page = searchParams.get('page') || 1;
                let sort = searchParams.get('sort') || 'id';
                let direction = searchParams.get('direction') || 'asc';


                loadingSpinner.classList.remove("hidden");
                fetch('/casos/clean-filters', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        },
                        body: JSON.stringify({
                            'page': page,
                            'sort': sort,
                            'direction': direction
                        })
                    })
                    .then(response => response.text())
                    .then(response => {
                        cases_data.innerHTML = response;
                        paginationBtn.style.display = '';
                        loadingSpinner.classList.add("hidden");

                        // Update URL with current page and sorting parameters
                        const newUrl = new URL(window.location);
                        newUrl.searchParams.set('page', page);
                        newUrl.searchParams.set('sort', sort);
                        newUrl.searchParams.set('direction', direction);
                        window.history.pushState({}, '', newUrl);
                    })
                    .catch(error => console.error('Error:', error))
            });

        });
    </script>

</x-app-layout>
