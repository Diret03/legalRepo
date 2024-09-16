<x-app-layout>
{{--    <x-breadcrumbs/>--}}
    <div class="container mx-auto px-4 my-12 min-h-screen flex flex-col">
        {{ Breadcrumbs::render('trials', $subject) }}
        <div class="flex items-center flex-wrap mb-8">

            <x-go-back route="{{ route('subjects.list')}}" />
            <h2 class="text-4xl mr-2">Juicios de</h2>
            <h2 class="text-4xl font-extrabold underline underline-offset-3 decoration-8 decoration-blue-400">
                {{$subject->name}}
            </h2>
        </div>

        <div class="flex-grow">
            @foreach($trials as $trial)
                <div class="py-6 px-10 bg-white border border-gray-200 rounded-lg shadow mb-4">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{$trial->name}}</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700">{{$trial->description}}</p>
                    <a href="{{route('cases.showByTrial',$trial->id)}}"

                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stone-700 rounded-lg hover:bg-stone-400 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300">
                        Ver casos
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            @endforeach

            <div>
                {{ $trials->links('pagination::tailwind') }}
            </div>
        </div>

    </div>

</x-app-layout>
