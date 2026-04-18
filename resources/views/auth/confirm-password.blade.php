<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-black text-gray-900 tracking-tight mb-2">Security Check</h2>
        <p class="text-sm text-gray-500 leading-relaxed">
            {{ __('This is a secure area. Please confirm your password before continuing to your kitchen settings.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">
                {{ __('Your Password') }}
            </label>

            <input id="password" 
                   type="password"
                   name="password"
                   required 
                   autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all outline-none" 
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-4 bg-orange-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-orange-700 shadow-xl shadow-orange-100 active:scale-[0.98] transition-all">
                {{ __('Confirm Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>

            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
