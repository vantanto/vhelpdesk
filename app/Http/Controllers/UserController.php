<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $pshow = is_numeric($request->pshow) ? $request->pshow : Helper::$PageItemShows[0];
        $users = User::with('departments')->orderBy('id', 'asc');
        $departments = Department::all();

        if ($request->search != null) {
            $users->where(
                fn ($query) =>
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
            );
        }
        if ($request->department != null) {
            $users->whereHas(
                'departments',
                fn ($query) => $query->where('departments.id', $request->department)
            );
        }

        $users = $users->paginate($pshow);
        return view('user.index', compact('users', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('user.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => ['required', Password::defaults(), 'confirmed'],
            'departments.*' => 'nullable|distinct|exists:departments,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $user = new User;
            $user->fill($request->only('name', 'email'));
            $user->email_verified_at = now();
            $user->password = Hash::make($request->password);
            $user->save();

            if ($request->departments != null) $user->departments()->attach($request->departments);

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'User Successfully Created.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => 'User Failed Created.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function detail(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            return response()->json(['status' => 'success', 'msg' => 'Data Found.', 'data' => $user]);
        }
        return response()->json(['status' => 'error', 'msg' => 'No Data Found.'], 404);
    }

    public function edit(Request $request, $id)
    {
        $user = User::with('departments')->findOrFail($id);
        $departments = Department::all();
        return view('user.edit', compact('user', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => ['nullable', Password::defaults(), 'confirmed'],
            'departments.*' => 'nullable|distinct|exists:departments,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $user->fill($request->only('name'));
            if ($request->password != null) $user->password = Hash::make($request->password);
            $user->save();

            $user->departments()->sync($request->departments);

            DB::commit();

            return response()->json(['status' => 'success', 'msg' => 'User Successfully Updated.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => 'User Failed Updated.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Successfully Deleted.');
    }
}
