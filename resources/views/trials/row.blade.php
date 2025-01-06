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
                    @can('editar juicios')
                        <a href="#" data-modal-target="edit-modal-{{$trial->id}}" data-modal-toggle="edit-modal-{{$trial->id}}"
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                            <img src="{{asset('svg/edit.svg')}}" class="w-7 h-7" alt="Editar icon">
                        </a>
                        <!-- Edit trial modal -->
                        <div id="edit-modal-{{$trial->id}}" tabindex="-1" aria-hidden="true"
                             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Editar juicio
                                        </h3>
                                        <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-hide="edit-modal-{{$trial->id}}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5">
                                        <form id="edit-user-form" class="space-y-4" method="POST" action="{{ route('trials.update', $trial->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <label for="edit-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                                <input type="text" name="name" id="edit-name" value="{{$trial->name}}"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"/>
                                            </div>
                                            <div>
                                                <label for="edit-subject_id"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Materia</label>
                                                <select name="subject_id" id="edit-subject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                    @foreach($subjects as $subject)
                                                        @if ($subject->id === $trial->subject->id)
                                                            <option selected value="{{$subject->id}}">{{$subject->name}}</option>
                                                        @else
                                                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label for="edit-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                                <textarea name="description" id="edit-description" rows="10"
                                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                >{{$trial->description}}</textarea>
                                            </div>
                                            <button type="submit"
                                                    class="w-full text-white bg-red-650 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                Guardar cambios
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{route('trials.destroy',$trial->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">
                            <img src="{{asset('svg/delete.svg')}}" class="size-7" alt="Borrar icon">
                        </button>
                    </form>
                </div>
            </td>
        @endif
    </tr>
@endforeach
