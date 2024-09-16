<!-- Sidebar -->
<div class="sidebar min-h-screen bg-zinc-700 shadow-xl transition-all duration-300 ease-in-out">
    <div class="flex justify-center text-white">
        <div class="grid place-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                 class="w-5 h-5">
                <path fill-rule="evenodd"
                      d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.04 16.5l.5-1.5h6.42l.5 1.5H8.29zm7.46-12a.75.75 0 00-1.5 0v6a.75.75 0 001.5 0v-6zm-3 2.25a.75.75 0 00-1.5 0v3.75a.75.75 0 001.5 0V9zm-3 2.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5z"
                      clip-rule="evenodd"></path>
            </svg>
        </div>
        <button id="toggle-button" onclick="toggleSidebar()" class="focus:outline-none">
            <img id="toggle-img" src="{{ asset('svg/toggle-on.svg') }}" class="size-10" alt="toggle icon"  style="filter: brightness(0) invert(1);">
        </button>
    </div>
    <nav class="flex flex-col gap-1 px-2 pb-2 font-sans text-base font-normal text-white">
        <a role="button" href="#"
             class="flex items-center w-full p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-zinc-100 hover:bg-opacity-80 hover:text-black focus:bg-opacity-80 focus:text-blue-gray-900">
            <img src="{{ asset('svg/cases.svg') }}" class="size-5 mr-4" alt="casos icon"  style="filter: brightness(0) invert(1);">
            <p class="title-nav transition-opacity duration-300 ease-in-out">Casos</p>
        </a>
        <a role="button" href="#"
           class="flex items-center w-full p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-zinc-100 hover:bg-opacity-80 hover:text-black focus:bg-opacity-80 focus:text-blue-gray-900">
            <img src="{{ asset('svg/subjects.svg') }}" class="size-5 mr-4" alt="materias icon"  style="filter: brightness(0) invert(1);">
            <p class="title-nav transition-opacity duration-300 ease-in-out">Materias</p>
        </a>
        <a role="button" href="#"
           class="flex items-center w-full p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-zinc-100 hover:bg-opacity-80 hover:text-black focus:bg-opacity-80 focus:text-blue-gray-900">
            <img src="{{ asset('svg/trials.svg') }}" class="size-5 mr-4" alt="juicios icon"  style="filter: brightness(0) invert(1);">
            <p class="title-nav transition-opacity duration-300 ease-in-out">Juicios</p>
        </a>
        <a role="button" href="#"
           class="flex items-center w-full p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-zinc-100 hover:bg-opacity-80 hover:text-black focus:bg-opacity-80 focus:text-blue-gray-900">
            <img src="{{ asset('svg/users.svg') }}" class="size-5 mr-4" alt="usuarios icon" style="filter: brightness(0) invert(1);">
            <p class="title-nav transition-opacity duration-300 ease-in-out">Usuarios</p>
        </a>
{{--        <div role="button"--}}
{{--             class="flex items-center  p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">--}}
{{--            <div class="grid mr-4 place-items-center">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"--}}
{{--                     class="w-5 h-5">--}}
{{--                    <path fill-rule="evenodd"--}}
{{--                          d="M12 2.25a.75.75 0 01.75.75v9a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM6.166 5.106a.75.75 0 010 1.06 8.25 8.25 0 1011.668 0 .75.75 0 111.06-1.06c3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788a.75.75 0 011.06 0z"--}}
{{--                          clip-rule="evenodd"></path>--}}
{{--                </svg>--}}
{{--            </div>--}}
{{--            <p class="title-nav transition-opacity duration-300 ease-in-out">Log Out</p>--}}
{{--        </div>--}}
    </nav>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sidebarExpanded = true;
        const toggleImg = document.getElementById("toggle-img");
        const sidebar = document.querySelector(".sidebar");
        const titles = document.querySelectorAll(".title-nav");

        function updateSidebarState() {
            if (sidebarExpanded) {
                toggleImg.src = '{{ asset('svg/toggle-on.svg') }}';
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-52');
                titles.forEach(element => element.classList.remove('hidden'));
            } else {
                toggleImg.src = '{{ asset('svg/toggle-off.svg') }}';
                sidebar.classList.remove('w-52');
                sidebar.classList.add('w-20');
                titles.forEach(element => element.classList.add('hidden'));
            }
        }

        // Set initial state
        updateSidebarState();

        // Toggle function
        window.toggleSidebar = function() {
            sidebarExpanded = !sidebarExpanded;
            updateSidebarState();
        }
    });

</script>
