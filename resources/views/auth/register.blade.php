<x-guest-layout>
    <form method="POST" action="{{ route('company.register.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="fullname" :value="__('lang.Company Name')" />
            <x-text-input id="fullname" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')"
                required autofocus autocomplete="fullname" />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('lang.Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('lang.phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="company_phone" :value="old('company_phone')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('company_phone')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="phone" :value="__('lang.Province')" />
            <select 
                style="border: 1px solid #d1d5db;
                    font-size: 14px;
                    border-radius: 5px;" 
                name="province_id"
                id="">
                @foreach ($provinces as $value)
                    <option value="{{ $value->code }}">{{ $value->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('province_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
