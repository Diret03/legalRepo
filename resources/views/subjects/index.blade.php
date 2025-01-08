<x-app-dash-layout title="Gestión de materias">

    <div class="flex">
        <x-sidebar/>
        <!-- Main Content -->
        <div class="flex-1 m-10 relative overflow-x-auto border-t rounded-lg">
            <x-success-error-alert/>
            <div class="p-4 md:p-10 bg-white dark:bg-gray-900">
                <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                    <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                        @can('eliminar materias')
                            <div>
                                <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                                        class="w-full sm:w-auto inline-flex items-center justify-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 mr-3"
                                        type="button">
                                    <span class="sr-only">Action button</span>
                                    Acción
                                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdownAction"
                                     class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                    <ul class="py-1 text-sm text-gray-700"
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
                                          stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownAction2"
                                 class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownActionButton2">
                                    <li>
                                        <a href="{{route('subjects.index')}}?sort=updated_at&direction=desc"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600
                                            {{ (request('sort') == 'updated_at' && request('direction') == 'desc') || (!request()->has('sort') && !request()->has('direction')) ? 'bg-gray-100' : '' }}"
                                           >Más
                                            recientes</a>
                                    </li>
                                    <li>
                                        <a href="{{route('subjects.index')}}?sort=updated_at&direction=asc"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600
                                            {{ request('sort') == 'updated_at' &&  request('direction') == 'asc' ? 'bg-gray-100' : '' }}">Más
                                            antiguos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>


                    <label for="table-search" class="sr-only">Search</label>
                    <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">

                        @can('crear materias')
                            <a href="#" data-modal-target="authentication-modal"
                               data-modal-toggle="authentication-modal"
                               class="w-full sm:w-auto flex items-center justify-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 mr-5">
                                <img src="{{asset('svg/add.svg')}}" class="size-7 mr-3" alt="Agregar icon">
                                <p>Agregar Materia</p>
                            </a>
                        @endcan

                        <div class="relative w-full sm:w-80">
                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="search" name="search"
                                   class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Buscar materias">
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
                        fill="currentColor"/>
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                        Nombre
                    </th>
                    <th scope="col" class="desc px-6 py-3">
                        Descripción
                    </th>
                    <th scope="col" class="desc px-6 py-3">
                        Imagen
                    </th>
                    @if(Auth::user()->can('editar materias') || Auth::user()->can('eliminar materias'))
                        <th scope="col" class="px-6 py-3">
                            Acción
                        </th>
                    @endif
                </tr>
                </thead>
                <tbody id="subjects-data">
                @include('subjects.subject-row', ['subjects' => $subjects])
                </tbody>
            </table>
            <div id="pagination" class="pagination mt-4 pb-10">
                {{ $subjects->links() }}
            </div>
        </div>

    </div>

    @can('crear materias')
        <!-- Add subject modal -->
        <div id="authentication-modal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Agregar materia
                        </h3>
                        <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" action="{{ route('subjects.store') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="name"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                <input type="text" name="name" id="name"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                       placeholder="Escribir nombre" required value="{{ old('name') }}"/>
                            </div>
                            <div>
                                <label for="description"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                <textarea name="description" id="description" rows="5"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                          required>{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="image">Subir
                                    imagen</label>
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none"
                                    aria-describedby="image_help" id="image" name="image" type="file"
                                    accept=".jpg,.jpeg,.png,.webp">
                                <p class="mt-1 text-sm text-gray-500" id="file_input_help">JPEG, JPG, PNG o WEBP.</p>
                                <p class="mt-1 text-sm text-gray-500" id="size_input_help">
                                    Tamaño máximo: 5MB.</p>
                            </div>

                            <button type="submit"
                                    class="w-full text-white bg-red-650 hover:bg-red-300 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Agregar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <script>

        function setupToggleDescListeners(){
            document.querySelectorAll('.toggle-description').forEach(button => {
                button.addEventListener('click', function () {
                    const descriptionContent = this.nextElementSibling;
                    if (descriptionContent.classList.contains('hidden')) {
                        descriptionContent.classList.remove('hidden');
                        this.querySelector('img').src = '{{ asset('svg/minus.svg') }}';
                    } else {
                        descriptionContent.classList.add('hidden');
                        this.querySelector('img').src = '{{ asset('svg/plus.svg') }}';
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function(){
            setupToggleDescListeners()
        });

    </script>


    <script type="module">
        initializeLiveSearchNoCases('subjects', setupToggleDescListeners);
    </script>


    <script src="{{ asset('js/deleteSelected.js') }}"></script>
    <script>
        initializeDeleteFunction("{{ route('subjects.deleteSelected') }}", "subject_ids");
    </script>

</x-app-dash-layout>




