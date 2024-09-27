@foreach($users as $user)
    <tr id="user_ids{{$user->id}}"
        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="w-4 p-4">
            <div class="flex items-center">
                <input name="ids" type="checkbox" value="{{$user->id}}"
                       class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox_ids" class="sr-only">checkbox</label>
            </div>
        </td>
        <td class="px-6 py-4">
            {{$user->name}}
        </td>
        <td class="px-6 py-4">
            {{$user->last_name}}
        </td>
        <td class="px-6 py-4">
            {{$user->email}}
        </td>
        <td class="px-6 py-4">
            @if(!$user->roles->isEmpty())
                <div class="flex flex-col items-start gap-2">
                    @foreach ($user->getRoleNames() as $role)
                        <span
                            class="inline-flex bg-zinc-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                            {{ ucfirst($role) }}
                                        </span>
                    @endforeach
                </div>
            @else
                <span
                    class="inline-flex bg-red-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                    No tiene roles
                                </span>
            @endif
        </td>
        <td class="px-6 py-4">
            <div class="flex items-center">
                @if($user->status)
                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                    Activo
                @else
                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                    Inactivo
                @endif
            </div>
        </td>
        @if(Auth::user()->can('editar usuarios') || Auth::user()->can('eliminar usuarios'))
            <td class="px-6 py-4">
                <div class="flex items-center">

                    <a href="{{route('users.edit',$user->id)}}"
                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                        <img src="{{asset('svg/edit.svg')}}" class="size-7" alt="Editar icon">
                    </a>
                    <form action="{{route('users.destroy',$user->id)}}" method="POST">
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
