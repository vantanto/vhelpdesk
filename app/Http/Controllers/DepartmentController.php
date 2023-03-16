<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $pshow = is_numeric($request->pshow) ? $request->pshow : Helper::$PageItemShows[0];
        $departments = Department::orderBy('id', 'asc');

        if ($request->search != null) {
            $departments->where(
                fn ($query) =>
                $query->where('name', 'like', '%'.$request->search.'%')
            );
        }

        $departments = $departments->paginate($pshow);
        return view('department.index', compact('departments'));
    }

    public function create()
    {
        return view('department.create');
    }
    
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $department = new Department;
            $department->fill($request->only('name'));
            $department->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Department Successfully Created.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Department Failed Created.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        return view('department.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $department->fill($request->only('name'));
            $department->save();
            DB::commit();
    
            return response()->json(['status' => 'success', 'message' => 'Department Successfully Updated.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Department Failed Updated.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->back()->with('success', 'Department Successfully Deleted.');
    }
}
