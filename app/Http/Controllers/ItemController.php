<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('category')->orderBy('name', 'asc')->get();
        return view('admin.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('cat_name', 'asc')->get();
        return view('admin.item.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'required|boolean',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $item = new Item();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category_id = $request->category_id;
        $item->is_active = $request->is_active;

        // Handle image upload
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img'), $filename);
            $item->img = $filename;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::orderBy('cat_name', 'asc')->get();
        return view('admin.item.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'required|boolean',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category_id = $request->category_id;
        $item->is_active = $request->is_active;

        // Handle image upload
        if ($request->hasFile('img')) {
            // Delete old image if exists
            if ($item->img && File::exists(public_path('assets/img/' . $item->img))) {
                File::delete(public_path('assets/img/' . $item->img));
            }
            $image = $request->file('img');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img'), $filename);
            $item->img = $filename;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Menu berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Item::withTrashed()->findOrFail($id);

        // hapus gambar dulu
        if ($item->img && File::exists(public_path('assets/img/' . $item->img))) {
            File::delete(public_path('assets/img/' . $item->img));
        }

        $item->forceDelete(); // hapus permanen
        return redirect()->route('items.index')->with('success', 'Menu berhasil dihapus permanen.');
    }
}
