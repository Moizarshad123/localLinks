<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->where('id','!=', 1)->orderByDESC('id')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            //code...
            User::create([
                "name"     => $request->name,
                "role_id"  => $request->role_id,
                "email"    => $request->email,
                "phone"    => $request->phone,
                "password" => Hash::make($request->password),
                "status"   => 1,
            ]);
            return redirect('admin/users')->with("success", "User created");
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
