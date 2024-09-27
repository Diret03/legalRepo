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
            <img class="size-16"
                 src="{{ $subject->image ? asset($subject->image) : asset('svg/no-image.svg') }}"
                 alt="Materia imagen"/>

        </td>
        @if(Auth::user()->can('editar materias') || Auth::user()->can('eliminar materias'))
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <a href="{{route('subjects.edit',$subject->id)}}"
                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                        <img src="{{asset('svg/edit.svg')}}" class="size-7" alt="Editar icon">
                    </a>
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
