<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Trial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TrialController extends Controller
{
    public function showTrials($id){

        $trials = Trial::where('subject_id',$id)->paginate(5);
//        $subject = Subject::find($id);
        $subject = Subject::findOrFail($id);
        $subject_name = $subject->name;


        return view('trials', compact('trials','subject','subject_name'));
    }

    public function getTrialsBySubject($subject_id){

        $subject = Subject::findOrFail($subject_id);

        return response()->json($subject->trials);

    }

    public function index(Request $request){

        Gate::authorize('viewAny',Trial::class);

        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $trials = Trial::orderBy($sortField, $sortDirection)->paginate(10);
        $subjects = Subject::orderBy('name')->get();

        // Append sort parameters to pagination links
        $trials->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        return view('trials.index', compact('trials','subjects'));
    }

    public function search(Request $request){

        if($request->ajax()){
            $query = $request->input('search');

            if ($query != '') {
                $dbDriver = DB::getDriverName();

                // Use ILIKE for PostgreSQL and LIKE for others
                $likeOperator = $dbDriver === 'pgsql' ? 'ILIKE' : 'LIKE';

                // Perform search query
                $trials = Trial::where('id', $likeOperator, '%' . $query . '%')
                    ->orWhere('name', $likeOperator, '%' . $query . '%')
                    ->orWhere('description', $likeOperator, '%' . $query . '%')
                    ->orWhereHas('subject', function ($queryBuilder) use ($query, $likeOperator) {
                        $queryBuilder->where('name', $likeOperator, '%' . $query . '%');
                    })
                    ->get();

            } else {

                $trials = Trial::paginate(10);
            }

            if (count($trials) > 0) {
                $output = view('trials.row', ['trials' => $trials])->render();
            } else {
                $output = '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                               <td colspan="6" class="px-6 py-12 font-bold text-2xl text-center">No se encontraron resultados</td>
                           </tr>';
            }

            return $output;
        }
    }


    public function filter(Request $request)
    {


        try {

            // Log incoming request data
            Log::info('Filter trial request received', [
                'search' => $request->input('q'),
                'sort' => $request->input('sort'),
                'direction' => $request->input('direction'),
                'page' => $request->input('page'),
            ]);

            $query = Trial::query();

            // Apply search if provided
            if ($request->filled('q')) {
                $searchTerm = $request->q;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id', 'ILIKE', "%{$searchTerm}%")
                        ->orWhere('name', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhereHas('subject', function ($q) use ($searchTerm) {
                            $q->where('name', 'ILIKE', '%' . $searchTerm . '%');
                        });
                });
            }

            // Apply sorting
            $sortField = in_array(strtolower($request->query('sort')), ['updated_at'])
                ? strtolower($request->query('sort'))
                : 'updated_at';
            $sortDirection = in_array(strtolower($request->query('direction')), ['asc', 'desc'])
                ? strtolower($request->query('direction'))
                : 'desc';
            $page = intval($request->input('page', 1));

            $query->orderBy($sortField, $sortDirection);

            // Log the SQL query being executed
            Log::info('SQL Trial Query:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            $totalCount = $query->count();

            // Adjust page if it exceeds the last possible page
            $perPage = 10;
            $lastPage = max(1, ceil($totalCount / $perPage));
            $page = min($page, $lastPage);

            //paginate results
            $trials = $query->paginate($perPage, ['*'], 'page', $page);

            Log::info('Obtained trials', ['trials' => $trials]);

            $subjects = Subject::orderBy('name')->get();

            if ($request->ajax()) {

                if ($trials->isEmpty()) {

                    return '<tr class="bg-white border-b hover:bg-gray-50">
                                            <td colspan="6" class="px-6 py-12 font-bold text-2xl text-center">No se encontraron juicios</td>
                                        </tr>';
                }


                return response()->view('trials.row', compact('trials', 'subjects'))->header('Content-Type', 'text/html');
            }

            return view('trials.index', compact('trials', 'subjects'));

        } catch (\Exception $e) {
            Log::error('Error in filter method - trials', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }

            throw $e;
        }
    }

    public function store(Request $request){

        Gate::authorize('create', Trial::class);

        $validated_data = $request->validate([
            'name' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string',
        ]);

        $trial = Trial::create([
            'name' => $validated_data['name'],
            'subject_id' => $validated_data['subject_id'],
            'description' => $validated_data['description'],
        ]);

        return redirect()->back()->with('success', 'Juicio creado exitosamente.');

    }


    public function edit($id){

        Gate::authorize('edit', Trial::class);

        $trial = Trial::findOrFail($id);
        $subjects = Subject::all();
        return view('trials.edit', compact('trial','subjects'));
    }

    public function update(Request $request, $id){

        Gate::authorize('edit', Trial::class);

        $trial = Trial::findOrFail($id);

        $validated_data = $request->validate([
            'name' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string',
        ]);

        $trial->update([
            'name' => $validated_data['name'],
            'subject_id' => $validated_data['subject_id'],
            'description' => $validated_data['description'],
        ]);

        return redirect()->route('trials.index')->with('success', 'Juicio actualizado exitosamente.');

    }

//    public function deleteSelected(Request $request){
//        $ids = $request->ids;
//        Trial::whereIn('id',$ids)->delete();
//        return response()->json(['success'=>'Juicios eliminados correctamente.']);
//    }
    public function deleteSelected(Request $request){

        Gate::authorize('delete', Trial::class);

        $ids = $request->ids;
        $invalidNames = [];
        $deletedNames = [];
        $invalidIds = [];
        Trial::whereIn('id',$ids)->get()->each(function($trial) use (&$invalidNames, &$deletedNames, &$invalidIds) {
            if($trial->cases->count() > 0){
                $invalidNames[] = $trial->name;
                $invalidIds[] = strval($trial->id);
            }
            else{
                $deletedNames[] = $trial->name;
                $trial->delete();

            }
        });

        $response = [];

        if (!empty($deletedNames)) {
            $response['success'] = [
                'message' => 'Se han eliminado los siguientes juicios:',
                'names' => $deletedNames,
            ];
        }

        if (!empty($invalidNames)) {
            $response['error'] = [
                'message' => 'No se pueden eliminar los siguientes juicios debido a que tienen casos asociados:',
                'names'=>$invalidNames,
                'ids'=>$invalidIds,
            ];
        }

        return response()->json($response);

    }

    public function destroy($id)
    {
        Gate::authorize('delete', Trial::class);
        $trial = Trial::findOrFail($id);

        if ($trial->cases->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar el juicio debido a que tiene casos asociados.');
        }
        else{
            $trial->delete();
            return redirect()->back()->with('success', 'Juicio eliminado exitosamente.');
        }

    }


}
