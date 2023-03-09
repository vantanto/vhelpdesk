<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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
        $users = User::orderBy('id', 'asc');

        if ($request->search != null) {
            $users->where(
                fn ($query) =>
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
            );
        }

        $users = $users->paginate($pshow);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }
    
    public function store(Request $request)
    {
        sleep(5);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => ['required', Password::defaults(), 'confirmed'],
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
            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'User Successfully Created.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => 'User Failed Created.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => ['nullable', Password::defaults(), 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $user->fill($request->only('name'));
            if($request->password != null) $user->password = Hash::make($request->password);
            $user->save();
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
