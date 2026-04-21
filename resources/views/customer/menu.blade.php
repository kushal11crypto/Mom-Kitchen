<x-app-layout>

    <div class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Header -->
            <div class="text-center mb-10">
                <span class="text-orange-600 font-bold tracking-widest uppercase text-sm">
                    Fresh & Tasty
                </span>
                <h3 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-2">
                    Our Delicious Menu
                </h3>
                <div class="w-24 h-1.5 bg-orange-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- 🔍 Search Bar -->
            <div class="mb-10 flex justify-center">
                <form method="GET" action="{{ route('customer.menu') }}" class="w-full max-w-xl flex">
                    
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search delicious food..."
                        value="{{ request('search') }}"
                        class="w-full px-5 py-3 rounded-l-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                    >

                    <button 
                        type="submit"
                        class="bg-orange-600 text-white px-6 rounded-r-xl hover:bg-black transition"
                    >
                        Search
                    </button>

                </form>
            </div>

            <!-- Search Result Message -->
            @if(request('search'))
                <p class="text-center text-gray-500 mb-8">
                    Showing results for 
                    "<span class="font-semibold text-orange-600">{{ request('search') }}</span>"
                </p>
            @endif

            <!-- Success Toast -->
            <div id="success-message"
                class="fixed top-5 right-5 z-50 transform translate-x-full transition-transform duration-300 ease-in-out bg-white border-l-4 border-green-500 shadow-2xl rounded-lg p-4 hidden flex items-center gap-3">
                
                <div class="bg-green-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <span class="text-gray-800 font-medium" id="toast-text"></span>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

                @forelse($items as $item)
                <div class="group bg-white rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col">

                    <!-- Image -->
                    <div class="relative overflow-hidden p-4">
                        <img src="{{ asset('storage/' . $item->image_url) }}"
                             class="rounded-[2rem] w-full h-64 object-cover">

                        <!-- Badge -->
                        <div class="absolute top-8 left-8 bg-white/90 backdrop-blur px-4 py-1 rounded-full shadow-sm">
                            <span class="text-orange-600 font-bold text-sm">🔥 Popular</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="px-8 pb-8 flex-1 flex flex-col">

                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors">
                                {{ $item->item_name }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
        by <span class="font-semibold text-orange-600">
            {{ $item->user->name ?? 'Unknown Vendor' }}
        </span>
    </p>

                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">
                                Freshly prepared with premium ingredients.
                            </p>
                        </div>

                        <!-- Bottom -->
                        <div class="mt-auto flex items-center justify-between">

                            <div>
                                <span class="text-xs text-gray-400 uppercase font-semibold">Price</span>
                                <span class="text-2xl font-black text-gray-900">
                                    Rs. {{ $item->price }}
                                </span>
                            </div>

                            <!-- Add to Cart -->
                            <form class="add-to-cart-form" data-id="{{ $item->id }}">
                                @csrf
                                <input type="hidden" name="name" value="{{ $item->item_name }}">
                                <input type="hidden" name="price" value="{{ $item->price }}">
                                <input type="hidden" name="image" value="{{ $item->image_url }}">
                                <input type="hidden" name="seller_id" value="{{ $item->user_id }}">

                                <button type="submit"
                                    class="bg-orange-600 text-white p-4 rounded-2xl hover:bg-black hover:scale-110 transition-all shadow-lg shadow-orange-200 hover:shadow-gray-300">
                                    
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

                @empty
                <!-- No Items -->
                <div class="col-span-3 text-center py-20">
                    <h2 class="text-2xl font-bold text-gray-600">No items found</h2>
                    <p class="text-gray-400 mt-2">Try searching something else.</p>
                </div>
                @endforelse

            </div>
        </div>
    </div>

    <!-- JS -->
    <script>
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let id = this.getAttribute('data-id');
            let formData = new FormData(this);
            let btn = this.querySelector('button');
            let originalIcon = btn.innerHTML;

            // Loading spinner
            btn.innerHTML = `<svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>`;

            fetch(`/add-to-cart/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.innerHTML = originalIcon;

                if (data.success) {
                    // Update cart badge
                    const badge = document.getElementById('cart-count-badge');
                    if (badge) {
                        badge.innerText = data.cart_count;
                        badge.classList.remove('hidden');
                    }

                    // Show toast
                    const toast = document.getElementById('success-message');
                    const text = document.getElementById('toast-text');

                    text.innerText = data.message;
                    toast.classList.remove('hidden', 'translate-x-full');

                    setTimeout(() => {
                        toast.classList.add('translate-x-full');
                        setTimeout(() => toast.classList.add('hidden'), 300);
                    }, 3000);
                }
            })
            .catch(error => {
                btn.innerHTML = originalIcon;
                console.error(error);
            });
        });
    });
    </script>

</x-app-layout>