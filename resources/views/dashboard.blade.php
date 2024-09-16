<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex">
       <x-sidebar/>

        <!-- Main Content -->
        <div class="flex-1 py-12 px-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
                sidebar.classList.add('w-64');
                titles.forEach(element => element.classList.remove('hidden'));
            } else {
                toggleImg.src = '{{ asset('svg/toggle-off.svg') }}';
                sidebar.classList.remove('w-64');
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
