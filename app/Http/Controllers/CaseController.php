<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Trial;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Tags\Tag;

class CaseController extends Controller
{

    public function index(Request $request){

        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $cases = LegalCase::orderBy($sortField, $sortDirection)->paginate(10);
        $trials = Trial::all();
        return view('cases.index', compact('cases','trials'));
    }

    public function create(){
        $trials = Trial::all();
        $users = User::orderBy('last_name','asc')->get();
        return view('cases.create',compact('trials','users'));
    }

    public function store(Request $request){

        $validated_data = $request->validate([
            'title' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'trial_id' => 'required|exists:trials,id',
            'date' => 'required|date',
            'origin' => 'required|string',
            'status' => 'required|string|in:pending,accepted,rejected',
            'context' => 'required|string',
            'analysis' => 'required|string',
            'resolution' => 'required|string',
            'note' => 'nullable|string',
            'tags' => 'nullable'
        ]);

        // Use null coalescing to check if 'user_id' exists in $validated_data
        $user_id = $validated_data['user_id'] ?? Auth::user()->id;
        $isAdmin = isset($validated_data['user_id']); // Admin if 'user_id' was explicitly set

        $case = LegalCase::create([
            'title' => $validated_data['title'],
            'user_id' => $user_id,
            'trial_id' => $validated_data['trial_id'],
            'date' => $validated_data['date'],
            'origin' => $validated_data['origin'],
            'status' => $validated_data['status'],
            'context' => $validated_data['context'],
            'analysis' => $validated_data['analysis'],
            'resolution' => $validated_data['resolution'],
        ]);

        if (!empty($validated_data['note'])) {
            $case->note = $validated_data['note'];
            $case->save(); // Save the updated note to the case
        }

        if (!empty($validated_data['tags'])) {
            $tags = json_decode($validated_data['tags']);
            if (!empty($tags)) {
                $case->syncTags($tags);
            }
        }

        if (!$isAdmin) {
            return redirect()->route('cases.mycases', Auth::user()->id)->with('success', 'Juicio subido exitosamente, espera a que sea aprobado.');
        }

        return redirect()->route('cases.index')->with('success', 'Juicio creado exitosamente.');
    }


    public function edit($id){

        $case = LegalCase::findOrFail($id);
        $trials = Trial::all();
        $users = User::orderBy('last_name','asc')->get();
        return view('cases.edit', compact('case','trials', 'users'));
    }

    public function update(Request $request, $id) {
        $validated_data = $request->validate([
            'title' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'trial_id' => 'required|exists:trials,id',
            'date' => 'required|date',
            'origin' => 'required|string',
            'status' => 'required|string|in:pending,accepted,rejected',
            'context' => 'required|string',
            'analysis' => 'required|string',
            'resolution' => 'required|string',
            'note' => 'nullable|string',
            'tags' => 'nullable'
        ]);

        $case = LegalCase::findOrFail($id);
        $case->update([
            'title' => $validated_data['title'],
            'user_id' => $validated_data['user_id'],
            'trial_id' => $validated_data['trial_id'],
            'date' => $validated_data['date'],
            'origin' => $validated_data['origin'],
            'status' => $validated_data['status'],
            'context' => $validated_data['context'],
            'analysis' => $validated_data['analysis'],
            'resolution' => $validated_data['resolution'],
            'note' => $validated_data['note'],
        ]);

        if (!empty($validated_data['note'])) {
            $case->note = $validated_data['note'];
            $case->save();
        }

        if (!empty($validated_data['tags'])) {
            $tags = json_decode($validated_data['tags']);
            if (!empty($tags)) {
                $case->syncTags($tags);
            }
        }


        return redirect()->route('cases.index')->with('success', 'Juicio actualizado exitosamente.');
    }



    public function search(Request $request){

        if($request->ajax()){
            $query = $request->input('search');
            $view = $request->input('view');

            if ($query != '') {
                $dbDriver = DB::getDriverName();

                // Use ILIKE for PostgreSQL and LIKE for others
                $likeOperator = $dbDriver === 'pgsql' ? 'ILIKE' : 'LIKE';

                // Perform search query
                $cases = LegalCase::where('id', $likeOperator, '%' . $query . '%')
                    ->orWhere('title', $likeOperator, '%' . $query . '%')
                    ->orWhere('origin', $likeOperator, '%' . $query . '%')
                    ->orWhere('date', $likeOperator, '%' . $query . '%')
                    ->orWhereHas('trial', function ($queryBuilder) use ($query, $likeOperator) {
                        $queryBuilder->where('name', $likeOperator, '%' . $query . '%')
                            ->orWhereHas('subject', function ($subjectQuery) use ($query, $likeOperator) {
                                $subjectQuery->where('name', $likeOperator, '%' . $query . '%');
                            });
                    })
                    ->get();

            } else {

                $cases = LegalCase::paginate(10);
            }


            if (count($cases) > 0) {

                if($view == 'table'){
                    $output = view('cases.partials.row', ['cases' => $cases])->render();
                }
                elseif($view == 'mycases'){
                    $output = view('cases.partials.mylist', ['cases' => $cases])->render();
                }
                elseif($view == 'review'){
                    $output = view('cases.partials.reviewlist', ['cases' => $cases])->render();
                }


            } else {


                if($view == 'table'){
                    $output = '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                               <td colspan="8" class="px-6 py-12 font-bold text-2xl text-center">No se encontraron resultados</td>
                           </tr>';
                }
                else {
                    $output =
                        '<div
                        class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div> No se encontraron resultados</div>

                    </div>';
                }
            }

            return $output;
        }
    }

    public function getAllTags(){
        $orderedTags = Tag::all();
        return response()->json(['tags' => $orderedTags->pluck('name')]);
    }

    public function getTags($id){
        $case = LegalCase::findOrFail($id);
        $tags = [];

        foreach ($case->tags as $tag){

            $tags[] = [
                'id' =>$tag->name,
                'name'=>$tag->name
            ];
        }
        return response()->json(['tags' => $tags]);
    }


    public function showCasesbyTrial($trial_id){

        $cases = LegalCase::where('trial_id',$trial_id)
            ->where('status','accepted')
            ->paginate(5);
        $trial = Trial::where('id',$trial_id)->first();
        $trial_name = $trial->name;
        return view('cases.byTrial', compact('cases','trial','trial_name'));
    }

    public function show($id){

        $case = LegalCase::where('id', $id)->first();
        $accessedBy = 'all';

        // Only allow public access if the case is 'accepted'
//        dd(Auth::check());
//        dd($case->status);
        if ($case->status !== 'Aceptado' && !Auth::check()) {
            abort(404); // Show 404 for unauthorized users
        }

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
        $cases = LegalCase::where('status','accepted')
                ->paginate(10);
        return view('cases.list',compact('cases'));
    }


    public function listUser(){
        $cases = LegalCase::paginate(10);
        return view('cases.list',compact('cases'));
    }

    public function review(Request $request){
        $status = $request->query('status', 'pending'); // default sort field

        $cases = LegalCase::where('status',$status)
            ->orderBy('updated_at', 'desc')->paginate(12);

        if($status == 'all'){
            $cases = LegalCase::orderBy('updated_at', 'desc')->paginate(12);
        }

        return view('cases.review', compact('cases'));
    }

    public function approve($id){
        $case = LegalCase::findOrFail($id);

        $case->status = 'accepted';
        $case->save();

        return redirect()->route('cases.review');
    }

    public function myCases(Request $request, $user_id){

        $status = $request->query('status', 'accepted'); // default sort field

        $cases = LegalCase::where('user_id',$user_id)
            ->where('status',$status)
            ->orderBy('updated_at', 'desc')->paginate(12);

        if($status == 'all'){
            $cases = LegalCase::where('user_id',$user_id)
            ->orderBy('updated_at', 'desc')->paginate(12);
        }

        return view('cases.mycases', compact('cases'));
    }

    public function reject($id){
        $case = LegalCase::findOrFail($id);

        $case->status = 'rejected';
        $case->save();

        return redirect()->route('cases.review');
    }
    public function showByTag($id){

        $tag = Tag::where('id', $id)->first();
        $tag_name = $tag->name;
        $cases = LegalCase::withAnyTags([$tag_name])
            ->where('status','accepted')
            ->paginate(10);

        return view('cases.byTag', compact('cases','tag','tag_name'));
    }

    public function deleteSelected(Request $request){
        $ids = $request->ids;
        LegalCase::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Casos eliminados correctamente.']);

    }

    public function destroy($id)
    {
        $case = LegalCase::findOrFail($id);
        $case->delete();

        return redirect()->back()->with('success', 'Caso eliminado exitosamente.');
    }

}
