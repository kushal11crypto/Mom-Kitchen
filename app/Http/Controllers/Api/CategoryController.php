<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // List all categories
    public function index()
    {
        return Category::all();
    }

    // Show single category
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return $category;
    }

    // Create new category
    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255|unique:categories,categoryName',
        ]);

        $category = Category::create([
            'categoryName' => $request->categoryName,
        ]);

        return response()->json($category, 201);
    }

    // Update category
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->update($request->only('categoryName'));

        return response()->json($category);
    }

    // Delete category
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
