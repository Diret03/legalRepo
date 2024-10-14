<x-app-layout>
    {{--        {{ Breadcrumbs::render('tags') }} --}}
    <div class="flex items-center flex-wrap mb-8">
        {{--            <x-go-back/> --}}
        <h2 class="text-4xl font-extrabold">Etiquetas</h2>
    </div>
    <div class="py-6 px-4 sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow mb-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
            @foreach ($paginatedTags as $letter => $groupedTags)
                <div class="mb-6">
                    <h3 class="text-2xl font-bold mb-2">{{ $letter }}</h3>
                    <hr class="mb-4">
                    <div class="space-y-2">
                        @foreach ($groupedTags as $tag)
                            <a href="{{ route('cases.showByTag', $tag->id) }}"
                               class="block bg-gray-100 rounded-lg p-3 text-lg hover:bg-gray-200 transition-colors duration-200">
                                {{ ucfirst($tag->name) }} ({{ $tag->accepted_cases_count }})
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4 pb-10">
        {{ $paginatedTags->links() }}
    </div>
</x-app-layout>
