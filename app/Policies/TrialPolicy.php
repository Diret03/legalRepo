<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TrialPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user){
        return $user->can('ver juicios');
    }

    public function create(){
        return Auth::user()->can('crear juicios');
    }

    public function edit(){
        return Auth::user()->can('editar juicios');
    }

    public function delete(){
        return Auth::user()->can('eliminar juicios');
    }
}
