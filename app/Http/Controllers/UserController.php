<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('users.index', ['users' => $users]);
    }

    public function create()
    {
      
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'required|min:8|confirmed',
           'status' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'status' => $request->status
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User success create');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'confirmed',
            'status' => 'required'
         ]);

         $user = User::find($id);
         $password = $request->password == '' ? $user->password : $request->password;

         $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $password,
            'status' => $request->status
         ]);

         $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User success update');
    }

    public function changePassword()
    {
        return view('users.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8'
        ]);

        $email = Auth::user()->email;
        $user = User::where('email', $email)->first();

        $password = $request->password;

        if($password === null)
        {
            $password = $user->password;
        }else{
            $password = bcrypt($password);
        }

        $user->update([
            'password' => $password
        ]);

        return redirect()->back()->with('success', 'Password success update');
    }

    public function changeProfile()
    {
        $email = Auth::user()->email;
        $user = User::where('email', $email)->first();

        return view('users.change-profile', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $email = Auth::user()->email;
        $user = User::where('email', $email)->first();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil update success!');
    }
}
