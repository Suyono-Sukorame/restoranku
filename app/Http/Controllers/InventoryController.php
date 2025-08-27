<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::orderBy('name')->get();
        $lowStock = Inventory::where('status', 'low_stock')->orWhere('status', 'out_of_stock')->count();
        return view('admin.inventory.index', compact('inventories', 'lowStock'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0'
        ]);

        Inventory::create($request->all());
        return redirect()->route('inventories.index')->with('success', 'Item inventory berhasil ditambahkan.');
    }

    public function edit(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0'
        ]);

        $inventory->update($request->all());
        return redirect()->route('inventories.index')->with('success', 'Item inventory berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'Item inventory berhasil dihapus.');
    }

    public function restock(Request $request, Inventory $inventory)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $inventory->increment('current_stock', $request->quantity);
        return redirect()->route('inventories.index')->with('success', 'Stok berhasil ditambah.');
    }
}