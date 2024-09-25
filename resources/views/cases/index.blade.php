
<x-app-layout>
    <style>
        .modal-body {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }
    </style>
    <div class="flex">
        <x-sidebar/>

        <!-- Main Content -->
        <div class="flex-1 m-10 relative overflow-x-auto border-t rounded-lg">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
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
            <div class="flex p-10 items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">

                <div class="flex items-center">
                    @can('eliminar casos')
                        <div>
                            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                                    class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 mr-3"
                                    type="button">
                                <span class="sr-only">Action button</span>
                                Acción
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                                    <li>
                                        <a href="#" id="deleteAll" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Eliminar</a>
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
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div id="dropdownAction2" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton2">
                                <li>
                                    <a href="{{route('cases.index')}}?sort=date&direction=desc"
                                       class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Más recientes</a>
                                </li>
                                <li>
                                    <a href="{{route('cases.index')}}?sort=date&direction=asc"
                                       class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Más antiguos</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <label for="table-search" class="sr-only">Search</label>
                <div class="flex items-center">
                    @can('crear casos')
                        <a href="{{route('cases.create')}}"
                           class="flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 mr-5">
                            <img src="{{asset('svg/add.svg')}}" class="size-7 mr-3" alt="Agregar icon">
                            <p>Agregar Caso</p>
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
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Origen
                    </th>
                    <th scope="col" class="desc px-6 py-3">
                        Detalles
                    </th>
                    <th scope="col" class="stat px-6 py-3">
                        Estado
                    </th>
                    @if(Auth::user()->can('editar cualquier caso') || Auth::user()->can('eliminar cualquier caso'))
                        <th scope="col" class="px-6 py-3">
                            Acción
                        </th>
                    @endif
                </tr>
                </thead>
                <tbody id="cases-data">
                @foreach($cases as $case)
                    <tr id="case_ids{{$case->id}}"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input name="ids" type="checkbox" value="{{$case->id}}"
                                       class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox_ids" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-black">
                                <div class="text-base font-semibold">{{$case->user->name}} {{$case->user->last_name}}</div>
                                <div class="font-normal text-gray-500">{{$case->user->email}}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{$case->title}}
                        </td>
                        <td class="px-6 py-4">
                            {{$case->trial->subject->name}}
                        </td>
                        <td class="px-6 py-4">
                            {{$case->trial->name}}
                        </td>
                        <td class="px-6 py-4">
                            {{\Carbon\Carbon::parse($case->date)->format('d/m/Y')}}
                        </td>
                        <td class="px-6 py-4">
                            {{$case->origin}}
                        </td>
                        <td class="px-6 py-4">
                            <button data-modal-target="case-modal-{{$case->id}}" data-modal-toggle="case-modal-{{$case->id}}" class="block text-white bg-red-650 hover:bg-red-200 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                Ver
                            </button>
                            <div id="case-modal-{{$case->id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-5xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Detalles del Caso
                                            </h3>
                                            <button type="button" class="details-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="case-modal-{{$case->id}}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Cerrar modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body p-4 md:p-5 space-y-4">
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">Etiquetas</h4>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($case->tags as $tag)
                                                        <a  href="{{ route('cases.showByTag', $tag->id) }}"
                                                            class="bg-red-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                                            {{ $tag->name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">Contexto</h4>
                                                <textarea class="editor-modal" name="context">{{$case->context}}</textarea>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">Análisis</h4>
                                                <textarea class="editor-modal" name="context">{{$case->analysis}}</textarea>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">Resolución</h4>
                                                <textarea class="editor-modal" name="context">{{$case->resolution}}</textarea>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">Notas</h4>
                                                <textarea class="editor-modal" name="context">{{$case->note}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col items-center">
                                @if($case->status == 'Aceptado')
                                    <img src="{{asset('svg/approved.svg')}}" class="h-5 w-5 mb-2" alt="Aceptado icon">
                                @elseif($case->status == 'Pendiente')
                                    <img src="{{asset('svg/pending.svg')}}" class="h-8 w-8 mb-2" alt="Pendiente icon">
                                @elseif($case->status == 'Rechazado')
                                    <img src="{{asset('svg/rejected.svg')}}" class="h-5 w-5 mb-2" alt="Rechazado icon">
                                @endif
                                <span>{{$case->status}}</span>
                            </div>
                        </td>
                        @if(Auth::user()->can('editar cualquier caso') || Auth::user()->can('eliminar cualquier caso'))
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <a href="{{route('cases.edit',$case->id)}}"
                                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                                        <img src="{{asset('svg/edit.svg')}}" class="size-7" alt="Editar icon">
                                    </a>
                                    <form action="{{route('cases.destroy',$case->id)}}" method="POST">
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
                    {{ $cases->links() }}
                </div>

        </div>
    </div>

</x-app-layout>

<script src="{{asset('js/renderTiny.js')}}"></script>
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

    $(document).ready(function () {
        // setupToggleDescriptionListeners();
        // $('.editor'.getBody()).find('ul').addClass('list-disc');

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
                data: {'search': query},
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
                url: "{{route('cases.delete')}}",
                type: "DELETE",
                data: {
                    ids: all_ids,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    $.each(all_ids, function (key, val) {
                        $('cases_ids' + val).remove();
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

