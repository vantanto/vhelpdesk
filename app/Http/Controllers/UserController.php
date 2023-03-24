<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $pshow = is_numeric($request->pshow) ? $request->pshow : Helper::$PageItemShows[0];
        $users = User::with(['departments', 'roles'])->orderBy('id', 'asc');
        $departments = Department::all();
        $roles = Role::all();

        if (!empty($request->search)) {
            $users->where(
                fn ($query) =>
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
            );
        }
        if (!empty($request->department)) {
            $users->whereHas(
                'departments',
                fn ($query) => $query->where('departments.id', $request->department)
            );
        }
        if (!empty($request->role)) {
            $users->whereHas(
                'roles', 
                fn ($query) => $query->where('roles.id', $request->role)
            );
        }

        $users = $users->paginate($pshow);
        return view('user.index', compact('users', 'departments', 'roles'));
    }

    public function create()
    {
        $departments = Department::all();
        $roles = Role::where('id', '!=', 1)->get();
        return view('user.create', compact('departments', 'roles'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => ['required', Password::defaults(), 'confirmed'],
            'role' => ['required', 'not_in:1', 'exists:roles,id'],
            'departments.*' => 'nullable|distinct|exists:departments,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $user = new User;
            $user->fill($request->only('name', 'email'));
            $user->email_verified_at = now();
            $user->password = Hash::make($request->password);
            $user->save();

            $user->departments()->sync($request->departments);
            $user->syncRoles($request->role);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'User Successfully Created.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'User Failed Created.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function detail(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            return response()->json(['status' => 'success', 'message' => 'Data Found.', 'data' => $user]);
        }
        return response()->json(['status' => 'error', 'message' => 'No Data Found.'], 404);
    }

    public function show(Request $request, $id)
    {
        $user = User::with(['departments', 'roles.permissions', 'permissions'])->findOrFail($id);
        $permissions = Permission::orderBy('name')->get();
        return view('user.show', compact('user', 'permissions'));
    }

    public function edit(Request $request, $id)
    {
        $user = User::with(['departments', 'roles'])->findOrFail($id);
        $departments = Department::all();
        $roles = Role::where('id', '!=', 1)
            ->orWhereIn('id', $user->roles->pluck('id')->toArray())
            ->get();
        return view('user.edit', compact('user', 'departments', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => ['nullable', Password::defaults(), 'confirmed'],
            'role' => [Rule::excludeIf(boolval($user->role_id)), 'required', 'not_in:1', 'exists:roles,id'],
            'departments.*' => 'nullable|distinct|exists:departments,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $user->fill($request->only('name'));
            if (!empty($request->password)) $user->password = Hash::make($request->password);
            $user->save();

            $user->departments()->sync($request->departments);
            $user->syncRoles($request->role);

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'User Successfully Updated.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'User Failed Updated.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Successfully Deleted.');
    }

    public function permissionsUpdate(Request $request, $id)
    {
        $user = User::with(['permissions'])->findOrFail($id);
        $validator = \Validator::make($request->all(), [
            'permissions.*' => [
                'nullable', 
                'exists:permissions,id', 
                Rule::when($user->role_id, [Rule::notIn($user->roles[0]->permissions->pluck('id')->toArray())])
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {

            $user->syncPermissions($request->permissions);
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'User Special Permission Successfully Updated.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'User Special Permission Failed Updated.', 'data' => $ex->getMessage()], 500);
        }
    }
}
