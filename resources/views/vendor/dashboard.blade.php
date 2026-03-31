<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                🍳 Mom's Kitchen <span class="text-slate-400 font-normal ml-2">Inventory Management</span>
            </h2>

            <a href="{{ route('vendor.items.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                ➕ Add New Item
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-400 text-emerald-800 rounded-lg shadow-sm flex items-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ITEMS TABLE --}}
            <div class="bg-white shadow-xl sm:rounded-2xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">

                        {{-- TABLE HEAD --}}
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Item</th>
                                <th class="px-6 py-4 text-xs font-bold text-center text-slate-500 uppercase">Category</th>
                                <th class="px-6 py-4 text-xs font-bold text-center text-slate-500 uppercase">Price</th>
                                <th class="px-6 py-4 text-xs font-bold text-right text-slate-500 uppercase">Actions</th>
                            </tr>
                        </thead>

                        {{-- TABLE BODY --}}
                        <tbody class="divide-y divide-slate-100">

                            @forelse($items as $item)
                                <tr class="hover:bg-slate-50 transition">

                                    {{-- ITEM NAME + IMAGE --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">

                                            {{-- IMAGE --}}
                                            <div class="h-10 w-10 flex-shrink-0">
                                                @if($item->image_url)
                                                    <img src="{{ asset('storage/' . $item->image_url) }}"
                                                         class="h-10 w-10 rounded-lg object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center font-bold text-indigo-600">
                                                        {{ strtoupper(substr($item->item_name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- ITEM NAME + ID --}}
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-900">
                                                    {{ $item->item_name }}
                                                </div>
                                                <div class="text-xs text-slate-500">
                                                    ID: #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                                </div>
                                            </div>

                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                         <span class="px-3 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-full border border-slate-200">
                                            {{ $item->category->categoryName ?? 'N/A' }}
                                        </span>
                                    </td>
                                    {{-- PRICE --}}
                                    <td class="px-6 py-4 text-center">
                                        <div class="font-semibold text-slate-900">
                                            Rs. {{ number_format($item->price, 2) }}
                                        </div>
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-3">

                                            <a href="{{ route('vendor.items.edit', $item->id) }}"
                                               class="text-amber-600 hover:text-amber-700 text-sm font-semibold">
                                                Edit
                                            </a>

                                            <form action="{{ route('vendor.items.destroy', $item->id) }}" method="POST"
                                                  onsubmit="return confirm('Delete this item?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="text-red-500 hover:text-red-600 text-sm font-semibold">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-lg font-medium">Your menu is empty</p>
                                            <p class="text-sm text-slate-400">Add your first item to start selling.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TOTAL ITEMS --}}
            <div class="mt-6 text-xs text-slate-500">
                Total Items: {{ $items->count() }}
            </div>

        </div>
    </div>
</x-app-layout>