@props(['href', 'icon', 'title', 'activeRoute'])

<a href="{{ $href }}"
   class="flex items-center w-full p-3 leading-tight transition-all rounded-lg outline-none text-start
   {{ Route::is($activeRoute) ? 'bg-zinc-100 bg-opacity-80 text-black' : '' }} hover:bg-zinc-100 hover:bg-opacity-80 hover:text-black focus:bg-opacity-80 focus:text-blue-gray-900">
    <img src="{{ asset($icon) }}" class="size-5 mr-4" alt="{{ $title }} icon" style="filter: brightness(0) invert(1);">
    <p class="title-nav transition-opacity duration-300 ease-in-out">{{ $title }}</p>
</a>
