<x-app-layout>

    <div class="container mx-auto px-4 my-12 min-h-screen flex flex-col">

        <h2 class="text-4xl font-extrabold  mb-8">{{$case->title}}</h2>

        <div class="py-6 px-10 bg-white border border-gray-200 rounded-lg shadow mb-4">

            <div class="flex flex-col lg:flex-row">
                <div class="w-full lg:w-1/2">
                    <x-colon-text label="Número de caso" :value="$case->id"/>
                    <x-colon-text label="Fecha" :value="\Carbon\Carbon::parse($case->date)->format('d/m/Y')"/>
                    <x-colon-text label="Materia" :value="$case->trial->subject->name"/>
                    <x-colon-text label="Juicio" :value="$case->trial->name"/>
                </div>
                <div class="w-full lg:w-1/2">
                    <x-colon-text label="Origen" value="{{$case->origin}}"/>
                    <x-colon-text label="Etiquetas" value="aux"/>
                </div>
            </div>



            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px">
                    <li class="me-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-red-650 hover:border-red-300">Profile</a>
                    </li>
                    <li class="me-2">
                        <a href="#" class="inline-block p-4 text-red-650 border-b-2 border-red-650 rounded-t-lg active" aria-current="page">Dashboard</a>
                    </li>
                    <li class="me-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-red-650 hover:border-red-300">Settings</a>
                    </li>
                    <li class="me-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-red-650 hover:border-red-300">Contacts</a>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
            </div>



        </div>


    </div>

</x-app-layout>
