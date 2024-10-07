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
use App\Notifications\CaseAccepted;
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

    public function archived(Request $request){
        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $cases = LegalCase::onlyTrashed()
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);
        return view('cases.archived', compact('cases'));
    }

    public function create(){
        $trials = Trial::all();
        $users = User::orderBy('last_name','asc')
                ->where('status',true)->get();
        return view('cases.create',compact('trials','users'));
    }

    public function store(Request $request){

        $validated_data = $request->validate([
            'title' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'trial_id' => 'required|exists:trials,id',
            'date' => 'required|date',
            'origin' => 'required|string',
            'status' => 'nullable|string|in:pending,accepted,rejected',
            'context' => 'required|string',
            'analysis' => 'required|string',
            'resolution' => 'required|string',
            'note' => 'nullable|string',
            'tags' => 'nullable'
        ],[
            'context.required' => 'El campo contexto es obligatorio.',
            'analysis.required' => 'El campo de análisis jurídico es obligatorio.',
            'resolution.required' => 'El campo de resolución es obligatorio.',
        ]);

        // null coalescing to check if 'user_id' exists in $validated_data
        $user_id = $validated_data['user_id'] ?? Auth::user()->id;
        $isAdmin = isset($validated_data['user_id']); // Admin if 'user_id' was explicitly set

        $status = $validated_data['status'] ?? 'pending';

        $case = LegalCase::create([
            'title' => $validated_data['title'],
            'user_id' => $user_id,
            'trial_id' => $validated_data['trial_id'],
            'date' => $validated_data['date'],
            'origin' => $validated_data['origin'],
            'status' => $status,
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
            return redirect()->route('cases.mycases', ['user_id' => Auth::user()->id, 'status' => 'pending'])->with('success', 'Juicio subido exitosamente, espera a que sea aprobado.');
        }

        return redirect()->route('cases.index')->with('success', 'Juicio creado exitosamente.');
    }


    public function edit($id){

        $case = LegalCase::findOrFail($id);
        $trials = Trial::all();
        $users = User::orderBy('last_name','asc')
                ->where('status',true)->get();
        return view('cases.edit', compact('case','trials', 'users'));
    }

    public function update(Request $request, $id) {
        $validated_data = $request->validate([
            'title' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'trial_id' => 'required|exists:trials,id',
            'date' => 'required|date',
            'origin' => 'required|string',
            'status' => 'nullable|string|in:pending,accepted,rejected',
            'context' => 'required|string',
            'analysis' => 'required|string',
            'resolution' => 'required|string',
            'note' => 'nullable|string',
            'tags' => 'nullable'
        ],[
            'context.required' => 'El campo contexto es obligatorio.',
            'analysis.required' => 'El campo de análisis jurídico es obligatorio.',
            'resolution.required' => 'El campo de resolución es obligatorio.',
        ]);

        // null coalescing to check if 'user_id' exists in $validated_data
        $user_id = $validated_data['user_id'] ?? Auth::user()->id;
        $isAdmin = isset($validated_data['user_id']); // Admin if 'user_id' was explicitly set
        $status = $validated_data['status'] ?? 'pending';

        $case = LegalCase::findOrFail($id);
        $case->update([
            'title' => $validated_data['title'],
            'user_id' => $user_id,
            'trial_id' => $validated_data['trial_id'],
            'date' => $validated_data['date'],
            'origin' => $validated_data['origin'],
            'status' => $status,
            'context' => $validated_data['context'],
            'analysis' => $validated_data['analysis'],
            'resolution' => $validated_data['resolution'],
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

        if (!$isAdmin) {
            return redirect()->route('cases.mycases', ['user_id' => Auth::user()->id, 'status' => 'pending'])->with('success', 'Juicio actualizado exitosamente, espera a que sea aprobado.');
        }

        return redirect()->route('cases.index')->with('success', 'Juicio actualizado exitosamente.');
    }

    public function filter(Request $request)
    {
        $output = null;

        if ($request->ajax()) {
            // Start the query
            $query = LegalCase::query()->where('status', 'accepted');

            // Apply the filters if they exist
            if ($request->has('subject_ids') && !empty($request->input('subject_ids'))) {
                // Filter cases where the trial is related to the subject
                $query->whereHas('trial.subject', function ($subjectQuery) use ($request) {
                    $subjectQuery->whereIn('id', $request->input('subject_ids'));
                });
            }

            if ($request->has('trial_ids') && !empty($request->input('trial_ids'))) {
                $query->whereIn('trial_id', $request->input('trial_ids'));
            }



            // Get the results
            $cases = $query->get();

            if (count($cases) > 0) {
                // Render the view with the retrieved data
                $output = view('cases.partials.all-list', ['cases' => $cases])->render();
            }
            else{
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


    public function search(Request $request){

        if($request->ajax()){
            $query = $request->input('search');
            $view = $request->input('view');

            if ($query != '') {
                $dbDriver = DB::getDriverName();

                // Use ILIKE for PostgreSQL and LIKE for others
                $likeOperator = $dbDriver === 'pgsql' ? 'ILIKE' : 'LIKE';

                // Perform search query
                if($view == 'mycases'){
                    $cases = LegalCase::where('user_id', Auth::id()) // Mandatory condition
                    ->where(function ($queryBuilder) use ($query, $likeOperator) {
                        $queryBuilder->where('title', $likeOperator, '%' . $query . '%')
                            ->orWhere('origin', $likeOperator, '%' . $query . '%')
                            ->orWhere('date', $likeOperator, '%' . $query . '%')
                            ->orWhereHas('trial', function ($trialQuery) use ($query, $likeOperator) {
                                $trialQuery->where('name', $likeOperator, '%' . $query . '%')
                                    ->orWhereHas('subject', function ($subjectQuery) use ($query, $likeOperator) {
                                        $subjectQuery->where('name', $likeOperator, '%' . $query . '%');
                                    });
                            });
                    })
                        ->get();
                }
                elseif ($view == 'all-list') {
                    $cases = LegalCase::where('status', 'accepted') // Mandatory condition
                    ->where(function ($queryBuilder) use ($query, $likeOperator) {
                        $queryBuilder->where('title', $likeOperator, '%' . $query . '%')
                            ->orWhere('origin', $likeOperator, '%' . $query . '%')
                            ->orWhere('date', $likeOperator, '%' . $query . '%')
                            ->orWhereHas('trial', function ($trialQuery) use ($query, $likeOperator) {
                                $trialQuery->where('name', $likeOperator, '%' . $query . '%')
                                    ->orWhereHas('subject', function ($subjectQuery) use ($query, $likeOperator) {
                                        $subjectQuery->where('name', $likeOperator, '%' . $query . '%');
                                    });
                            });
                    })
                        ->get();
                }
                else{
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
                }
            } else {
                if($view == 'table'){
                    $cases = LegalCase::paginate(10);
                }
                elseif($view == 'mycases'){

                    $user_id = $request->input('user_id');
                    $status = $request->input('status');

                    if($status != 'all'){
                        $cases = LegalCase::where('user_id',$user_id)
                            ->where('status',$status)
                            ->orderBy('updated_at', 'desc')->paginate(12);
                    }
                    else{
                        $cases = LegalCase::where('user_id',$user_id)
                            ->orderBy('updated_at', 'desc')->paginate(12);
                    }
                }
                elseif($view == 'review'){
                    $cases = LegalCase::orderBy('updated_at', 'desc')->paginate(12);
                }
                elseif($view == 'all-list'){
                    $cases = LegalCase::where('status','accepted')
                        ->paginate(10);
                }

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
                elseif($view == 'all-list'){
                    $output = view('cases.partials.all-list', ['cases' => $cases])->render();
                }


            } else {


                if($view == 'table'){
                    $output = '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                               <td colspan="10" class="px-6 py-12 font-bold text-2xl text-center">No se encontraron resultados</td>
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
        $trial = Trial::findOrFail($trial_id);
        $trial_name = $trial->name;
        return view('cases.byTrial', compact('cases','trial','trial_name'));
    }

    public function show($id){

        $case = LegalCase::findOrFail($id);
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

        $case = LegalCase::findOrFail($id);
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

        $trials = Trial::withCount(['cases' => function($query) {
            $query->where('status', 'accepted');
        }])->orderBy('name', 'asc')->get();

        // Get subjects along with the count of accepted cases via trials
        $subjects = Subject::with(['trials' => function($query) {
            $query->withCount(['cases' => function ($caseQuery) {
                $caseQuery->where('status', 'accepted');
            }]);
        }])->get();

        // Add a 'cases_count' attribute to each subject by summing the cases of its related trials
        foreach ($subjects as $subject) {
            $subject->cases_count = $subject->trials->sum('cases_count');
        }

//        $subjects = Subject::all();

        // Return the data to the view
        return view('cases.list', compact('cases', 'trials', 'subjects'));
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

        $user = User::findOrFail($case->user_id);
        $user->notify(new CaseAccepted($case));

        return redirect()->route('cases.review')->with('success', "Juicio ".$id." aprobado correctamente.");
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

        if ($user_id != Auth::id()) {
            abort(404); // Show 404 for unauthorized users
        }

        return view('cases.mycases', compact('cases'));
    }

    public function reject(Request $request, $id){
        $case = LegalCase::findOrFail($id);

        $validated_data = $request->validate([
            'rejection_message' => 'required|string'
        ]);

        $case->rejection_message = $validated_data['rejection_message'];
        $case->status = 'rejected';
        $case->save();

        $user = User::findOrFail($case->user_id);
        $user->notify(new CaseAccepted($case));

        return redirect()->route('cases.review')->with('success', "Juicio ".$id." rechazado correctamente.");
    }
    public function showByTag($id){

        $tag = Tag::findOrFail($id);
        $tag_name = $tag->name;
        $cases = LegalCase::withAnyTags([$tag_name])
            ->where('status','accepted')
            ->paginate(10);

        return view('cases.byTag', compact('cases','tag','tag_name'));
    }

    public function deleteSelected(Request $request){
        $ids = $request->ids;
        $cases = LegalCase::whereIn('id',$ids)->get();
        $deletedNames = [];

        foreach ($cases as $case) {
            $deletedNames[] = $case->title;
            $case->delete();
        }

        $response['success'] = [
            'message' => 'Se han eliminado los siguientes casos:',
            'names' => $deletedNames,
        ];

        return response()->json($response);


    }




    public function destroy($id, Request $request)
    {
        $case = LegalCase::findOrFail($id);
        $case->delete();

        if ($request->query('from')) {
            return redirect()->route('cases.mycases', Auth::id())->with('success', 'Tu caso se ha eliminado exitosamente.');
        }

        return redirect()->back()->with('success', 'Caso eliminado exitosamente.');
    }

    public function restore($id){
        $case = LegalCase::onlyTrashed()->findOrFail($id);
        $case->restore();

        return redirect()->back()->with('success', 'Caso restaurado exitosamente.');

    }

    public function forceDelete($id)
    {
        $case = LegalCase::onlyTrashed()->findOrFail($id);
        $case->forceDelete();

        return redirect()->back()->with('success', 'Caso eliminado definitivamente.');

    }

}
