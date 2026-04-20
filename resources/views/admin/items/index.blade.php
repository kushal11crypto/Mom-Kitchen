@extends('layouts.admin')

@section('title', 'Items')

@section('content')

<div class="flex justify-between mb-6">
    <h2 class="text-2xl font-bold">Items</h2>
    <a href="{{ route('admin.items.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
        + Add Item
    </a>
</div>

<div class="bg-white shadow rounded overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 text-left">Image</th>
                <th class="py-2 px-4 text-left">Name</th>
                <th class="py-2 px-4 text-left">Category</th>
                <th class="py-2 px-4 text-left">Vendor</th>
                <th class="py-2 px-4 text-left">Price</th>
                <th class="py-2 px-4 text-left">Status</th>
                <th class="py-2 px-4 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($items as $item)
                <tr class="border-b">
                    <td class="py-2 px-4">
                        @if($item->image_url)
                            <img src="{{ asset('storage/'.$item->image_url) }}" class="w-12 h-12 rounded">
                        @endif
                    </td>

                    <td class="py-2 px-4">{{ $item->item_name }}</td>
                    <td class="py-2 px-4">{{ $item->category->categoryName ?? 'N/A' }}</td>
                    <td class="py-2 px-4">{{ $item->user->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4">Rs. {{ $item->price }}</td>
                    <td class="py-2 px-4">
                        <span class="px-2 py-1 rounded text-white 
                            {{ $item->availability_status == 'available' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ ucfirst($item->availability_status) }}
                        </span>
                    </td>

                    <td class="py-2 px-4 flex gap-2">
                        
                        <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No items found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection