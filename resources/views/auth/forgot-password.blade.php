<x-guest-layout>
    <div class="max-w-md mx-auto bg-white p-8 rounded-3xl">

        <div class="mb-6 text-sm text-gray-600 text-center">
            Forgot your password? Enter your email and we’ll send you a reset link.
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-green-600 text-sm text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold mb-1"/>

                <div class="relative">
                    <x-text-input 
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email')"
                        required
                        autofocus
                        placeholder="Enter your email"
                        class="block w-full pl-4 pr-4 py-3 rounded-xl border border-gray-300 
                               focus:ring-2 focus:ring-orange-500 focus:border-orange-500 
                               transition duration-200 outline-none shadow-sm"
                    />
                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Button -->
            <div class="mt-6">
                <x-primary-button 
                    class="w-full justify-center py-3 text-base rounded-xl bg-orange-600 hover:bg-orange-700 transition-all shadow-md">
                    Email Password Reset Link
                </x-primary-button>
            </div>
        </form>

    </div>
</x-guest-layout>