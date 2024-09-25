<x-app-layout>

    <div class="flex">
        <x-sidebar/>

        <!-- Main Content -->


        <div class="flex-1 m-10 relative overflow-x-auto border-t rounded-lg">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                     role="alert">
                    <strong class="font-bold">Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="mb-1">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div
                class="flex p-10 items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">

                <div class="flex items-center">
                    @can('eliminar juicios')
                        <div>
                            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                                    class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 mr-3"
                                    type="button">
                                <span class="sr-only">Action button</span>
                                Acción
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>

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
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5"
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
                                    <a href="{{route('trials.index')}}?sort=updated_at&direction=desc"
                                       class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Más
                                        recientes</a>
                                </li>
                                <li>
                                    <a href="{{route('trials.index')}}?sort=updated_at&direction=asc"
                                       class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Más
                                        antiguos</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <label for="table-search" class="sr-only">Search</label>
                <div class="flex items-center">

                    @can('crear juicios')
                        <a href="#" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                           class="flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 mr-5">
                            <img src="{{asset('svg/add.svg')}}" class="size-7 mr-3" alt="Agregar icon">
                            <p>Agregar Juicio</p>
                        </a>
                    @endcan

                    <div class="relative">

                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="search" name="search"
                               class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Buscar materias">
                    </div>

                </div>

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
                    <th scope="col" class="px-6 py-3">
                        Materia
                    </th>
                    <th scope="col" class="desc px-6 py-3">
                        Descripción
                    </th>
                    @if(Auth::user()->can('editar juicios') || Auth::user()->can('eliminar juicios'))
                        <th scope="col" class="px-6 py-3">
                            Acción
                        </th>
                    @endif
                </tr>
                </thead>
                <tbody id="trials-data">
                @foreach($trials as $trial)
                    <tr id="trial_ids{{$trial->id}}"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input name="ids" type="checkbox" value="{{$trial->id}}"
                                       class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox_ids" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{$trial->name}}
                        </td>
                        <td class="px-6 py-4">
                            {{$trial->subject->name}}
                        </td>
                        <td class="px-6 py-4">
                            <button
                                class="toggle-description text-blue-600 hover:underline"
                                data-project-id="{{ $trial->id }}">
                                <img src="{{ asset('svg/plus.svg') }}"
                                     class="w-5 h-5" alt="Agregar icon">
                            </button>

                            <div class="description-content hidden mt-2">
                                {{ $trial->description }}
                            </div>
                        </td>
                        @if(Auth::user()->can('editar juicios') || Auth::user()->can('eliminar juicios'))
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <a href="{{route('trials.edit',$trial->id)}}"
                                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                                        <img src="{{asset('svg/edit.svg')}}" class="size-7" alt="Editar icon">
                                    </a>
                                    <form action="{{route('trials.destroy',$trial->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este registro')">
                                            <img src="{{asset('svg/delete.svg')}}" class="size-7" alt="Borrar icon">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div class="pagination mt-4 pb-10">
                {{ $trials->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

@can('crear juicios')
    <!-- Add trial modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Agregar juicio
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
                    <form class="space-y-4" action="{{ route('trials.store') }}" method="POST"
                    >
                        @csrf
                        <div>
                            <label for="name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" name="name" id="name"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                   placeholder="Escribir nombre" required value="{{ old('name') }}"/>
                        </div>
                        <div>
                            <label for="subject_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Materia</label>
                            <select name="subject_id" id="subject_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                            <textarea name="description" id="description" rows="10"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                      required>{{ old('description') }}</textarea>
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

    function setupToggleDescriptionListeners() {
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

    $(document).ready(function () {
        setupToggleDescriptionListeners();

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
                url: "{{ route('trials.search') }}",
                type: "GET",
                data: {'search': query},
                success: function (data) {
                    $('#trials-data').html(data)
                    setupToggleDescriptionListeners();
                },
                error: function (xhr, status, error) {
                    console.error('Error al buscar:', error);
                    console.error('Detalles del error:', xhr, status);
                }
            });
        });
    });

    $(function (e) {

        $("#select_all_ids").click(function () {
            $('.checkbox_ids').prop('checked', $(this).prop('checked'));
        });
        $('#deleteAll').click(function (e) {
            e.preventDefault();
            if (!confirm("¿Estás seguro de que deseas eliminar los registros seleccionados?")) {
                return;
            }
            const all_ids = [];

            $('input:checkbox[name=ids]:checked').each(function () {
                all_ids.push($(this).val());
            });

            console.log("IDs to delete: " + all_ids);

            $.ajax({
                url: "{{route('trials.delete')}}",
                type: "DELETE",
                data: {
                    ids: all_ids,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    $.each(all_ids, function (key, val) {
                        $('trial_ids' + val).remove();
                    })
                },
                error: function (xhr, status, error) {
                    console.error('Error al buscar:', error);
                    console.error('Detalles del error:', xhr, status);
                }
            });
        });
    });


</script>
