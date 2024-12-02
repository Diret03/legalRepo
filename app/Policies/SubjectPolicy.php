<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubjectPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user){
        return $user->can('ver materias');
    }

    public function create(){
        return Auth::user()->can('crear materias');
    }

    public function edit(){
        return Auth::user()->can('editar materias');
    }

    public function delete(){
        return Auth::user()->can('eliminar materias');
    }
}
