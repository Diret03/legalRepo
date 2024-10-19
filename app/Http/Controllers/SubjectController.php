<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Trial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubjectController extends Controller
{

    public function index(Request $request){

        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $subjects = Subject::orderBy($sortField, $sortDirection)->paginate(10);

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


    public function store(Request $request){

        $validated_data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);


        $path = NULL;
        $filename = NULL;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads/subjects/';
            $image->move($path, $filename);
        }

        $subject = Subject::create([
            'name' => $validated_data['name'],
            'description' => $validated_data['description'],
            'image' => $path.$filename,
        ]);

        return redirect()->back()->with('success', 'Materia creada exitosamente.');

    }

    public function edit($id){

        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }


    public function update(Request $request, $id){

        $subject = Subject::findOrFail($id);

        $validated_data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $path = NULL;
        $filename = NULL;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads/subjects/';
            $image->move($path, $filename);

            $subject->update([
                'image' => $path.$filename,
            ]);
        }

        $subject->update([
            'name' => $validated_data['name'],
            'description' => $validated_data['description'],
        ]);

        return redirect()->route('subjects.index')->with('success', 'Materia actualizada exitosamente.');

    }

    public function list(){

        $subjects = Subject::all();
        return view('subjects.list', compact('subjects'));
    }

    public function showTrials($id){

        $trials = Trial::where('subject_id',$id)->get();
        return view('trials', compact('trials'));
    }

    public function deleteSelected(Request $request){

        $ids = $request->ids;
        $invalidNames = [];
        $deletedNames = [];
        $invalidIds = [];
        Subject::whereIn('id',$ids)->get()->each(function($subject) use (&$invalidNames, &$deletedNames, &$invalidIds) {
            if($subject->trials->count() > 0){
                    $invalidNames[] = $subject->name;
                    $invalidIds[] = strval($subject->id);
            }
            else{
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
                'names'=>$invalidNames,
                'ids'=>$invalidIds,
            ];
        }

        return response()->json($response);
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);

        if($subject->trials->count() > 0){
            return redirect()->back()->with('error', 'No se puede eliminar esta materia, tiene juicios asociados.');
        }

        $subject->delete();

        return redirect()->back()->with('success', 'Materia eliminada exitosamente.');
    }

}
