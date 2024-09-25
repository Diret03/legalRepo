<x-app-layout>

    <div class="flex">
        <x-sidebar/>
        <!-- Main Content -->
        <div class="flex-1 m-10 relative">
            <div class="flex items-center flex-wrap mb-8">
                <h2 class="text-4xl mr-2 font-extrabold">Revisión de casos</h2>
            </div>
            <div class="flex items-center flex-wrap -mx-2 mb-4">
                <a id="pending-link" type="button" href="{{route('cases.review')}}?status=pending"
                   class="flex items-center px-4 py-1 focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm mx-1 mb-2">
                    <img src="{{asset('svg/pending.svg')}}" class="h-8 w-8 mr-2 invert" alt="Pendiente icon">
                    Pendientes
                </a>
                <a id="accepted-link" type="button" href="{{route('cases.review')}}?status=accepted"
                   class="flex items-center px-4 py-2 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm mx-1 mb-2">
                    <img src="{{asset('svg/approved.svg')}}" class="h-6 w-6 mr-2 invert" alt="Aceptado icon">
                    Aceptados
                </a>
                <a id="rejected-link" type="button" href="{{route('cases.review')}}?status=rejected"
                   class="flex items-center px-4 py-2 focus:outline-none text-white bg-red-650 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm mx-1 mb-2">
                    <img src="{{asset('svg/rejected.svg')}}" class="h-6 w-6 mr-2 invert" alt="Rechazado icon">
                    Rechazados
                </a>
                <a type="button" href="{{route('cases.review')}}?status=all"
                   class="px-4 py-2 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm mx-1 mb-2">
                    Todos
                </a>
            </div>


            <div class="flex-grow">
                @if($cases->count() == 0)
                    <div
                        class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            No hay casos existentes.
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                        @foreach($cases as $case)
                            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col justify-between">

                                <!-- Case Information -->
                                <div>
                                    <div class="flex justify-between items-center mb">
                                        <div class="flex items-center">
                                            <img
                                                @if($case->status == 'Aceptado')
                                                    src="{{asset('svg/case-accepted.svg')}}"
                                                @elseif($case->status == 'Pendiente')
                                                    src="{{asset('svg/case-pending.svg')}}"
                                                @elseif($case->status == 'Rechazado')
                                                    src="{{asset('svg/case-rejected.svg')}}"
                                                @endif
                                                class="size-12" alt="Estado icon">
                                        </div>
                                        <div>
                                            <div class="mb-0 flex items-center">
                                                <p class="text-gray-700 font-extrabold">Caso:</p>
                                                <p class="font-normal text-gray-700 ml-1">{{$case->id}}</p>
                                            </div>
                                            <div class="mb-0 flex items-center">
                                                <p class="text-gray-700 font-extrabold">Subido por:</p>
                                                <p class="font-normal text-gray-700 ml-1">{{$case->user->name}} {{$case->user->last_name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <a href="#" class="mb-2">
                                            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                                {{$case->title}}</h5>
                                        </a>
                                        <div class="flex items-center">
                                            <p class="text-gray-700 font-extrabold">Materia:</p>
                                            <p class="font-normal text-gray-700 ml-1">{{$case->trial->subject->name}}</p>
                                        </div>
                                        <div class="flex items-center">
                                            <p class="text-gray-700 font-extrabold">Juicio:</p>
                                            <p class="font-normal text-gray-700 ml-1">{{$case->trial->name}}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Button aligned at the bottom -->
                                <div>
                                    <a href="{{route('cases.show',$case->id)}}"
                                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stone-700 rounded-lg hover:bg-stone-400 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        Ver más
                                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pb-10">
                        {{ $cases->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        // document.addEventListener("DOMContentLoaded", (event) => {
        //     let pending = true
        //
        //     $('pending-link').on('click', function (){
        //
        //
        //
        //     });
        // });
    </script>
</x-app-layout>
