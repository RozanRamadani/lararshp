<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = Role::withCount('users')->get();
        
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_role' => 'required|string|max:255|unique:role,nama_role',
        ]);

        Role::create($validated);

        return redirect()
            ->route('admin.role.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        $role->load(['users']);
        
        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'nama_role' => 'required|string|max:255|unique:role,nama_role,' . $role->idrole . ',idrole',
        ]);

        $role->update($validated);

        return redirect()
            ->route('admin.role.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        // Check if role has users
        if ($role->users()->exists()) {
            return redirect()
                ->route('admin.role.index')
                ->with('error', 'Tidak dapat menghapus role yang masih memiliki users.');
        }

        $role->delete();

        return redirect()
            ->route('admin.role.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
