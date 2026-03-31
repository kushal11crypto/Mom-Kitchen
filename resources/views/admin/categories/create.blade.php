@extends('layouts.admin')

@section('title', 'Add New Category')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Create Category</h2>
        <a href="{{ route('admin.categories.index') }}" class="text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-2">
                Category Name
            </label>
            <input type="text" 
                   name="categoryName" 
                   id="categoryName" 
                   value="{{ old('categoryName') }}"
                   class="w-full border {{ $errors->has('categoryName') ? 'border-red-500' : 'border-gray-300' }} rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="e.g. Italian, Desserts, Beverages"
                   required>
            
            @error('categoryName')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                <i class="fas fa-save mr-2"></i> Save Category
            </button>
        </div>
    </form>
</div>
@endsection