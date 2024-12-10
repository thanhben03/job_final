<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('company.login.store') }}">
        @csrf
        <x-input-error :messages="$errors->get('msg')" class="mt-2" />

        <!-- Email Address -->
        <div>
            <x-input-label for="company_email" :value="__('Email')" />
            <x-text-input id="company_email" class="block mt-1 w-full" type="email" name="company_email" :value="old('company_email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('company_email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="company_password" :value="__('Password')" />

            <x-text-input id="company_password" class="block mt-1 w-full" type="password" name="company_password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('company_password')" class="mt-2" />
        </div>



        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
            <button class="ms-3 btn btn-success">
                <a href="{{route('company.register')}}">{{ __('Register') }}</a>
            </button>
        </div>
    </form>
</x-guest-layout>
