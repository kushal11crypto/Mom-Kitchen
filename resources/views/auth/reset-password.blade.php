<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-black text-gray-900 tracking-tight mb-2">Reset Password</h2>
        <p class="text-sm text-gray-500">
            {{ __('Choose a strong new password to keep your kitchen account secure.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="text-[10px] font-bold text-orange-400 uppercase tracking-widest ml-1">
                {{ __('Email Address') }}
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email', $request->email) }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all outline-none" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="text-[10px] font-bold text-orange-400 uppercase tracking-widest ml-1">
                {{ __('New Password') }}
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password"
                   placeholder="••••••••"
                   class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all outline-none" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label for="password_confirmation" class="text-[10px] font-bold text-orange-400 uppercase tracking-widest ml-1">
                {{ __('Confirm New Password') }}
            </label>
            <input id="password_confirmation" 
                   type="password"
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   placeholder="••••••••"
                   class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all outline-none" 
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-orange-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-orange-700 shadow-xl shadow-orange-100 active:scale-[0.98] transition-all">
                {{ __('Update Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
