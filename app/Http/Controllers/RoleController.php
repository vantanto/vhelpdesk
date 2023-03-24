<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::get();
        return view('role.index', compact('roles'));
    }

    public function show(Request $request, $id)
    {
        $role = Role::with(['permissions', 'users'])->findOrFail($id);
        $permissions = Permission::orderBy('name')->get();
        return view('role.show', compact('role', 'permissions'));
    }
}
