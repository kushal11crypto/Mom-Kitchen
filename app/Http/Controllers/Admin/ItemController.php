<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Show all items
    public function index(Request $request)
{
    $query = Item::with(['user', 'category']);

    if ($request->filled('search')) {
        $query->where('item_name', 'like', '%' . $request->search . '%')
              ->orWhereHas('category', function ($q) use ($request) {
                  $q->where('categoryName', 'like', '%' . $request->search . '%');
              })
              ->orWhereHas('user', function ($q) use ($request) {
                  $q->where('name', 'like', '%' . $request->search . '%');
              });
    }

    $items = $query->latest()->get();

    return view('admin.items.index', compact('items'));
}
public function menu(Request $request)
{
    $query = Item::with(['category', 'user']);

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('item_name', 'like', '%' . $search . '%')
              ->orWhere('price', 'like', '%' . $search . '%')
              ->orWhereHas('category', function ($c) use ($search) {
                  $c->where('categoryName', 'like', '%' . $search . '%');
              });
        });
    }

    $items = $query->latest()->get();

    return view('customer.menu', compact('items'));
}
    // Show create form
    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return view('admin.items.create', compact('categories', 'users'));
    }

    // Store item
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'user_id' => 'required',
            'image_url' => 'nullable|image',
            'availability_status' => 'required'
        ]);

        $imagePath = null;

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('items', 'public');
        }

        Item::create([
            'item_name' => $request->item_name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'availability_status' => $request->availability_status,
            'image_url' => $imagePath
        ]);

        return redirect()->route('admin.items.index')->with('success', 'Item created successfully');
    }

    // Edit form
    public function edit(Item $item)
    {
        $categories = Category::all();
        $users = User::all();
        return view('admin.items.edit', compact('item', 'categories', 'users'));
    }

    // Update item
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'user_id' => 'required',
            'availability_status' => 'required'
        ]);

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('items', 'public');
            $item->image_url = $imagePath;
        }

        $item->update([
            'item_name' => $request->item_name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'availability_status' => $request->availability_status,
        ]);

        return redirect()->route('admin.items.index')->with('success', 'Item updated successfully');
    }

    // Delete item
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('admin.items.index')->with('success', 'Item deleted successfully');
    }
}