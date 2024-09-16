<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        $users = User::all();
        return view('users', compact('users'));
    }

    public function store(Request $request){

        $validated_data = $request->validate([
            'name' => 'required|alpha:ascii',
            'last_name' => 'required|alpha:ascii',
            'email' =>  ['required', 'unique:users', 'max:255', 'email'],
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated_data['name'],
            'last_name' => $validated_data['last_name'],
            'email' => $validated_data['email'],
            'password' => Hash::make($validated_data['password']),
        ]);

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');

    }
}
