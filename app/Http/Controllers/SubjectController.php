<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Trial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{

    public function index(Request $request)
    {

        Gate::authorize('viewAny', Subject::class);

        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $subjects = Subject::orderBy($sortField, $sortDirection)->paginate(10);

        // Append sort parameters to pagination links
        $subjects->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        return view('subjects.index', compact('subjects'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('search');

            if ($query != '') {
                $dbDriver = DB::getDriverName();
                $likeOperator = $dbDriver === 'pgsql' ? 'ILIKE' : 'LIKE';

                $subjects = Subject::where('id', $likeOperator, '%' . $query . '%')
                    ->orWhere('name', $likeOperator, '%' . $query . '%')
                    ->orWhere('description', $likeOperator, '%' . $query . '%')
                    ->get();
            } else {
                $subjects = Subject::paginate(10);
            }

            if ($subjects->count() > 0) {
                $output = view('subjects.subject-row', ['subjects' => $subjects])->render();
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
            Log::info('Filter subject request received', [
                'search' => $request->input('q'),
                'sort' => $request->input('sort'),
                'direction' => $request->input('direction'),
                'page' => $request->input('page'),
            ]);

            $query = Subject::query();

            // Apply search if provided
            if ($request->filled('q')) {
                $searchTerm = $request->q;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id', 'ILIKE', "%{$searchTerm}%")
                        ->orWhere('name', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'ILIKE', '%' . $searchTerm . '%');
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
            Log::info('SQL Subject Query:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            $totalCount = $query->count();

            // Adjust page if it exceeds the last possible page
            $perPage = 10;
            $lastPage = max(1, ceil($totalCount / $perPage));
            $page = min($page, $lastPage);

            //paginate results
            $subjects = $query->paginate($perPage, ['*'], 'page', $page);

            Log::info('Obtained subjects', ['subjects' => $subjects]);

            if ($request->ajax()) {

                if ($subjects->isEmpty()) {

                    return '<tr class="bg-white border-b hover:bg-gray-50">
                                            <td colspan="5" class="px-6 py-12 font-bold text-2xl text-center">No se encontraron materias</td>
                                        </tr>';
                }

                return response()->view('subjects.subject-row', compact('subjects'))->header('Content-Type', 'text/html');
            }

            return view('subjects.index', compact('subjects'));

        } catch (\Exception $e) {
            Log::error('Error in filter method - subjects', [
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

    public function store(Request $request)
    {

        Gate::authorize('create', Subject::class);

        $validated_data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);


        $path = NULL;
        $filename = NULL;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads/subjects/';
            $image->move($path, $filename);
        }

        $subject = Subject::create([
            'name' => $validated_data['name'],
            'description' => $validated_data['description'],
            'image' => $path . $filename,
        ]);

        return redirect()->back()->with('success', 'Materia creada exitosamente.');

    }

    public function edit($id)
    {

        Gate::authorize('edit', Subject::class);

        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }


    public function update(Request $request, $id)
    {

        Gate::authorize('edit', Subject::class);
        $subject = Subject::findOrFail($id);

        $validated_data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $path = NULL;
        $filename = NULL;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads/subjects/';
            $image->move($path, $filename);

            $subject->update([
                'image' => $path . $filename,
            ]);
        }

        $subject->update([
            'name' => $validated_data['name'],
            'description' => $validated_data['description'],
        ]);

        return redirect()->route('subjects.index')->with('success', 'Materia actualizada exitosamente.');

    }

    public function list()
    {

        $subjects = Subject::all();
        return view('subjects.list', compact('subjects'));
    }

    public function showTrials($id)
    {

        $trials = Trial::where('subject_id', $id)->get();
        return view('trials', compact('trials'));
    }

    public function deleteSelected(Request $request)
    {

        Gate::authorize('delete', Subject::class);

        $ids = $request->ids;
        $invalidNames = [];
        $deletedNames = [];
        $invalidIds = [];
        Subject::whereIn('id', $ids)->get()->each(function ($subject) use (&$invalidNames, &$deletedNames, &$invalidIds) {
            if ($subject->trials->count() > 0) {
                $invalidNames[] = $subject->name;
                $invalidIds[] = strval($subject->id);
            } else {
                $deletedNames[] = $subject->name;
                $subject->delete();

            }
        });

        $response = [];

        if (!empty($deletedNames)) {
            $response['success'] = [
                'message' => 'Se han eliminado las siguientes materias:',
                'names' => $deletedNames,
            ];
        }

        if (!empty($invalidNames)) {
            $response['error'] = [
                'message' => 'No se pueden eliminar las siguientes materias debido a que tienen juicios asociados:',
                'names' => $invalidNames,
                'ids' => $invalidIds,
            ];
        }

        return response()->json($response);
    }

    public function destroy($id)
    {
        Gate::authorize('delete', Subject::class);
        $subject = Subject::findOrFail($id);

        if ($subject->trials->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar esta materia, tiene juicios asociados.');
        }

        $subject->delete();

        return redirect()->back()->with('success', 'Materia eliminada exitosamente.');
    }

}
