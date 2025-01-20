<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
        ]);
    
        DB::beginTransaction();
        try {
            User::create([
                'name'     => $request->name,
                'role'     => 'student',
                'email'    => $request->email,
                'password' => Hash::make('123456'), 
            ]);
    
            DB::commit();
            return redirect()->route('pages.page1')->with('msg', ['success', 'Student data has been stored successfully!']);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $msg = ['danger', $e->errorInfo[2]];
            return redirect()->route('pages.page1')->with(['msg'=>$msg]);
        }
    }
    

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }


    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
    
        DB::beginTransaction();
        try {
            User::find($id)->update([
                'name'     => $request->name,
                'email'    => $request->email,
            ]);
    
            DB::commit();
            return redirect()->route('pages.page1')->with('msg', ['success', 'Student data has been updated successfully!']);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $msg = ['danger', $e->errorInfo[2]];
            return redirect()->route('pages.page1')->with(['msg'=>$msg]);
        }
    }

    public function destroy(string $id)
    {
       User::findOrFail($id)->delete();
       return redirect()->route('pages.page1')->with('msg', ['danger', 'Student data has been deleted!']);


    }
}
