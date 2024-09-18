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

        $sortField = $request->query('sort', 'created_at'); // default sort field
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

                // Use ILIKE for PostgreSQL and LIKE for others
                $likeOperator = $dbDriver === 'pgsql' ? 'ILIKE' : 'LIKE';

                // Perform search query
                $data = Subject::where('id', $likeOperator, '%' . $query . '%')
                    ->orWhere('name', $likeOperator, '%' . $query . '%')
                    ->orWhere('description', $likeOperator, '%' . $query . '%')
                    ->get();
            } else {

                $data = Subject::paginate(10);
            }

            $output = '';
            if (count($data) > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr id="subject_ids'.$row->id.'" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input name="ids" type="checkbox" value='.$row->id.'
                                       class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox_ids" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="px-6 py-4">' . $row->name . '</td>
                        <td class="px-6 py-4">
                           <button
                                class="toggle-description text-blue-600 hover:underline"
                                data-project-id="{{ $subject->id }}">
                                <img src="' .asset('svg/plus.svg').'"
                                     class="w-5 h-5" alt="Agregar icon">
                            </button>
                           <div class="description-content hidden mt-2">
                                '.$row->description.'
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <img src="'.asset($row->image).'" class="size-10" alt="Imagen materia">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <a href="'.route('subjects.edit',$row->id).'" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                                        <img src="' . asset('svg/edit.svg') . '" class="size-7" alt="Editar icon">
                                </a>
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    <img src="' . asset('svg/delete.svg') . '" class="size-7" alt="Borrar icon">
                                </a>
                            </div>
                        </td>
                    </tr>';

                }
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
        Subject::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Materias eliminadas correctamente.']);

    }

    public function destroy($id)
    {
        $project = Subject::findOrFail($id);
        $project->delete();

        return redirect()->back()->with('success', 'Materia eliminada exitosamente.');
    }

}
