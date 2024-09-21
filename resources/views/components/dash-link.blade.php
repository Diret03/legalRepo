@props(['href', 'icon', 'title', 'activeRoutes' => []])

<a href="{{ $href }}"
   class="group flex items-center w-full p-3 leading-tight transition-all rounded-lg outline-none text-start
   {{ collect($activeRoutes)->contains(fn($route) => Route::is($route))
      ? 'bg-zinc-100 bg-opacity-80 text-black'
      : '' }}
   hover:bg-zinc-100 hover:bg-opacity-80 hover:text-black focus:bg-opacity-80 focus:text-blue-gray-900">
    <img src="{{ asset($icon) }}"
         class="size-5 mr-4 transition-all duration-300 invert
                {{ collect($activeRoutes)->contains(fn($route) => Route::is($route))
                   ? 'invert-0'
                   : 'group-hover:invert-0' }}"
         alt="{{ $title }} icon">
    <p class="title-nav transition-opacity duration-300 ease-in-out">{{ $title }}</p>
</a>
