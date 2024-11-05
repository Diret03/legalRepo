<x-app-dash-layout title="Editar caso">
    <div class="flex md:flex-row">
        <x-sidebar />
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
                    <x-go-back route="{{ route('cases.mycases', Auth::id()) }}?status=pending" />
                </div>
                <div class="p-4 md:p-5">
                    <form id="edit-case-form" class="space-y-4" method="POST"
                        action="{{ route('cases.update', $case->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @can('editar cualquier caso')
                            <div>
                                <label for="user_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuario</label>
                                <select name="user_id" id="edit_user_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($user->id == $case->user->id) selected @endif>
                                            {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endcan
                        <div>
                            <label for="title"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
                            <input type="text" name="title" id="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Escribir nombre" required value="{{ old('title', $case->title) }}" />
                        </div>
                        @can('editar cualquier caso')
                            <div>
                                <label for="status"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                <select name="status" id="edit_status"
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
                                    <option value="{{ $subject->id }}"
                                        {{ $subject->id == $case->trial->subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="trial_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Juicio</label>
                            <select name="trial_id" id="trial_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-sm p-2.5">
                                {{-- @foreach ($trials as $trial)
                                    @if ($trial->id == $case->trial_id)
                                        <option value="{{ $trial->id }}" selected>

                                        </option>
                                    @endif
                                @endforeach --}}
                            </select>
                        </div>
                        <div>
                            <label for="tags"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Etiquetas</label>
                            <div id="tags-input"></div>
                            <input type="hidden" id="tags-hidden-input" name="tags">
                        </div>
                        <div class="mb-4 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                                data-tabs-toggle="#default-tab-content" role="tablist"
                                data-tabs-active-classes="text-red-650 border-red-650"
                                data-tabs-inactive-classes="text-gray-500 hover:text-gray-650 dark:text-gray-400 border-gray-100 hover:border-gray-300">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="context-tab"
                                        data-tabs-target="#context" type="button" role="tab"
                                        aria-controls="context" aria-selected="true">Contexto</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="analysis-tab" data-tabs-target="#analysis" type="button" role="tab"
                                        aria-controls="analysis" aria-selected="false">Problema Jurídico</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="resolution-tab" data-tabs-target="#resolution" type="button"
                                        role="tab" aria-controls="resolution"
                                        aria-selected="false">Respuesta</button>
                                </li>
                                <li role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="note-tab" data-tabs-target="#note" type="button" role="tab"
                                        aria-controls="note" aria-selected="false">Recomendaciones</button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-tab-content">
                            <div class="p-4 rounded-lg bg-gray-50" role="tabpanel" id="context"
                                aria-labelledby="context-tab">
                                <div>
                                    <textarea class="editor" name="context">{{ old('context', $case->context) }}</textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50" role="tabpanel" id="analysis"
                                aria-labelledby="analysis-tab">
                                <div>
                                    <textarea class="editor" name="analysis">{{ old('analysis', $case->analysis) }}</textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50" role="tabpanel" id="resolution"
                                aria-labelledby="resolution-tab">
                                <div>
                                    <textarea class="editor" name="resolution">{{ old('resolution', $case->resolution) }}</textarea>
                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="note"
                                role="tabpanel" aria-labelledby="note-tab">
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
    <script>
        $(document).ready(function() {
            let myData = [];
            let instance = null;
            let caseId = {{ $case->id }};

            // AJAX request to get tags
            $.ajax({
                url: '/cases/tags',
                method: 'GET',
                success: function(response) {
                    myData = response.tags;

                    // Initialize MagicSuggest only after data is received
                    instance = $('#tags-input').magicSuggest({
                        data: myData,
                        allowFreeEntries: true
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching tags:", error);
                }
            });

            $.ajax({
                url: '/cases/' + caseId + '/tags',
                method: 'GET',
                success: function(response) {
                    let caseTags = response.tags;
                    instance.setSelection(caseTags);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching case tags:", error);
                }
            });

            $("#edit-case-form").submit(function() {
                let tags = instance.getSelection(); // Get selected tags
                let tagNames = tags.map(tag => tag.name); // Extract the tag names

                // Set the hidden input value to the JSON string of selected tags
                $('#tags-hidden-input').val(JSON.stringify(tagNames));
            });
        });

        document.addEventListener('DOMContentLoaded', function() {

            let subjectSelect = document.getElementById("subject_id");
            let trialSelect = document.getElementById("trial_id");

            function changeTrialValues(trials, subject_id, first_time) {
                trialSelect.innerHTML = '';

                trials.forEach(trial => {
                    let option = document.createElement("option");
                    option.value = trial.id;
                    option.textContent = trial.name;

                    if (first_time === true && trial.id == {{ $case->trial->id }}) {
                        option.selected = true
                    }

                    trialSelect.appendChild(option);
                });
            }

            function fetchTrials(subject_id, first_time) {
                fetch('/dashboard/' + subject_id + '/juicios')
                    .then(response => response.json())
                    .then(data => {


                        changeTrialValues(data, subject_id, first_time);

                    })
                    .catch(error => console.error('Error:', error));
            }

            fetchTrials({{ $case->trial->subject->id }}, true);

            subjectSelect.addEventListener("change", function() {

                let subject_id = subjectSelect.value;

                fetchTrials(subject_id, false);
            });
        });
    </script>
</x-app-dash-layout>
