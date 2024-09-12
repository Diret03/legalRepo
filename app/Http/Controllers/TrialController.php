<?php

namespace App\Http\Controllers;

use App\Models\Trial;
use Illuminate\Http\Request;

class TrialController extends Controller
{
    public function showTrials($id){

        $trials = Trial::where('subject_id',$id)->paginate(5);
        return view('trials', compact('trials'));
    }
}
