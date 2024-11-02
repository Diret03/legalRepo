<x-guest-layout title="Reactivar cuenta">
    <p class="font-medium text-sm text-gray-700 mb-5">
        Si tienes casos aceptados, pasarán a ser públicos de nuevo.
    </p>
    <form method="POST" action="{{ route('reactivate.store') }}">
        @csrf
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            {{--            <x-text-input id="email" class="block mt-1 w-full bg-gray-300" type="email" name="email" :value="old('email', $request->email)" readonly autofocus autocomplete="username" />--}}
            <p class="w-full px-3 py-2 text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{$request->email}}</p>
            <input type="hidden" name="email" value="{{ $request->email }}">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reactivar Cuenta') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
