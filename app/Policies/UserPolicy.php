<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user){
        return $user->can('ver usuarios');
    }

    public function create(){
        return Auth::user()->can('crear usuarios');
    }

    public function edit(){
        return Auth::user()->can('editar usuarios');
    }

    public function delete(){
        return Auth::user()->can('eliminar usuarios');
    }

    public function activate(){
        return Auth::user()->can('activar usuarios');
    }

    public function deactivate(){
        return Auth::user()->can('desactivar usuarios');
    }
}
