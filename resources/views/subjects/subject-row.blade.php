@foreach($subjects as $subject)
    <tr id="subject_ids{{$subject->id}}"
        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="w-4 p-4">
            <div class="flex items-center">
                <input name="ids" type="checkbox" value="{{$subject->id}}"
                       class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox_ids" class="sr-only">checkbox</label>
            </div>
        </td>
        <td class="px-6 py-4">
            {{$subject->name}}
        </td>
        <td class="px-6 py-4">
            <button
                class="toggle-description text-blue-600 hover:underline"
                data-project-id="{{ $subject->id }}">
                <img src="{{ asset('svg/plus.svg') }}"
                     class="w-5 h-5" alt="Agregar icon">
            </button>
            <div class="description-content hidden mt-2">
                {{ $subject->description }}
            </div>
        </td>
        <td class="px-6 py-4">
            <img class="size-20"
                 src="{{ $subject->image ? asset($subject->image) : asset('svg/no-image.svg') }}"
                 alt="Materia imagen"/>

        </td>
        @if(Auth::user()->can('editar materias') || Auth::user()->can('eliminar materias'))
            <td class="px-6 py-4">
                <div class="flex items-center">
                    @can('editar materias')
                        <a href="#" data-modal-target="edit-modal-{{$subject->id}}" data-modal-toggle="edit-modal-{{$subject->id}}"
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                            <img src="{{asset('svg/edit.svg')}}" class="w-7 h-7" alt="Editar icon">
                        </a>
                        <!-- Edit subject modal -->
                        <div id="edit-modal-{{$subject->id}}" tabindex="-1" aria-hidden="true"
                             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Editar materia
                                        </h3>
                                        <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-hide="edit-modal-{{$subject->id}}">
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
                                        <form id="edit-user-form" class="space-y-4" method="POST" action="{{ route('subjects.update', $subject->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <label for="edit-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                                <input type="text" name="name" id="edit-name" value="{{$subject->name}}"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"/>
                                            </div>
                                            <div>
                                                <label for="edit-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                                <textarea name="description" id="edit-description" rows="5"
                                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                >{{$subject->description}}</textarea>
                                            </div>
                                            <div>
                                                <label class="block mb-2 text-sm font-medium text-gray-900" for="edit_image">Subir imagen</label>
                                                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none" aria-describedby="image_help" id="edit_image" name="image" type="file">
                                                <p class="mt-1 text-sm text-gray-500" id="file_input_help">JPEG, JPG, PNG o WEBP.</p>
                                                <p class="mt-1 text-sm text-gray-500" id="size_input_help">
                                                    Tamaño máximo: 5MB.</p>
                                                <p class="mt-1 text-sm text-gray-500">Dejar en blanco para mantener la foto actual </p>
                                            </div>
                                            <button type="submit"
                                                    class="w-full text-white bg-red-650 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Guardar cambios
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{route('subjects.destroy',$subject->id)}}" method="POST">
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
