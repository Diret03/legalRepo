<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trial;
use App\Models\LegalCase;
use Spatie\Tags\Tag;
class CaseController extends Controller
{
    public function showCasesbyTrial($trial_id){

        $cases = LegalCase::where('trial_id',$trial_id)->paginate(5);
        $trial = Trial::where('id',$trial_id)->first();
        $trial_name = $trial->name;
        return view('cases.byTrial', compact('cases','trial','trial_name'));
    }

    public function showAll($id){

        $case = LegalCase::where('id', $id)->first();
        $accessedBy = 'all';
        return view('cases.show', compact('case','accessedBy'));

    }

    public function showCaseByTrial($id){

        $case = LegalCase::where('id', $id)->first();
        $accessedBy = 'trial';
        return view('cases.show', compact('case', 'accessedBy'));

    }

    public function showCaseByTag($id, $tag)
    {
        $case = LegalCase::findOrFail($id);
        $accessedBy = 'tag';
//        dd($tag);
        return view('cases.show', compact('case', 'tag', 'accessedBy'));
    }

    public function list(){
        $cases = LegalCase::paginate(10);
        return view('cases.list',compact('cases'));
    }

    public function showByTag($id){

        $tag = Tag::where('id', $id)->first();
        $tag_name = $tag->name;
        $cases = LegalCase::withAnyTags([$tag_name])->paginate(10);

        return view('cases.byTag', compact('cases','tag','tag_name'));
    }

}
