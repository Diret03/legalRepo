<x-app-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($subjects as $subject)
            <div class="bg-white border border-gray-200 rounded-lg shadow">
                <a href="{{ route('trials.bySubject', $subject->id) }}">

                    <img class="rounded-t-lg w-full h-52 object-cover"
                         src="{{ $subject->image ? asset($subject->image) : asset('img/default.png') }}"
                         alt="Materia imagen"/>
                </a>
                <div class="p-5">
                    <a href="#">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                            {{ $subject->name }}
                        </h5>
                    </a>
                    <p class="mb-3 text-base text-gray-700">
                        {{ $subject->description }}
                    </p>

                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
