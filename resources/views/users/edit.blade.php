<x-app-layout>
    <div class="flex md:flex-row">
        <x-sidebar/>
        <div class="flex-1 p-4 md:p-10">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="mb-1">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Editar usuario
                    </h3>
                    <x-go-back route="{{ route('users.index') }}"/>
                </div>
                <div class="p-4 md:p-5">
                    <form id="edit-user-form" class="space-y-4" method="POST"
                          action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            @if(Auth::id() === $user->id)
                                <label for="edit-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                <input type="text" name="name" id="edit-name" value="{{ $user->name }}"
                                       class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"/>
                            @else
                                <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</p>
                                <p class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{$user->name}}</p>
                            @endif
                        </div>
                        <div>
                            @if(Auth::id() === $user->id)
                                <label for="edit-last_name"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellido</label>
                                <input type="text" name="last_name" id="edit-last_name" value="{{ $user->last_name }}"
                                       class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"/>
                            @else
                                <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellido</p>
                                <p class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{$user->last_name}}</p>
                            @endif
                        </div>
                        <div>
                            @if(Auth::id() === $user->id)
                                <label for="edit-email"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo
                                    electrónico</label>
                                <input type="email" name="email" id="edit-email" value="{{ $user->email }}"
                                       class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"/>
                            @else
                                <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo
                                    electrónico</p>
                                <p class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{$user->email}}</p>
                             @endif
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Roles</label>
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
                                    <label for="role_{{$role}}" class="ms-2 text-sm font-medium text-gray-900">
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
                                <input type="password" name="password" id="edit_password" placeholder="••••••••"
                                       class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"/>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Dejar en blanco para mantener
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
</x-app-layout>
