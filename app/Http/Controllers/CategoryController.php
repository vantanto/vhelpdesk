<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $pshow = is_numeric($request->pshow) ? $request->pshow : Helper::$PageItemShows[0];
        $categories = Category::orderBy('id', 'asc');

        if (!empty($request->search)) {
            $categories->where(
                fn ($query) =>
                $query->where('name', 'like', '%'.$request->search.'%')
            );
        }

        $categories = $categories->paginate($pshow);
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
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
            $category = new Category;
            $category->fill($request->only('name'));
            $category->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Category Successfully Created.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Category Failed Created.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $category->fill($request->only('name'));
            $category->save();
            DB::commit();
    
            return response()->json(['status' => 'success', 'message' => 'Category Successfully Updated.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Category Failed Updated.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category Successfully Deleted.');
    }
}
