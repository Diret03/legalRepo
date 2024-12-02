<?php

namespace App\Policies;

use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CasePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user){
        return $user->can('ver casos');
    }

    public function view(?User $user, LegalCase $case){
//        return ($case->status !== 'Aceptado' && !Auth::check()) || (!$case->user->status && !Auth::user()->can('revisar casos'));

        return $case->status == 'Aceptado' || $user?->id === $case->user_id || $user?->can('revisar casos');
    }

    public function create(User $user) :bool
    {
        return $user->can('crear casos');
    }

    public function update(User $user, LegalCase $case){
        return $user->id === $case->user_id && $case->status !== 'Aceptado';
    }

    public function delete(User $user, LegalCase $case){
        return $user->id === $case->user_id;
    }

    public function viewMyCases(User $user){

        return $user->can('ver casos propios');
    }

    public function review(User $user){
        return $user->can('revisar casos');
    }

    public function approve(User $user, LegalCase $case){
        return $user->can('aprobar casos') && $case->status !== 'Aceptado';
    }

    public function reject(User $user, LegalCase $case){
        return $user->can('rechazar casos') && $case->status !== 'Rechazado';
    }

    public function viewArchived(User $user) :bool
    {
        return $user->can('ver casos archivados');
    }

    public function restore(User $user, LegalCase $case){
        return $user->can('restaurar casos') && $case->trashed();
    }

    public function forceDelete(User $user, LegalCase $case){
        return $user->can('eliminar casos definitivamente') && $case->trashed();
    }


}
