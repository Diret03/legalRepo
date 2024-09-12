<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trial;
use App\Models\LegalCase;
class CaseController extends Controller
{
    public function showCasesbyTrial($trial_id){

        $cases = LegalCase::where('trial_id',$trial_id)->paginate(5);
        return view('cases.byTrial', compact('cases'));
    }

    public function show($id){

        $case = LegalCase::where('id', $id)->first();
        return view('cases.show', compact('case'));

    }
}
