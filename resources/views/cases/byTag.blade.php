<x-app-layout>

    <div class="container mx-auto px-4 my-12 min-h-screen flex flex-col">
{{--        @php--}}
{{--            dd($tag->name);--}}
{{--        @endphp--}}
        {{ Breadcrumbs::render('casesByTagDef', $tag) }}
        <div class="flex items-center flex-wrap mb-8">
            <x-go-back route="{{ route('tags.list')}}" />
            <h2 class="text-4xl mr-2">Casos de etiqueta:</h2>
            <h2 class="text-4xl font-extrabold underline underline-offset-3 decoration-8 decoration-blue-400">
                {{$tag_name}}
            </h2>
        </div>

        <div class="flex-grow">
            @if(count($cases)== 0)
                <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        No hay casos registrados.
                    </div>
                </div>
            @else
                @foreach($cases as $case)
                    <div class="py-6 px-10 bg-white border border-gray-200 rounded-lg shadow mb-4">

{{--                        @php--}}
{{--                            dd($tag->name);--}}
{{--                        @endphp--}}
                        <a href="{{route('tag.cases.show', ['id' => $case->id, 'tag' => $tag])}}">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 underline">{{$case->title}}</h5>
                        </a>
                        <div class="mb-1 flex items-center">
                            <p class="text-gray-700 font-extrabold">Caso:</p>
                            <p class="font-normal text-gray-700">{{$case->id}}</p>
                        </div>
                        <div class="mb-1 flex items-center">
                            <p class="text-gray-700 font-extrabold">Fecha:</p>
                            <p class="font-normal text-gray-700">{{\Carbon\Carbon::parse($case->date)->format('d/m/Y')}}</p>
                        </div>
                        <div class="mb-3 flex items-center">
                            <p class="text-gray-700 font-extrabold">Materia:</p>
                            <p class="font-normal text-gray-700">{{$case->trial->subject->name}}</p>
                        </div>

                        <a href="{{route('tag.cases.show', ['id' => $case->id, 'tag' => $tag])}}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stone-700 rounded-lg hover:bg-stone-400 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Ver más
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
                <div class="pb-10">
                    {{ $cases->links('pagination::tailwind') }}
                </div>
            @endif
        </div>

    </div>


</x-app-layout>
