<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Trial;
use App\Models\LegalCase;
use Spatie\Tags\Tag;
class CaseController extends Controller
{

    public function index(Request $request){

        $sortField = $request->query('sort', 'created_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $cases = LegalCase::orderBy($sortField, $sortDirection)->paginate(10);
        $trials = Trial::all();
        return view('cases.index', compact('cases','trials'));
    }

    public function store(Request $request){

        $validated_data = $request->validate([
            'title' => 'required|alpha:ascii',
            'trial_id' => 'required|exists:trials,id',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        $trial = Trial::create([
            'title' => $validated_data['title'],
            'trial_id' => $validated_data['trial_id'],
            'description' => $validated_data['description'],
        ]);

        return redirect()->back()->with('success', 'Juicio creado exitosamente.');

    }


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

    public function destroy($id)
    {
        $case = LegalCase::findOrFail($id);
        $case->delete();

        return redirect()->back()->with('success', 'Caso eliminado exitosamente.');
    }

}
