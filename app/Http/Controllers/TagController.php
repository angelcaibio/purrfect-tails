<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index()
    {
        $tags = DB::table('tags')->orderBy('id')->paginate (10);
        return view('admin.tags', compact('tags', ));
    }

    public function create()
    {
        return view('admin.create.tag');
    }


    public function store(Request $request)
    {
        // Start a transaction
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            Tag::create([
                'name' => $request->name,
                'created_at' => now(),  
            ]);
            DB::commit();
            return redirect()->route('admin.tags')
                             ->with('success', 'Tag created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.tags')
                             ->with('error', 'An error occurred while creating the tag.');
        }
    }

    public function edit($id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return redirect()->route('admin.tags')
                             ->with('error', 'Tag not found!');
        }
        return view('admin.edit.tag', compact('tag'));
    }

 
    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            $tag = Tag::find($id);
            if (!$tag) {
                return redirect()->route('admin.tags')
                                 ->with('error', 'Tag not found!');
            }
            $tag->update([
                'name' => $request->name,
                'created_at' => now(), 
            ]);

            DB::commit();
            return redirect()->route('admin.tags')
                             ->with('success', 'Tag updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.tags')
                             ->with('error', 'An error occurred while updating the tag.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $tag = Tag::find($id);
            if (!$tag) {
                return redirect()->route('admin.tags')
                                 ->with('error', 'Tag not found!');
            }
            $tag->delete();
            DB::commit();

            return redirect()->route('admin.tags')
                             ->with('success', 'Tag deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.tags')
                             ->with('error', 'An error occurred while deleting the tag.');
        }
    }
}
