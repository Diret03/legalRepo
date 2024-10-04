@unless ($breadcrumbs->isEmpty())
    <nav class="container mx-auto my-4 mb-4">
        <ol class="flex flex-wrap items-center space-x-2  px-4 py-3 text-sm">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="flex items-center">
                    @if ($breadcrumb->url && !$loop->last)
                        <a href="{{ $breadcrumb->url }}" class="text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out">
                            {{ $breadcrumb->title }}
                        </a>
                    @else
                        <span class="text-gray-700 font-medium">
                            {{ $breadcrumb->title }}
                        </span>
                    @endif
                </li>

                @unless($loop->last)
                    <li class="text-gray-400">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                @endunless
            @endforeach
        </ol>
    </nav>
@endunless

