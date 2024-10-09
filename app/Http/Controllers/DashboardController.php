<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LegalCase;
use App\Models\Trial;
use App\Models\Subject;


class DashboardController extends Controller
{

    public function index(){

        $usersCount = User::count();
        $casesCount = LegalCase::count();
        $trialsCount = Trial::count();
        $subjectsCount = Subject::count();

        $cases =  LegalCase::with('user')->orderBy('updated_at', 'desc')->take(10)->get();

        return view('dashboard', compact('usersCount', 'casesCount', 'trialsCount', 'subjectsCount', 'cases'));
    }
}
