<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('role_name', 'asc')->get();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,role_name|max:50',
            'description' => 'required|max:255',
        ]);

        Role::create([
            'role_name' => $request->role_name,
            'description' => $request->description,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Validasi input
        $request->validate([
            'role_name' => 'required|max:50|unique:roles,role_name,' . $role->id,
            'description' => 'required|max:255',
        ]);

        $role->update([
            'role_name' => $request->role_name,
            'description' => $request->description,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete(); // soft delete jika Role model menggunakan SoftDeletes
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
