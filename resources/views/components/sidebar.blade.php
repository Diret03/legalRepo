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
            <img id="toggle-img" src="{{ asset('svg/toggle-on.svg') }}" class="size-10" alt="toggle icon"
                 style="filter: brightness(0) invert(1);">
        </button>
    </div>
    <nav class="flex flex-col gap-1 px-2 pb-2 font-sans text-base font-normal text-white">

        @can('ver dashboard')
            <x-dash-link
                href="{{ route('dashboard') }}"
                icon="svg/summary.svg"
                title="Resumen"
                :activeRoutes="['dashboard']"
            />
        @endcan
        @can('ver casos propios')
            <x-dash-link
                href="{{ route('cases.mycases', Auth::user()->id) }}"
                icon="svg/review-case.svg"
                title="Mis Casos"
                :activeRoutes="['cases.mycases']"
            />
        @endcan
        @can('revisar casos')
            <x-dash-link
                href="{{ route('cases.review') }}"
                icon="svg/review.svg"
                title="Revisar Casos"
                :activeRoutes="['cases.review']"
            />
        @endcan
        @can('ver casos')
            <x-dash-link
                href="{{ route('cases.index') }}"
                icon="svg/cases.svg"
                title="Casos"
                :activeRoutes="['cases.index', 'cases.create', 'cases.edit']"
            />
        @endcan

        @can('ver materias')
            <x-dash-link
                href="{{ route('subjects.index') }}"
                icon="svg/subjects.svg"
                title="Materias"
                :activeRoutes="['subjects.index', 'subjects.create', 'subjects.edit']"
            />
        @endcan

        @can('ver juicios')
            <x-dash-link
                href="{{ route('trials.index') }}"
                icon="svg/trials.svg"
                title="Juicios"
                :activeRoutes="['trials.index', 'trials.create', 'trials.edit']"
            />

        @endcan

        @can('ver usuarios')
            <x-dash-link
                href="{{ route('users.index') }}"
                icon="svg/users.svg"
                title="Usuarios"
                :activeRoutes="['users.index', 'users.create', 'users.edit']"
            />

        @endcan

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit"
                   class="group flex items-center w-full p-3 leading-tight transition-all rounded-lg outline-none text-start
                           hover:bg-zinc-100 hover:bg-opacity-80 hover:text-black focus:bg-opacity-80 focus:text-blue-gray-900">
                    <img src="{{ asset('svg/logout.svg') }}"
                         class="size-5 mr-4 transition-all duration-300 invert group-hover:invert-0"
                         alt="Salir icon">
                    <p class="title-nav transition-opacity duration-300 ease-in-out">Cerrar sesión</p>
                </button>


            </form>

        {{--        <x-dash-link href="{{ route('subjects.index') }}" icon="svg/subjects.svg" title="Materias" activeRoute="subjects.index"/>--}}

        {{--        <x-dash-link href="{{ route('trials.index') }}" icon="svg/trials.svg" title="Juicios" activeRoute="trials.index"/>--}}
    </nav>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // check if the screen width is less than or equal to 768px (
        let sidebarExpanded = !window.matchMedia("(max-width: 768px)").matches;
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
        window.toggleSidebar = function () {
            sidebarExpanded = !sidebarExpanded;
            updateSidebarState();
        }
    });

</script>
