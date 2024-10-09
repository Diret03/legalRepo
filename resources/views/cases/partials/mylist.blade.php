@foreach ($cases as $case)
    <div
        class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-between transform transition-transform duration-300 hover:translate-x-2 hover:-translate-y-2 hover:shadow-lg"">

        <!-- Case Information -->
        <div>
            <div class="flex justify-between items-center mb">
                <div class="flex items-center">
                    <img @if ($case->status == 'Aceptado') src="{{ asset('svg/case-accepted.svg') }}"
                        @elseif($case->status == 'Pendiente')
                            src="{{ asset('svg/case-pending.svg') }}"
                        @elseif($case->status == 'Rechazado')
                            src="{{ asset('svg/case-rejected.svg') }}" @endif
                        class="size-12" alt="Estado icon">
                </div>
                <div>
                    <div class="mb-0 flex items-center">
                        <p class="text-gray-700 font-extrabold">Caso:</p>
                        <p class="font-normal text-gray-700 ml-1">{{ $case->id }}</p>
                    </div>
                    <div class="mb-0 flex items-center">
                        <p class="text-gray-700 font-extrabold">Fecha:</p>
                        <p class="font-normal text-gray-700 ml-1">
                            {{ \Carbon\Carbon::parse($case->date)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <a href="#" class="mb-2">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                        {{ $case->title }}</h5>
                </a>
                <div class="flex items-center">
                    <p class="text-gray-700 font-extrabold">Materia:</p>
                    <p class="font-normal text-gray-700 ml-1">{{ $case->trial->subject->name }}</p>
                </div>
                <div class="flex items-center">
                    <p class="text-gray-700 font-extrabold">Juicio:</p>
                    <p class="font-normal text-gray-700 ml-1">{{ $case->trial->name }}</p>
                </div>
            </div>
        </div>

        <!-- Button aligned at the bottom -->
        <div>
            <a href="{{ route('cases.show', $case->id) }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stone-700 rounded-lg hover:bg-stone-400 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300">
                Ver más
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
    </div>
@endforeach
