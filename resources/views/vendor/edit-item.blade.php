<!-- resources/views/items/edit-item.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">
                    {{ __('Edit Menu Item') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Update the details of your menu item.</p>
            </div>
            <a href="{{ route('vendor.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 transition ease-in-out duration-150">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">Check the following errors:</h3>
                            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-2xl shadow-slate-200/50 sm:rounded-3xl border border-slate-100 overflow-hidden">
                <div class="p-8 sm:p-10">
                    <form action="{{ route('vendor.items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Item Name -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Item Name</label>
                            <input type="text" name="item_name" value="{{ old('item_name', $item->item_name) }}"
                                   placeholder="e.g. Traditional Nepali Thali"
                                   class="w-full border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl shadow-sm px-5 py-4 transition-all"
                                   required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Price</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-medium">Rs.</span>
                                    </div>
                                    <input type="number" step="0.01" name="price" value="{{ old('price', $item->price) }}"
                                           class="w-full border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl shadow-sm pl-12 py-4 transition-all"
                                           placeholder="0.00" required>
                                </div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Category</label>
                                <select name="category_id"
                                        class="w-full border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl shadow-sm px-5 py-4 transition-all appearance-none cursor-pointer"
                                        required>
                                    <option value="" disabled>Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id) == $category->id)>
                                            {{ $category->categoryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Image Upload with Preview -->
                        <div class="pt-4 border-t border-slate-50">
                            <label class="block text-sm font-bold text-slate-700 mb-3 ml-1">Cover Image</label>

                            <!-- Preview Box -->
                            <div id="preview-container" class="mb-4 relative {{ $item->image_url ? '' : 'hidden' }}">
                                <img id="image-preview" src="{{ $item->image_url ? asset('storage/'.$item->image_url) : '#' }}" 
                                     alt="Preview" class="w-full h-56 object-cover rounded-3xl border-4 border-white shadow-lg">
                                <button type="button" onclick="removeImage()" class="absolute top-3 right-3 bg-red-500 text-white p-2 rounded-full shadow-xl hover:bg-red-600 transition transform hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Dropzone -->
                            <div id="dropzone" class="relative group {{ $item->image_url ? 'hidden' : '' }}">
                                <div class="flex justify-center px-6 pt-8 pb-8 border-2 border-slate-200 border-dashed rounded-3xl group-hover:border-indigo-400 group-hover:bg-indigo-50/30 transition-all cursor-pointer">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-indigo-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="text-sm text-slate-600 font-medium">
                                            <span class="text-indigo-600 font-bold">Click to upload</span> or drag and drop
                                        </div>
                                        <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold">JPG, PNG (Max 5MB)</p>
                                    </div>
                                </div>
                                <input type="file" id="image-input" name="image" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                       accept="image/*" onchange="previewFile()">
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="pt-4 border-t border-slate-50">
                            <label class="block text-sm font-bold text-slate-700 mb-4 ml-1">Availability</label>
                            <div class="inline-flex p-1 bg-slate-100 rounded-2xl">
                                <label class="cursor-pointer">
                                    <input type="radio" name="availability_status" value="available" class="hidden peer" {{ old('availability_status', $item->availability_status) == 'available' ? 'checked' : '' }}>
                                    <span class="inline-block px-6 py-2 rounded-xl text-sm font-bold transition-all peer-checked:bg-white peer-checked:text-indigo-600 peer-checked:shadow-sm text-slate-500">Available</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="availability_status" value="unavailable" class="hidden peer" {{ old('availability_status', $item->availability_status) == 'unavailable' ? 'checked' : '' }}>
                                    <span class="inline-block px-6 py-2 rounded-xl text-sm font-bold transition-all peer-checked:bg-white peer-checked:text-red-600 peer-checked:shadow-sm text-slate-500">Out of Stock</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full py-4 px-6 rounded-2xl text-white font-extrabold bg-indigo-600 hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all transform active:scale-95">
                                Update Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Live Preview -->
    <script>
        function previewFile() {
            const input = document.getElementById('image-input');
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('preview-container');
            const dropzone = document.getElementById('dropzone');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                    dropzone.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('image-input');
            const container = document.getElementById('preview-container');
            const dropzone = document.getElementById('dropzone');
            
            input.value = ""; 
            container.classList.add('hidden');
            dropzone.classList.remove('hidden');
        }
    </script>
</x-app-layout>