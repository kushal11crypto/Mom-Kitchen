<x-app-layout>
    <div class="bg-white rounded-3xl shadow-xl p-6 md:p-10">
    <h2 class="text-3xl font-extrabold mb-10">My Profile</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <div class="space-y-6 bg-gray-50 p-8 rounded-2xl border border-gray-100">
            <h3 class="text-2xl font-bold text-gray-800 border-b pb-4">Current Information</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Name</label>
                    <p class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</p>
                </div>

                <div>
                    <label class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Email</label>
                    <p class="text-gray-900 truncate">{{ auth()->user()->email }}</p>
                </div>

                <div>
                    <label class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Phone</label>
                    <p class="text-gray-900">{{ auth()->user()->phone_number ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Joined</label>
                    <p class="text-gray-900">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div>
                <label class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Address</label>
                <p class="text-gray-900">{{ auth()->user()->address ?? '-' }}</p>
            </div>

            <div>
                <label class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Bio</label>
                <p class="text-gray-900 leading-relaxed">{{ auth()->user()->bio ?? 'No bio added yet.' }}</p>
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-2xl font-bold text-gray-800">Update Profile</h3>
            
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-300">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-300">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-300">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Address</label>
                        <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Bio</label>
                    <textarea name="bio" rows="2"
                              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-300">{{ old('bio', auth()->user()->bio) }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Save Changes
                </button>
            </form>
        </div>
    </div>

    <hr class="my-12 border-gray-100">

    <div class="max-w-xl">
        <h3 class="text-2xl font-bold text-red-600">Danger Zone</h3>
        <p class="text-sm text-gray-500 mb-6">Permanently remove your account and all associated data.</p>
        
        <form action="{{ route('profile.destroy') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
            @csrf
            @method('DELETE')
            <div class="flex-1">
                <input type="password" name="password" placeholder="Confirm Password"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-300">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="whitespace-nowrap px-8 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition">
                Delete Account
            </button>
        </form>
    </div>
</div>
</x-app-layout>