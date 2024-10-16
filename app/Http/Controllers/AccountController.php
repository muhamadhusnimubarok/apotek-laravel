<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate;

class AccountController extends Controller
{
    public function index() {
        $users = User::all();
        return view('account.index', compact('users'));
    }
    


    public function create() {
        return view('account.create');
    }
    
    public function store(Request $request) {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required',
        ]);
    
        
        $email = substr($request->email, 0, 3);
        $nama = substr($request->name, 0, 3); 
        $generatedPassword = $email . $nama; 
    
     
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($generatedPassword), 
            'role' => $request->role,
        ]);
    
        return redirect()->route('account.index')->with('success', 'Akun berhasil ditambahkan dengan password: ' . $generatedPassword);
    }
    


    public function edit($id) {
        $account = User::findOrFail($id);
        return view('account.edit', compact('account'));
    }
    
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,member',
            'password' => ''
        ]);
    
        $account = User::findOrFail($id);
        $account->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password'=> bcrypt($request->password)
        ]);
    
        return redirect()->route('account.index')->with('success', 'Akun berhasil diupdate');
    }
    

    public function destroy($id) {
        User::findOrFail($id)->delete();
        return redirect()->route('account.index')->with('success', 'Akun berhasil dihapus');
    }
}

