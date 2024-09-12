<x-app-layout>

    <div class="container mx-auto px-4 my-12 min-h-screen flex flex-col">

        <h2 class="text-4xl font-extrabold  mb-8">{{$case->title}}</h2>

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
                    <x-colon-text label="Etiquetas" value="aux"/>
                </div>
            </div>



{{--            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200">--}}
{{--                <ul class="flex flex-wrap -mb-px">--}}
{{--                    <li class="me-2">--}}
{{--                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-red-650 hover:border-red-300">Profile</a>--}}
{{--                    </li>--}}
{{--                    <li class="me-2">--}}
{{--                        <a href="#" class="inline-block p-4 text-red-650 border-b-2 border-red-650 rounded-t-lg active" aria-current="page">Dashboard</a>--}}
{{--                    </li>--}}
{{--                    <li class="me-2">--}}
{{--                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-red-650 hover:border-red-300">Settings</a>--}}
{{--                    </li>--}}
{{--                    <li class="me-2">--}}
{{--                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-red-650 hover:border-red-300">Contacts</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}

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
                <div class="hidden p-4 rounded-lg bg-gray-50" id="context" role="tabpanel" aria-labelledby="context-tab">
                    <p class="text-sm text-gray-500 ">{{$case->context}}</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50" id="analysis" role="tabpanel" aria-labelledby="analysis-tab">
                    <p class="text-sm text-gray-500 ">{{$case->analysis}}</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50" id="resolution" role="tabpanel" aria-labelledby="resolution-tab">
                    <p class="text-sm text-gray-500">{{$case->resolution}}</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="note" role="tabpanel" aria-labelledby="note-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{$case->note}}</p>
                </div>
            </div>



        </div>


    </div>

</x-app-layout>
