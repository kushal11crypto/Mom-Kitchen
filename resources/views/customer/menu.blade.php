<x-app-layout>


    @php
    $products = [
        ['id' => 1, 'name' => 'Chicken Burger', 'price' => 350, 'image' => 'https://via.placeholder.com/200'],
        ['id' => 2, 'name' => 'Pizza', 'price' => 800, 'image' => 'https://via.placeholder.com/200'],
        ['id' => 3, 'name' => 'Momo', 'price' => 180, 'image' => 'https://via.placeholder.com/200']
    ];
    @endphp

    <div class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center mb-12">
                <span class="text-orange-600 font-bold tracking-widest uppercase text-sm">Fresh & Tasty</span>
                <h3 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-2">
                    Our Delicious Menu
                </h3>
                <div class="w-24 h-1.5 bg-orange-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Floating Success Toast -->
            <div id="success-message" class="fixed top-5 right-5 z-50 transform translate-x-full transition-transform duration-300 ease-in-out bg-white border-l-4 border-green-500 shadow-2xl rounded-lg p-4 hidden flex items-center gap-3">
                <div class="bg-green-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-gray-800 font-medium" id="toast-text"></span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($products as $product)
                <div class="group bg-white rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col">
                    
                    <!-- Image Container -->
                    <div class="relative overflow-hidden p-4">
                        <img src="{{ $product['image'] }}" 
                             class="rounded-[2rem] w-full h-64 object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-8 left-8 bg-white/90 backdrop-blur px-4 py-1 rounded-full shadow-sm">
                            <span class="text-orange-600 font-bold text-sm">🔥 Popular</span>
                        </div>
                    </div>

                    <div class="px-8 pb-8 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors">
                                    {{ $product['name'] }}
                                </h3>
                                <p class="text-gray-400 text-sm mt-1 leading-relaxed">
                                    Premium ingredients, cooked to perfection.
                                </p>
                            </div>
                        </div>

                        <div class="mt-auto flex items-center justify-between">
                            <div>
                                <span class="text-xs text-gray-400 block uppercase font-semibold">Price</span>
                                <span class="text-2xl font-black text-gray-900">Rs. {{ $product['price'] }}</span>
                            </div>

                            <form class="add-to-cart-form" data-id="{{ $product['id'] }}">
                                @csrf
                                <input type="hidden" name="name" value="{{ $product['name'] }}">
                                <input type="hidden" name="price" value="{{ $product['price'] }}">
                                <input type="hidden" name="image" value="{{ $product['image'] }}">

                                <button type="submit"
                                    class="bg-orange-600 text-white p-4 rounded-2xl hover:bg-black hover:scale-110 transition-all shadow-lg shadow-orange-200 hover:shadow-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let id = this.getAttribute('data-id');
            let formData = new FormData(this);
            let btn = this.querySelector('button');

            // Feedback: Change icon temporarily
            btn.innerHTML = `<svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

            fetch(`/add-to-cart/${id}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Reset button icon
                btn.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>`;
                
                if (data.success) {
                    const toast = document.getElementById('success-message');
                    document.getElementById('toast-text').innerText = data.message;
                    
                    toast.classList.remove('hidden', 'translate-x-full');
                    
                    setTimeout(() => {
                        toast.classList.add('translate-x-full');
                        setTimeout(() => toast.classList.add('hidden'), 300);
                    }, 3000);
                }
            })
            .catch(error => console.error(error));
        });
    });
    </script>
</x-app-layout>
