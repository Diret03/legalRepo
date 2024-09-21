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
            <div class="max-w-full mx-auto bg-white rounded-lg shadow-md dark:bg-gray-800 p-5">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-3xl font-semibold text-gray-900 dark:text-white">
                        Editar caso
                    </h3>
                    <x-go-back route="{{ route('cases.index') }}" />
                </div>
                <div class="p-4 md:p-5">
                    <form id="edit-case-form" class="space-y-4" method="POST" action="{{ route('cases.update', $case->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                            <input type="text" name="title" id="title"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                   placeholder="Escribir nombre" required value="{{ old('title', $case->title) }}"/>
                        </div>
                        <div>
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                            <input type="date" name="date" id="date"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5"
                                   value="{{ old('date', $case->date) }}"/>
                        </div>
                        <div>
                            <label for="origin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Origen</label>
                            <input type="text" name="origin" id="origin"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                   placeholder="Escribir origen" required value="{{ old('origin', $case->origin) }}"/>
                        </div>
                        <!-- Trial Dropdown -->
                        <div>
                            <label for="trial_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Juicio</label>
                            <select name="trial_id" id="trial_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5">
                                @foreach($trials as $trial)
                                    <option value="{{ $trial->id }}" {{ $trial->id == $case->trial_id ? 'selected' : '' }}>{{ $trial->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist"
                                data-tabs-active-classes="text-red-650 border-red-650"
                                data-tabs-inactive-classes="text-gray-500 hover:text-gray-650 dark:text-gray-400 border-gray-100 hover:border-gray-300">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="context-tab" data-tabs-target="#context" type="button" role="tab" aria-controls="context" aria-selected="true">Contexto</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="analysis-tab" data-tabs-target="#analysis" type="button" role="tab" aria-controls="analysis" aria-selected="false">Análisis Jurídico</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="resolution-tab" data-tabs-target="#resolution" type="button" role="tab" aria-controls="resolution" aria-selected="false">Resolución</button>
                                </li>
                                <li role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="note-tab" data-tabs-target="#note" type="button" role="tab" aria-controls="note" aria-selected="false">Nota</button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-tab-content">
                            <div class="p-4 rounded-lg bg-gray-50" role="tabpanel" id="context" aria-labelledby="context-tab">
                                <div>
                                    <textarea class="editor" name="context">{{ old('context', $case->context) }}</textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50" role="tabpanel" id="analysis" aria-labelledby="analysis-tab">
                                <div>
                                    <textarea class="editor" name="analysis">{{ old('analysis', $case->analysis) }}</textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50" role="tabpanel" id="resolution" aria-labelledby="resolution-tab">
                                <div>
                                    <textarea class="editor" name="resolution">{{ old('resolution', $case->resolution) }}</textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="note" role="tabpanel" aria-labelledby="note-tab">
                                <div>
                                    <textarea class="editor" name="note">{{ old('note', $case->note) }}</textarea>
                                </div>
                            </div>
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
