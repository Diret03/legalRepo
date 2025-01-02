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
        <td class="px-6 py-4">
            @if(empty($user->last_login_at))
                <span
                    class="inline-flex bg-red-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                    Aún no ha iniciado sesión
                </span>
            @else
                {{$user->last_login_at}}
            @endif
        </td>
        @if(Auth::user()->can('editar usuarios') || Auth::user()->can('eliminar usuarios'))
            <td class="px-6 py-4">
                <div class="flex items-center">
                    @can('editar usuarios')
                        <a href="#" data-modal-target="edit-modal-{{$user->id}}" data-modal-toggle="edit-modal-{{$user->id}}"
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                            <img src="{{asset('svg/edit.svg')}}" class="w-7 h-7" alt="Editar icon">
                        </a>
                        <!-- Edit user modal -->
                        <div id="edit-modal-{{$user->id}}" tabindex="-1" aria-hidden="true"
                             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Editar usuario
                                        </h3>
                                        <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-hide="edit-modal-{{$user->id}}">
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
                                        <form id="edit-user-form" class="space-y-4" method="POST"
                                              action="{{ route('users.update', $user->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                @if(Auth::id() === $user->id)
                                                    <label for="edit-name"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                                    <input type="text" name="name" id="edit-name"
                                                           value="{{ $user->name }}"
                                                           class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"/>
                                                @else
                                                    <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        Nombre</p>
                                                    <p class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{$user->name}}</p>
                                                @endif
                                            </div>
                                            <div>
                                                @if(Auth::id() === $user->id)
                                                    <label for="edit-last_name"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellido</label>
                                                    <input type="text" name="last_name" id="edit-last_name"
                                                           value="{{ $user->last_name }}"
                                                           class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"/>
                                                @else
                                                    <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        Apellido</p>
                                                    <p class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{$user->last_name}}</p>
                                                @endif
                                            </div>
                                            <div>
                                                @if(Auth::id() === $user->id)
                                                    <label for="edit-email"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo
                                                        electrónico</label>
                                                    <input type="email" name="email" id="edit-email"
                                                           value="{{ $user->email }}"
                                                           class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"/>
                                                @else
                                                    <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        Correo
                                                        electrónico</p>
                                                    <p class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{$user->email}}</p>
                                                @endif
                                            </div>

                                            <div>
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900">Roles</label>
                                                @foreach($roles as $role)
                                                    <div class="flex items-center mb-4">
                                                        <input
                                                            id="role_{{$role}}"
                                                            type="checkbox"
                                                            value="{{$role}}"
                                                            name="roles[]"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                                            @if(in_array($role, $user->getRoleNames()->toArray()))
                                                                checked
                                                            @endif
                                                        >
                                                        <label for="role_{{$role}}"
                                                               class="ms-2 text-sm font-medium text-gray-900">
                                                            {{ucfirst($role)}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div>
                                                <label for="status"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                                <select name="status" id="edit_status"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                    @if($user->status)
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    @else
                                                        <option value="1">Activo</option>
                                                        <option value="0" selected>Inactivo</option>
                                                    @endif
                                                </select>
                                            </div>
                                            @if(Auth::id()===$user->id)
                                                <div class="my-2">
                                                    <label for="edit_password"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                                                    <input type="password" name="password" id="edit_password"
                                                           placeholder="••••••••"
                                                           class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"/>
                                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Dejar en
                                                        blanco para mantener
                                                        la
                                                        contraseña actual</p>
                                                </div>
                                            @endif
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
                    @can('eliminar usuarios')
                        <form action="{{route('users.destroy',$user->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">
                                <img src="{{asset('svg/delete.svg')}}" class="w-7 h-7" alt="Borrar icon">
                            </button>
                        </form>
                    @endcan
                </div>
            </td>
        @endif
    </tr>
@endforeach
