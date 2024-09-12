<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Trial;

class SubjectController extends Controller
{

    public function index(){

        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }


    public function list(){

        $subjects = Subject::all();
        return view('subjects', compact('subjects'));
    }

    public function showTrials($id){

        $trials = Trial::where('subject_id',$id)->get();
        return view('trials', compact('trials'));
    }

}
