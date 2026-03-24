<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display Vendor Dashboard
     */
    public function dashboard()
    {
        $items = Item::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('vendor.dashboard', compact('items'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $categories = Category::all();
        return view('vendor.create-item', compact('categories'));
    }

    /**
     * Store New Item
     */
     public function store(Request $request)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'availability_status' => 'required|string',
        'image' => 'nullable|image|max:2048', // optional image validation
    ]);

    $data = $request->only(['item_name', 'price', 'category_id', 'availability_status']);

    // Handle image upload if exists
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('items', 'public');
        $data['image_url'] = $path;
    }

    // Assign the logged-in user as vendor
    $data['user_id'] = Auth::id();

    // Save the item
    Item::create($data);

    return redirect()->route('vendor.dashboard')
                     ->with('success', 'Item added to menu successfully!');
}

    /**
     * Show Edit Form
     */
    public function edit($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);
        $categories = Category::all();

        return view('vendor.edit-item', compact('item', 'categories'));
    }

    /**
     * Update Item
     */
    public function update(Request $request, $id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availability_status' => 'required|in:available,unavailable',
        ]);

        // Handle Image Update
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
            $item->image_url = $imagePath;
        }

        $item->update([
            'item_name' => $request->item_name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'availability_status' => $request->availability_status,
        ]);

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Item updated successfully!');
    }

    /**
     * Delete Item
     */
    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Item deleted successfully!');
    }
}