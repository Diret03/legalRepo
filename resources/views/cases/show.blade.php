<x-app-layout>

    <div class="container mx-auto px-4 my-12 min-h-screen flex flex-col">
        @if ($accessedBy === 'trial')
            {{ Breadcrumbs::render('caseByTrial', $case) }}
        @elseif ($accessedBy === 'tag')
            {{ Breadcrumbs::render('caseByTag', $case, $tag) }}
        @endif
            <div class="flex items-center flex-wrap mb-8 justify-between">
                <div class="flex items-center">
                    @if ($accessedBy === 'trial')
                        <x-go-back route="{{ route('cases.showByTrial',$case->trial->id) }}" />
                    @elseif ($accessedBy === 'tag')
                        <x-go-back route="{{ url()->previous() }}" />
                    @else
                        <x-go-back route="{{ url()->previous() }}" />
                    @endif
                    <h2 class="text-4xl font-extrabold ml-4">{{$case->title}}</h2>
                </div>

                <div class="flex items-center space-x-4">
                    @can('aprobar casos')
                        <form action="{{route('cases.approve',$case->id)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md focus:outline-none focus:ring-4 focus:ring-green-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                                Aprobar
                            </button>
                        </form>
                    @endcan
                    @can('rechazar casos')
                        <form action="{{route('cases.reject',$case->id)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="flex items-center px-4 py-2 bg-red-650 hover:bg-red-700 text-white rounded-md focus:outline-none focus:ring-4 focus:ring-red-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Rechazar
                            </button>
                        </form>
                    @endcan

                </div>
            </div>
        <div class="py-6 px-10 bg-white border border-gray-200 rounded-lg shadow mb-4">

            <div class="flex flex-col lg:flex-row">
                <div class="w-full lg:w-1/2">
                    <x-colon-text label="Número de caso" :value="$case->id"/>
                    <x-colon-text label="Fecha" :value="\Carbon\Carbon::parse($case->date)->format('d/m/Y')"/>
                    <x-colon-text label="Materia" :value="$case->trial->subject->name"/>
                    <x-colon-text label="Juicio" :value="$case->trial->name"/>
                </div>
                <div class="w-full lg:w-1/2">
                    <x-colon-text label="Origen" value="{{$case->origin}}"/>
                    <div class="mb-3 flex items-center">
                        <p class="text-gray-700 font-extrabold mr-3">Etiquetas:</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach ($case->tags as $tag)
                                <a  href="{{ route('cases.showByTag', $tag->id) }}"
                                    class="bg-red-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @can('aprobar casos')
                        <x-colon-text label="Estado" :value="$case->status"/>
                    @endcan
                </div>
            </div>


            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist"
                    data-tabs-active-classes="text-red-650 border-red-650"
                    data-tabs-inactive-classes="text-gray-500 hover:text-gray-650 dark:text-gray-400 border-gray-100 hover:border-gray-300">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="context-tab" data-tabs-target="#context" type="button" role="tab" aria-controls="context" aria-selected="false">Contexto</button>
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

</x-app-layout>

<script src="{{asset('js/renderTiny.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        applyTailwindStyles('default-tab-content');

    });

</script>
