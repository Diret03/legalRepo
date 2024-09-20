<x-app-layout>
    <div class="flex flex-col md:flex-row">
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
            <div class="max-w-full mx-auto bg-white rounded-lg shadow-md dark:bg-gray-800 p-5">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-3xl font-semibold text-gray-900 dark:text-white">
                        Crear caso
                    </h3>
                    <x-go-back route="{{ route('cases.index') }}" />
                </div>
                <div class="p-4 md:p-5">
                    <form id="edit-user-form" class="space-y-4" method="POST" action="{{ route('cases.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <!-- Title Field -->
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                            <input type="text" name="title" id="title"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                   placeholder="Escribir nombre" required value="{{ old('title') }}"/>
                        </div>
                        <div>
                            <label for="date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                            <input type="date" name="date" id="date"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5"
                                   value="{{ old('date') }}"/>
                        </div>
                        <div>
                            <label for="origin"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Origen</label>
                            <input type="text" name="origin" id="origin"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                   placeholder="Escribir origen" required value="{{ old('origin') }}"/>
                        </div>
                        <!-- Trial Dropdown -->
                        <div>
                            <label for="trial_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Juicio</label>
                            <select name="trial_id" id="trial_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5">
                                @foreach($trials as $trial)
                                    <option value="{{ $trial->id }}">{{ $trial->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit"
                                    class="w-1/3 h-16 text-white bg-red-650 hover:bg-red-200 hover:border-solid hover:border-2 hover:border-black hover:text-black focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                Guardar cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
