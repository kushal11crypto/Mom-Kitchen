@extends('layouts.admin')
@section('title', 'Menu Categories')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="font-bold">Total Categories: {{ $categories->total() }}</h3>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> New Category
        </a>
    </div>

    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-400 text-xs uppercase">
            <tr>
                <th class="px-6 py-4">Category Name</th>
                <th class="px-6 py-4">Items Count</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($categories as $category)
            <tr>
                <td class="px-6 py-4 font-medium">{{ $category->categoryName }}</td>
                <td class="px-6 py-4">{{ $category->items_count }} items</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" 
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection