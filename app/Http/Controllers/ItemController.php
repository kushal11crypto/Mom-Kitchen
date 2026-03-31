<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{

    public function index()
    {
        // Load items along with their category to avoid N+1 query
        $items = Item::with('categories')->get();

        return view('items.index', compact('items'));
    }
    /**
     * Vendor Dashboard
     */
    public function dashboard()
    {
        $items = Item::with('category') // ✅ eager loading
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('vendor.dashboard', compact('items'));
    }

    /**
     * Show Create FormÏ
     */
    public function create()
    {
        $categories = Category::all();
        return view('vendor.create-item', compact('categories'));
    }
     /**
     * store new
     */

    public function store(Request $request)
    {
        $request->validate([
    'item_name' => 'required|string|max:255',
    'price' => 'required|numeric',
    'category_id' => 'required|exists:categories,id',
    'image' => 'nullable|image|max:5120',
    'availability_status' => 'required|in:available,unavailable',
], [
    'image.max' => 'The image must not be larger than 5MB.',
    'image.image' => 'The uploaded file must be an image (JPG, PNG).',
]);

        $item = new Item();
        $item->item_name = $request->item_name;
        $item->price = $request->price;
        $item->category_id = $request->category_id;
        $item->availability_status = $request->availability_status;

        $item->user_id = Auth::id(); 
        if ($request->hasFile('image')) {
    $file = $request->file('image');

    if (!$file->isValid()) {
        dd($file->getError(), $file->getErrorMessage());
    }

    $imagePath = $file->store('items', 'public');
    $item->image_url = $imagePath;
}

        $item->save();

        return redirect()->route('vendor.dashboard')->with('success', 'Item created successfully!');
    }

    public function menu()
{
    $items = Item::where('availability_status', 'available')
        ->latest()
        ->get();

    return view('customer.menu', compact('items'));
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
            'availability_status' => 'required|in:available,unavailable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'item_name',
            'price',
            'category_id',
            'availability_status'
        ]);

        // ✅ Handle Image Update
        if ($request->hasFile('image')) {

            // 🔴 Delete old image if exists
            if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                Storage::disk('public')->delete($item->image_url);
            }

            // ✅ Save new image
            $data['image_url'] = $request->file('image')->store('items', 'public');
        }

        $item->update($data);

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Item updated successfully!');
    }

    /**
     * Delete Item
     */
    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);

        // 🔴 Delete image from storage
        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }

        $item->delete();

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Item deleted successfully!');
    }
}