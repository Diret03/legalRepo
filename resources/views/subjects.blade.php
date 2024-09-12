<x-app-layout>
    <div class="container mx-auto px-4 my-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            {{--            @for ($i = 0; $i < 6; $i++)--}}
            {{--                <div class="bg-white border border-gray-200 rounded-lg shadow">--}}
            {{--                    <a href="#">--}}
            {{--                        <img class="rounded-t-lg w-full h-48 object-cover" src="{{asset('img/derecho.jpg')}}" alt="placeholder" />--}}
            {{--                    </a>--}}
            {{--                    <div class="p-5">--}}
            {{--                        <a href="#">--}}
            {{--                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Noteworthy technology acquisitions 2021</h5>--}}
            {{--                        </a>--}}
            {{--                        <p class="mb-3 text-sm text-gray-700">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>--}}

            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            @endfor--}}

            @foreach($subjects as $subject)

                <div class="bg-white border border-gray-200 rounded-lg shadow">
                    <a href="{{route('subjects.show',$subject->id)}}">
                        <img class="rounded-t-lg w-full h-48 object-cover" src="{{asset('img/derecho.jpg')}}"
                             alt="placeholder"/>
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                {{$subject->name}}
                            </h5>
                        </a>
                        <p class="mb-3 text-sm text-gray-700">
                            {{$subject->description}}
                        </p>

                    </div>
                </div>

            @endforeach
        </div>
    </div>
</x-app-layout>
