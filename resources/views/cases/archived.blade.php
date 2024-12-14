<x-app-dash-layout title="Gestión de casos archivados">
    <div class="flex">
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 m-10 relative overflow-x-auto border-t rounded-lg">

            <x-success-error-alert/>

            <div class="p-4 md:p-10 bg-white dark:bg-gray-900">
                <div class="flex items-center mb-3">
                    <x-go-back route="{{ route('cases.index') }}" />
                    <p class="text-2xl font-bold ml-2">Casos archivados</p>
                </div>
                <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                    <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                        @can('eliminar cualquier caso')
                            <div>
                                <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                                    class="w-full sm:w-auto inline-flex items-center justify-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5"
                                    type="button">
                                    <span class="sr-only">Action button</span>
                                    Acción
                                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu (hidden by default) -->
                                <div id="dropdownAction"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownActionButton">
                                        <li>
                                            <a href="#" id="deleteAll"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Eliminar</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endcan

                        <div>
                            <button id="dropdownActionButton2" data-dropdown-toggle="dropdownAction2"
                                class="w-full sm:w-auto inline-flex items-center justify-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5"
                                type="button">
                                <span class="sr-only">Action button</span>
                                Ordenar
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu (hidden by default) -->
                            <div id="dropdownAction2"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownActionButton2">
                                    <li>
                                        <a href="{{route('cases.archived')}}?sort=updated_at&direction=desc"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600
                                            {{ (request('sort') == 'updated_at' && request('direction') == 'desc') || (!request()->has('sort') && !request()->has('direction')) ? 'bg-gray-100' : '' }}"
                                        >Más
                                            recientes</a>
                                    </li>
                                    <li>
                                        <a href="{{route('cases.archived')}}?sort=updated_at&direction=asc"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600
                                            {{ request('sort') == 'updated_at' &&  request('direction') == 'asc' ? 'bg-gray-100' : '' }}">Más
                                            antiguos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                        <div class="relative w-full sm:w-80">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="search" name="search"
                                class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Buscar casos archivados">
                        </div>
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
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-5">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="select_all_ids" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="select_all_ids" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nro.
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Usuario
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Título
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Materia
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Juicio
                        </th>
                        <th scope="col" class="desc px-6 py-3">
                            Detalles
                        </th>
                        <th scope="col" class="stat px-6 py-3">
                            Estado
                        </th>
                        @if (Auth::user()->can('restaurar casos') || Auth::user()->can('eliminar casos definitivamente'))
                            <th scope="col" class="px-6 py-3">
                                Acción
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="cases-data">
                    @include('cases.partials.archived-row', ['cases' => $cases])
                </tbody>

            </table>
            <div class="pagination mt-4 pb-10">
                {{ $cases->links() }}
            </div>

        </div>
    </div>

</x-app-dash-layout>

<script src="{{ asset('js/renderTiny.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-modal-target]').forEach(function(button) {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-target');

                // Call the function and pass the modalId
                applyTailwindStyles(modalId);
            });
        });
    });

    // Function to initialize modal functionality
    function initializeModals() {
        const modalButtons = document.querySelectorAll('[data-modal-toggle]');
        const closeButtons = document.querySelectorAll('[data-modal-hide]');

        modalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetModal = document.getElementById(button.getAttribute('data-modal-target'));
                targetModal.classList.remove('hidden');
                targetModal.classList.add('flex');
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetModal = button.closest('.fixed');
                targetModal.classList.add('hidden');
                targetModal.classList.remove('flex');
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', (event) => {
            const modals = document.querySelectorAll('[id^="case-modal-"]');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });
    }

    function initializeTinyMCE() {
        tinymce.remove(); // Remove any existing instances
        tinymce.init({
            selector: 'textarea.editor-modal',
            readonly: true,
            menubar: false,
            toolbar: false,
            branding: false,
            license_key: 'gpl',
            plugins: 'lists',
            language: 'es',
            resize: false,
            height: 200,
            content_style: "@import url('https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap'); body { font-family: 'Figtree', sans-serif; }",
        });
    }

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
                        'view': "table",
                    },
                    success: function(data) {
                        $casesData.html(data);
                    },
                    complete: function() {
                        // Hide the loading spinner
                        $loadingSpinner.addClass('hidden');
                        initializeModals();
                        initializeTinyMCE();
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

<script src="{{ asset('js/forceDeleteSelected.js') }}"></script>
<script>
    initializeDeleteFunction("{{ route('cases.forceDeleteSelected')}}", "case_ids");
</script>
