<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->orderBy('id')->paginate (5);
        return view('admin.categories', compact('categories', ));
    }

    public function create()
    {
        return view('admin.create.category');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            Category::create([
                'name' => $request->name,
                'created_at' => now(),  
            ]);
            DB::commit();
            return redirect()->route('admin.categories')
                             ->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.categories')
                             ->with('error', 'An error occurred while creating the category.');
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.categories')
                             ->with('error', 'Category not found!');
        }
        return view('admin.edit.category', compact('category'));
    }

 
    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.categories')
                                 ->with('error', 'Category not found!');
            }
            $category->update([
                'name' => $request->name,
                'created_at' => now(), 
            ]);

            DB::commit();
            return redirect()->route('admin.categories')
                             ->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.categories')
                             ->with('error', 'An error occurred while updating the category.');
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.categories')
                                 ->with('error', 'Category not found!');
            }
            $category->delete();
            DB::commit();

            return redirect()->route('admin.categories')
                             ->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.categories')
                             ->with('error', 'An error occurred while deleting the category.');
        }
    }
}
