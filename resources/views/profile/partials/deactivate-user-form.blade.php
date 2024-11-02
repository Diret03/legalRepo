<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Desactivar Cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Tu cuenta se desactivará y tus casos aceptados ya no serán públicos. Puedes activar tu cuenta de nuevo cuando inicies sesión de nuevo.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deactivation')"
    >{{ __('Desactivar Cuenta') }}</x-danger-button>

    <x-modal name="confirm-user-deactivation" :show="$errors->userDeactivation->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.deactivate') }}" class="p-6">
            @csrf
            @method('PATCH')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('¿Estás seguro de que deseas desactivar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Tu cuenta se desactivará y tus casos aceptados ya no serán públicos. Puedes activar tu cuenta de nuevo cuando inicies sesión de nuevo.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeactivation->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Desactivar Cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
