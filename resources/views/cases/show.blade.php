<x-app-layout title="Caso {{$case->title}}">
    @if ($accessedBy === 'trial')
        {{ Breadcrumbs::render('caseByTrial', $case) }}
    @elseif ($accessedBy === 'tag')
        {{ Breadcrumbs::render('caseByTag', $case, $tagId) }}
    @endif


    <div class="flex flex-col space-y-4 md:space-y-6 mb-8">
        <div class="flex items-center flex-wrap">
            @if ($accessedBy === 'trial')
                <x-go-back route="{{ route('cases.showByTrial',$case->trial->id) }}"/>
            @elseif ($accessedBy === 'tag')
                <x-go-back route="{{ url()->previous() }}"/>
            @else
                <x-go-back route="{{ url()->previous() }}"/>
            @endif
            <h2 class="text-2xl md:text-4xl font-extrabold ml-4 break-words">{{$case->title}}</h2>
        </div>

        <div class="flex flex-wrap gap-2">

            @if(Auth::check() && (Auth::user()->can('aprobar casos') && $case->status != 'Aceptado'))
                <form action="{{route('cases.approve',$case->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-md focus:outline-none focus:ring-4 focus:ring-green-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        Aprobar
                    </button>
                </form>
            @endif
            @if(Auth::check() && (Auth::user()->can('rechazar casos') && $case->status != 'Rechazado'))
                <button type="button" data-modal-target="rejection-modal" data-modal-toggle="rejection-modal"
                        class="flex items-center px-3 py-1.5 bg-red-650 hover:bg-red-700 text-white rounded-md focus:outline-none focus:ring-4 focus:ring-red-300 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Rechazar
                </button>
            @endif
            <a href="{{route('cases.pdf',$case->id)}}"
               class="flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-md text-sm px-3 py-1.5">
                <img src="{{asset('svg/download-pdf.svg')}}" class="h-5 w-5 mr-1" alt="Descargar icon">
                Descargar
            </a>
            @if(Auth::check() && ((Auth::user()->can('editar cualquier caso') || (Auth::user()->can('editar casos propios') && Auth::user()->id === $case->user->id)) && $case->status != 'Aceptado'))
                <a href="{{route('cases.edit',$case->id)}}"
                   class="flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-md text-sm px-3 py-1.5">
                    <img src="{{asset('svg/edit.svg')}}" class="h-5 w-5 mr-1" alt="Editar icon">
                    Editar caso
                </a>
            @endif
            @if(Auth::check() && (Auth::user()->can('eliminar casos propios') && $case->user_id == Auth::id()))
                <form action="{{route('cases.destroy',$case->id)}}?from=show" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-md text-sm px-3 py-1.5">
                        <img src="{{asset('svg/delete.svg')}}" class="h-5 w-5 mr-1" alt="Eliminar icon">
                        Eliminar caso
                    </button>
                </form>
            @endif

        </div>
    </div>

    @if (Auth::check() && $case->status == 'Rechazado')
        <div id="alert-case-rejected"
             class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
             role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>

            @if(Auth::user()->id === $case->user->id)
                <div class="ms-3 text-sm font-medium">
                    Tu caso fue rechazado, puedes editarlo para que sea revisado de nuevo.
                </div>
            @else
                <div class="ms-3 text-sm font-medium">
                    Este caso fue rechazado.
                </div>
            @endif
            <button type="button" data-modal-target="see-rejection-modal" data-modal-toggle="see-rejection-modal"
                    class="font-semibold underline hover:no-underline ml-1">Motivo
            </button>
            <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-case-rejected" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if (Auth::check() && !$case->user->status)
        <div id="alert-inactive-user"
             class="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
             role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                 viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                El usuario que subió este caso está inactivo por lo que su caso no será visible para todos.
            </div>
            <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-inactive-user" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif


    <div class="py-6 px-10 bg-white border border-gray-200 rounded-lg shadow mb-4">

        <div class="flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2">
                <x-colon-text label="Número de caso" :value="$case->id"/>
                <x-colon-text label="Materia" :value="$case->trial->subject->name"/>
                <x-colon-text label="Juicio" :value="$case->trial->name"/>
            </div>
            <div class="w-full lg:w-1/2">
                <div class="mb-3 flex items-center">
                    <p class="text-gray-700 font-extrabold mr-3">Etiquetas:</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach ($case->tags as $tag)
                            <a href="{{ route('cases.showByTag', $tag->id) }}"
                               class="bg-red-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @if (Auth::check())
                    @can('revisar casos')
                        <x-colon-text label="Estado" :value="$case->status"/>
                        @if($case->user->status)
                            <x-colon-text label="Subido por" :value="$case->user->name.' '.$case->user->last_name"/>
                        @else
                            <x-colon-text label="Subido por"
                                          :value="$case->user->name.' '.$case->user->last_name. ' (Inactivo)'"/>
                        @endif
                    @endcan
                @endif
            </div>
        </div>


        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist"
                data-tabs-active-classes="text-red-650 border-red-650"
                data-tabs-inactive-classes="text-gray-500 hover:text-gray-650 dark:text-gray-400 border-gray-100 hover:border-gray-300">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="context-tab"
                            data-tabs-target="#context" type="button" role="tab" aria-controls="context"
                            aria-selected="false">Contexto
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
                        id="note-tab" data-tabs-target="#note" type="button" role="tab" aria-controls="note"
                        aria-selected="false">Recomendaciones
                    </button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden" id="context" role="tabpanel" aria-labelledby="context-tab">
                <textarea class="editor-display" name="context">{{$case->context}}</textarea>
            </div>
            <div class="hidden" id="analysis" role="tabpanel" aria-labelledby="analysis-tab">
                <textarea class="editor-display" name="context">{{$case->analysis}}</textarea>
            </div>
            <div class="hidden" id="resolution" role="tabpanel" aria-labelledby="resolution-tab">
                <textarea class="editor-display" name="context">{{$case->resolution}}</textarea>
            </div>
            <div class="hidden" id="note" role="tabpanel" aria-labelledby="note-tab">
                <textarea class="editor-display" name="context">{{$case->note}}</textarea>
            </div>
        </div>
    </div>
    </div>

    @if(Auth::check())
        <!-- to Reject modal -->
        <div id="rejection-modal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Rechazar caso
                        </h3>
                        <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="rejection-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" action="{{ route('cases.reject', $case->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label for="rejection_message"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Explica por
                                    qué
                                    rechazas este caso</label>
                                <textarea name="rejection_message" id="rejection_message" rows="10"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                          required>{{ old('rejection_message') }}</textarea>
                            </div>
                            <button type="submit"
                                    class="w-full text-white bg-red-650 hover:bg-red-300 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Rechazar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- to Reject modal -->
        <div id="see-rejection-modal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Motivo de rechazo
                        </h3>
                        <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="see-rejection-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="pb-5">
                            <label for="rejection_message"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                @if(Auth::check())
                                    @if(Auth::user()->id === $case->user->id)
                                        Tu
                                    @else
                                        Este
                                    @endif

                                @endif
                                caso fue rechazado debido al siguiente motivo:
                            </label>
                            <textarea name="rejection_message" id="rejection_message" rows="10"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                      readonly>{{$case->rejection_message}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
    @endif

</x-app-layout>

<script src="{{asset('js/renderTiny.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        applyTailwindStyles('default-tab-content');

    });
</script>
