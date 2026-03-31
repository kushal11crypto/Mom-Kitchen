<x-app-layout>
    <div class="py-12 bg-[#FFFBF7] min-h-screen">
        <div class="max-w-2xl mx-auto px-4">

            <!-- Elegant Success Message -->
            @if(session('status') === 'profile-updated')
                <div class="mb-8 p-4 bg-orange-50 border border-orange-100 rounded-2xl flex items-center text-orange-700 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-medium">Profile updated! Your kitchen is ready.</span>
                </div>
            @endif

            <!-- Main Profile Card -->
            <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(251,146,60,0.1)] border border-orange-50 overflow-hidden">
                
                <!-- Card Header with Brand Color -->
                <div class="bg-orange-500 px-10 py-8 text-white">
                    <h2 class="text-3xl font-black tracking-tight">Chef's Profile</h2>
                    <p class="text-orange-100 opacity-90">Manage your delivery and contact details</p>
                </div>

                <div class="p-10 space-y-10">
                    <!-- Read-only Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-gray-50 pb-10">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">Full Name</label>
                            <p class="text-lg font-bold text-gray-800">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">Email Address</label>
                            <p class="text-lg text-gray-600">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <!-- Update Form -->
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <span class="w-8 h-1 bg-orange-500 rounded-full mr-3"></span>
                            Update Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Phone Number</label>
                                <input type="text" name="phone_number" placeholder="Enter mobile" value="{{ old('phone_number', auth()->user()->phone_number) }}"
                                       class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-3 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Home Address</label>
                                <input type="text" name="address" placeholder="Delivery street" value="{{ old('address', auth()->user()->address) }}"
                                       class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-3 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all outline-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Bio</label>
                            <textarea name="bio" rows="3" placeholder="Tell us about your food preferences..."
                                      class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-3 focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all outline-none resize-none">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-4 bg-orange-500 text-white rounded-xl font-black text-sm uppercase tracking-widest hover:bg-orange-600 shadow-lg shadow-orange-100 active:scale-[0.98] transition-all">
                            Save Kitchen Settings
                        </button>
                    </form>

                    <!-- Subtle Danger Zone -->
                    <div class="pt-8 border-t border-gray-50 flex items-center justify-between">
                        <p class="text-xs text-gray-400 font-medium italic">Joined Mom's Kitchen on {{ auth()->user()->created_at->format('M d, Y') }}</p>
                        
                        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[10px] font-bold text-gray-300 hover:text-red-500 transition-colors uppercase tracking-widest">
                                Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
