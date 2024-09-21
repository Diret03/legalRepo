<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Trial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TrialController extends Controller
{
    public function showTrials($id){

        $trials = Trial::where('subject_id',$id)->paginate(5);
//        $subject = Subject::find($id);
        $subject = Subject::where('id',$id)->first();
        $subject_name = $subject->name;
        return view('trials', compact('trials','subject','subject_name'));
    }

    public function index(Request $request){

        $sortField = $request->query('sort', 'created_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $trials = Trial::orderBy($sortField, $sortDirection)->paginate(10);
        $subjects = Subject::all();
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
                $data = Trial::where('id', $likeOperator, '%' . $query . '%')
                    ->orWhere('name', $likeOperator, '%' . $query . '%')
                    ->orWhere('description', $likeOperator, '%' . $query . '%')
                    ->orWhereHas('subject', function ($queryBuilder) use ($query, $likeOperator) {
                        $queryBuilder->where('name', $likeOperator, '%' . $query . '%');
                    })
                    ->get();

            } else {

                $data = Trial::paginate(10);
            }

            $output = '';
            if (count($data) > 0) {
                foreach($data as $row){
                    $output .= '
                        <tr id="trial_ids'.$row->id.'" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input name="ids" type="checkbox" value="'.$row->id.'"
                                           class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox_ids" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                '.$row->name.'
                            </td>
                            <td class="px-6 py-4">
                                '.$row->subject->name.'
                            </td>
                            <td class="px-6 py-4">
                                <button class="toggle-description text-blue-600 hover:underline" data-project-id="'.$row->id.'">
                                    <img src="'.asset('svg/plus.svg').'" class="w-5 h-5" alt="Agregar icon">
                                </button>
                                <div class="description-content hidden mt-2">
                                    '.$row->description.'
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <a href="'.route('trials.edit', $row->id).'" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                                        <img src="'.asset('svg/edit.svg').'" class="size-7" alt="Editar icon">
                                    </a>
                                    <form action="'.route('trials.destroy', $row->id).'" method="POST">
                                        '.csrf_field().'
                                        '.method_field('DELETE').'
                                        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                onclick="return confirm(\'¿Estás seguro de que deseas eliminar este registro\')">
                                            <img src="'.asset('svg/delete.svg').'" class="size-7" alt="Borrar icon">
                                        </button>
                                    </form>
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
            'name' => 'required|alpha:ascii',
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

        $trial = Trial::findOrFail($id);
        $subjects = Subject::all();
        return view('trials.edit', compact('trial','subjects'));
    }

    public function update(Request $request, $id){

        $trial = Trial::findOrFail($id);

        $validated_data = $request->validate([
            'name' => 'required|alpha:ascii',
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

    public function deleteSelected(Request $request){
        $ids = $request->ids;
        Trial::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Juicios eliminados correctamente.']);

    }

    public function destroy($id)
    {
        $trial = Trial::findOrFail($id);
        $trial->delete();

        return redirect()->back()->with('success', 'Juicio eliminado exitosamente.');
    }


}
