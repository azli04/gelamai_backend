<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class RoleController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nm_role', 'like', "%$search%");
        }

        $roles = $query->paginate($request->get('per_page', 10));

        return $this->success($roles, 'Daftar role berhasil diambil');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_role' => 'required|string|max:50|unique:roles,nm_role',
        ]);

        $role = Role::create($request->only('nm_role'));

        return $this->success($role, 'Role berhasil dibuat', 201);
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return $this->success($role, 'Detail role berhasil diambil');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'nm_role' => 'required|string|max:50|unique:roles,nm_role,' . $id . ',id_role',
        ]);

        $role->update($request->only('nm_role'));

        return $this->success($role, 'Role berhasil diperbarui');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return $this->success(null, 'Role berhasil dihapus');
    }
}
