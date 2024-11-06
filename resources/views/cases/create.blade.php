<x-app-dash-layout title="Subir caso">
    <div class="flex md:flex-row">
        <x-sidebar/>
        <div class="flex-1 p-4 md:p-10">
            <x-success-error-alert/>
            <div class="max-w-full mx-auto bg-white rounded-lg shadow-md dark:bg-gray-800 p-5">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-3xl font-semibold text-gray-900 dark:text-white">
                        Crear caso
                    </h3>
                    <x-go-back route="{{ route('cases.mycases', Auth::id()) }}"/>
                </div>
                <div class="p-4 md:p-5">
                    <form id="case-form" class="space-y-4" method="POST" action="{{ route('cases.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        @can('editar cualquier caso')
                            <div>
                                <label for="user_id"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuario</label>
                                <select name="user_id" id="user_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endcan
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                            <input type="text" name="title" id="title"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                   placeholder="Escribir nombre" required value="{{ old('title') }}"/>
                        </div>
                        @can('editar cualquier caso')
                            <div>
                                <label for="status"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                <select name="status" id="status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5">

                                    <option value="accepted">Aceptado</option>
                                    <option value="pending">Pendiente</option>
                                    <option value="rejected">Rechazado</option>
                                </select>
                            </div>
                        @endcan
                        <div>
                            <label for="subject_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Materia</label>
                            <select name="subject_id" id="subject_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5">
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="trial_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Juicio</label>
                            <select name="trial_id" id="trial_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5">
                                @foreach ($trials as $trial)
                                    <option value="{{ $trial->id }}">{{ $trial->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <span id="tags-error" class="text-sm text-red-600 hidden mb-4"></span>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <img src="{{ asset('svg/tags.svg') }}" class="size-5 mr-1" alt="Tags icon">
                                    <h4 class="font-medium">Etiquetas</h4>
                                </div>
                            </div>
                            <div id="tagsContainer" class="space-y-2">
                                <select id="select-tags" name="tags[]" multiple autocomplete="off">
                                    @foreach($tags as $tag)
                                        <option value="{{$tag->name}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                                data-tabs-toggle="#default-tab-content" role="tablist"
                                data-tabs-active-classes="text-red-650 border-red-650"
                                data-tabs-inactive-classes="text-gray-500 hover:text-gray-650 dark:text-gray-400 border-gray-100 hover:border-gray-300">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="context-tab"
                                            data-tabs-target="#context" type="button" role="tab"
                                            aria-controls="context" aria-selected="false">Contexto
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="analysis-tab" data-tabs-target="#analysis" type="button" role="tab"
                                        aria-controls="analysis" aria-selected="false">Problema Jurídico
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="resolution-tab" data-tabs-target="#resolution" type="button" role="tab"
                                        aria-controls="resolution" aria-selected="false">Respuesta
                                    </button>
                                </li>
                                <li role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="note-tab" data-tabs-target="#note" type="button" role="tab"
                                        aria-controls="note" aria-selected="false">Recomendaciones
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-tab-content">
                            <div class="hidden p-4 rounded-lg bg-gray-50" role="tabpanel" id="context"
                                 aria-labelledby="context-tab">
                                <div>
                                    <textarea class="editor" name="context"></textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50" role="tabpanel" id="analysis"
                                 aria-labelledby="analysis-tab">
                                <div>
                                    <textarea class="editor" name="analysis" id="analysis"></textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50" role="tabpanel" id="resolution"
                                 aria-labelledby="resolution-tab">
                                <div>
                                    <textarea class="editor" name="resolution" id="resolution"></textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="note"
                                 role="tabpanel" aria-labelledby="note-tab">
                                <div>
                                    <textarea class="editor" name="note" id="note"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit"
                                    class="w-1/3 h-16 text-white bg-red-650 hover:bg-red-200 hover:border-solid hover:border-2 hover:border-black hover:text-black focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                Subir caso
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="module">
        const tagErrorMessage = document.getElementById('tags-error');

        var settings = {
            plugins: {
                'clear_button': {
                    title: 'Eliminar todas las etiquetas',
                },
                remove_button: {
                    title: 'Eliminar este elemento',
                }
            },
            sortField: {
                field: "text",
                direction: "asc"
            },
            searchField: 'text',
            createOnBlur: true,
            persist: false,
            placeholder: "Escribir una o más etiquetas",
            create: function (input) {

                if (input.length < 3) {
                    tagErrorMessage.classList.remove('hidden');
                    tagErrorMessage.textContent = 'Las etiquetas deben tener al menos 3 caracteres.';
                    return false; // Prevent the tag from being created
                }

                if (input.length >= 50) {
                    tagErrorMessage.classList.remove('hidden');
                    tagErrorMessage.textContent = 'Las etiquetas no deben superar los 50 caracteres.';
                    return false; // Prevent the tag from being created
                }

                tagErrorMessage.classList.add('hidden');
                return {value: input, text: input}; // Create the tag
            },
            onItemAdd: function (value, item) {

                if (this.items.length > 5) {
                    tagErrorMessage.classList.remove('hidden');
                    tagErrorMessage.textContent = 'Máximo 5 etiquetas';
                    this.removeItem(value); // reemove the last added item if it exceeds maxItems
                } else {
                    tagErrorMessage.classList.add('hidden');
                }
            },
            onItemRemove: function (value, item){
                if (tagSelector.items.length < 5) {
                    tagErrorMessage.classList.add('hidden');
                }
            },
            render: {
                option_create: function (data, escape) {
                    return '<div class="create">Agregar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                },
                no_results: function (data, escape) {
                    return '<div class="no-results">No se han encontrado resultados</div>';
                },
            },
            shouldLoad: function (query) {
                //each tag  must have at least 3 characters
                return query.length >= 3
            }

        };
        let tagSelector = new TomSelect('#select-tags', settings);


    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            let subjectSelect = document.getElementById("subject_id");
            let trialSelect = document.getElementById("trial_id");

            function changeTrialValues(trials) {
                trialSelect.innerHTML = '';

                trials.forEach(trial => {
                    let option = document.createElement("option");
                    option.value = trial.id;
                    option.textContent = trial.name;
                    trialSelect.appendChild(option);
                });
            }

            function fetchTrials() {
                fetch('/dashboard/' + subjectSelect.value + '/juicios')
                    .then(response => response.json())
                    .then(data => {
                        // console.log(data);
                        changeTrialValues(data);

                    })
                    .catch(error => console.error('Error:', error));
            }

            fetchTrials()

            subjectSelect.addEventListener("change", function () {
                fetchTrials();
            });
        });
    </script>

</x-app-dash-layout>
