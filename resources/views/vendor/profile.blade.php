<x-app-layout>
    <div class="py-12 bg-[#FFFBF7] min-h-screen">
        <div class="max-w-2xl mx-auto px-4">

            <!-- Success Message -->
            @if(session('status') === 'vendor-profile-updated')
                <div class="mb-8 p-4 bg-orange-50 border border-orange-100 rounded-2xl flex items-center text-orange-700 shadow-sm">
                    <span class="font-medium">Success! Your kitchen details have been updated.</span>
                </div>
            @endif

            <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(251,146,60,0.1)] border border-orange-50 overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gray-900 px-10 py-8 text-white">
                    <h2 class="text-3xl font-black text-orange-500">Kitchen Profile</h2>
                    <p class="text-gray-400">View and manage your public store information</p>
                </div>

                <div class="p-10">
                    <!-- SECTION 1: ONLY DETAILS (READ ONLY) -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <span class="w-8 h-1 bg-orange-500 rounded-full mr-3"></span>
                            Current Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-orange-50/30 p-6 rounded-3xl border border-orange-100">
                            <div>
                                <label class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">Kitchen Name</label>
                                <p class="font-bold text-gray-800">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">Contact No.</label>
                                <p class="font-bold text-gray-800">{{ $user->phone_number ?? 'Not Set' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">Address</label>
                                <p class="font-bold text-gray-800">{{ $user->address ?? 'Not Set' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">Kitchen Bio</label>
                                <p class="text-gray-600 italic">"{{ $user->bio ?? 'No bio written yet.' }}"</p>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 my-10"></div>

                    <!-- SECTION 2: UPDATE FORM -->
                    <form action="{{ route('vendor.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <span class="w-8 h-1 bg-orange-500 rounded-full mr-3"></span>
                            Edit Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-700 uppercase">Phone Number</label>
                                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                       class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-3 focus:ring-4 focus:ring-orange-100 outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-700 uppercase">Pickup Address</label>
                                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                       class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-3 focus:ring-4 focus:ring-orange-100 outline-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-700 uppercase">About Your Food</label>
                            <textarea name="bio" rows="3" class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-3 focus:ring-4 focus:ring-orange-100 outline-none resize-none">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-4 bg-orange-600 text-white rounded-xl font-black uppercase tracking-widest hover:bg-orange-700 shadow-xl transition-all active:scale-95">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
