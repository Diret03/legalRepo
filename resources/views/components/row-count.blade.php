@props(['href', 'icon', 'title', 'count'])

<div class="max-w-sm w-full p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
    <div class="flex items-center mb-4">
        <img src="{{ asset($icon) }}" alt="{{$title}} logo" class="w-10 h-10 mr-3">
        <a href="{{$href}}" class="text-2xl font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
            {{$title}}
        </a>
    </div>
    <p class="text-4xl font-extrabold text-gray-700 dark:text-gray-300">{{$count}}</p>
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Total registrados</p>
    <div class="mt-4">
        <a href="{{$href}}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-650 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
            Ver registros
            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </a>
    </div>
</div>
