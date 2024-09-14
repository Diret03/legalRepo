<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Trial;
use Illuminate\Http\Request;

class TrialController extends Controller
{
    public function showTrials($id){

        $trials = Trial::where('subject_id',$id)->paginate(5);
//        $subject = Subject::find($id);
        $subject = Subject::where('id',$id)->first();
        $subject_name = $subject->name;
        return view('trials', compact('trials','subject','subject_name'));
    }
}
