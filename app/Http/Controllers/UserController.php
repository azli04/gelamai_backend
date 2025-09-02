<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponse;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->paginate($request->get('per_page', 10));

        return $this->success($users, 'Daftar user berhasil diambil');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'id_role' => 'required|exists:roles,id_role',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
        ]);

        return $this->success($user->load('role'), 'User berhasil dibuat', 201);
    }

    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        return $this->success($user, 'Detail user berhasil diambil');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'sometimes|min:6',
            'id_role' => 'sometimes|exists:roles,id_role',
        ]);

        $user->update([
            'nama' => $request->nama ?? $user->nama,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'id_role' => $request->id_role ?? $user->id_role,
        ]);

        return $this->success($user->load('role'), 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->success(null, 'User berhasil dihapus');
    }
}
