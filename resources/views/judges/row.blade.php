@foreach($judges as $judge)
    <tr id="judge_ids{{$judge->id}}"
        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="w-4 p-4">
            <div class="flex items-center">
                <input name="ids" type="checkbox" value="{{$judge->id}}"
                       class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox_ids" class="sr-only">checkbox</label>
            </div>
        </td>
        <td class="px-6 py-4">
            {{$judge->name}}
        </td>
        <td class="px-6 py-4">
            {{$judge->last_name}}
        </td>
        <td class="px-6 py-4">
            {{$judge->job_title}}
        </td>
        <td class="px-6 py-4">
            <img class="size-20"
                 src="{{ $judge->image ? asset($judge->image) : asset('svg/no-image.svg') }}"
                 alt="Juez imagen"/>
        </td>
        @if(Auth::user()->can('editar jueces') || Auth::user()->can('eliminar jueces'))
            <td class="px-6 py-4">
                <div class="flex items-center">
                    @can("editar jueces")
                        <a href="{{route('judges.edit',$judge->id)}}"
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                            <img src="{{asset('svg/edit.svg')}}" class="size-7" alt="Editar icon">
                        </a>
                    @endcan
                    @can("eliminar jueces")
                        <form action="{{route('judges.destroy',$judge->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">
                                <img src="{{asset('svg/delete.svg')}}" class="size-7" alt="Borrar icon">
                            </button>
                        </form>
                    @endcan
                </div>
            </td>
        @endif
    </tr>
@endforeach
