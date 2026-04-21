<x-guest-layout>
    <div class="flex items-center justify-center">
        <div class="w-full max-w-md bg-white p-8">
            
            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-orange-600 mb-6">
                Create an Account 🚀
            </h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Role (Hidden as per your logic) -->
                <input type="hidden" name="role" value="{{ request()->query('role', 'customer') }}">

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none"
                        required autofocus autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none"
                        required autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>
                <!-- Phone Number -->
<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Phone Number</label>
    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
    placeholder="98XXXXXXXX"
    pattern="(98|97)[0-9]{8}"
    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none"
    required>
    <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
</div>



                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Password</label>
                    <input id="password" type="password" name="password" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none"
                        required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none"
                        required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Actions -->
                <div class="flex flex-col space-y-4">
                    <button type="submit"
                        class="w-full bg-orange-600 text-white py-2 rounded-lg font-semibold hover:bg-orange-700 transition">
                        {{ __('Register') }}
                    </button>

                    <a class="text-sm text-center text-gray-600 hover:text-orange-600 transition" href="{{ route('login') }}">
                        {{ __('Already registered? Login here') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
