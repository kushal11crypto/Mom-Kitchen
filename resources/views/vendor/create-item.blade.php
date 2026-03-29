<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-slate-800 tracking-tight">
                {{ __('Create Menu Item') }}
            </h2>
            <a href="{{ route('vendor.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-white border rounded-xl text-slate-700 hover:bg-slate-50 transition">
               ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded shadow-sm">
                    <h3 class="font-bold text-red-800">Check the following errors:</h3>
                    <ul class="list-disc ml-5 mt-2 text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-2xl rounded-3xl border border-slate-100 overflow-hidden">
                <div class="p-8 sm:p-10">
                   <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <!-- Item Name -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Item Name</label>
                            <input type="text" name="item_name" value="{{ old('item_name') }}"
                                   placeholder="e.g. Traditional Nepali Thali"
                                   class="w-full border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-200"
                                   required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Price</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        Rs.
                                    </div>
                                    <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                                           class="w-full pl-12 py-4 border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-200"
                                           placeholder="0.00" required>
                                </div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                                <select name="category_id" required
                                        class="w-full border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-200">
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->categoryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="pt-4 border-t border-slate-50">
                            <label class="block text-sm font-bold text-slate-700 mb-3">Cover Image</label>
                            <div id="preview-container" class="hidden mb-4 relative">
                                <img id="image-preview" src="#" class="w-full h-56 object-cover rounded-3xl border-4 border-white shadow-lg">
                                <button type="button" onclick="removeImage()" class="absolute top-3 right-3 bg-red-500 text-white p-2 rounded-full">
                                    ×
                                </button>
                            </div>

                            <div id="dropzone" class="relative">
                                <div class="flex justify-center px-6 pt-8 pb-8 border-2 border-dashed rounded-3xl cursor-pointer">
                                    <div class="text-center text-slate-600">
                                        Click to upload or drag and drop<br>
                                        <small>JPG, PNG (Max 5MB)</small>
                                    </div>
                                </div>
                                <input type="file" id="image-input" name="image" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                       accept="image/*" onchange="previewFile()">
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="pt-4 border-t border-slate-50">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Availability</label>
                            <div class="inline-flex p-1 bg-slate-100 rounded-2xl">
                                <label class="cursor-pointer">
                                    <input type="radio" name="availability_status" value="available" class="hidden peer" 
                                        {{ old('availability_status', 'available') == 'available' ? 'checked' : '' }}>
                                    <span class="peer-checked:bg-white peer-checked:text-indigo-600 px-6 py-2 rounded-xl">Available</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="availability_status" value="unavailable" class="hidden peer"
                                        {{ old('availability_status') == 'unavailable' ? 'checked' : '' }}>
                                    <span class="peer-checked:bg-white peer-checked:text-red-600 px-6 py-2 rounded-xl">Out of Stock</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-4">
                            <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700">
                                Add to Kitchen Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewFile() {
            const input = document.getElementById('image-input');
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('preview-container');
            const dropzone = document.getElementById('dropzone');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                    dropzone.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('image-input');
            const container = document.getElementById('preview-container');
            const dropzone = document.getElementById('dropzone');

            input.value = '';
            container.classList.add('hidden');
            dropzone.classList.remove('hidden');
        }
    </script>
</x-app-layout>