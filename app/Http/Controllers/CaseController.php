<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Trial;
use App\Models\LegalCase;
use Illuminate\Support\Facades\DB;
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
        return view('cases.create',compact('trials'));
    }

    public function store(Request $request){

        $validated_data = $request->validate([
            'title' => 'required|string',
            'trial_id' => 'required|exists:trials,id',
            'date' => 'required|date',
            'origin' => 'required|string',
            'context' => 'required|string',
            'analysis' => 'required|string',
            'resolution' => 'required|string',
            'note' => 'nullable|string',
            'tags' => 'nullable'
        ]);

        $case = LegalCase::create([
            'title' => $validated_data['title'],
            'trial_id' => $validated_data['trial_id'],
            'date' => $validated_data['date'],
            'origin' => $validated_data['origin'],
            'context' => $validated_data['context'],
            'analysis' => $validated_data['analysis'],
            'resolution' => $validated_data['resolution'],
            'note' => $validated_data['note'],
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

        return redirect()->route('cases.index')->with('success', 'Juicio creado exitosamente.');
    }

    public function edit($id){

        $case = LegalCase::findOrFail($id);
        $trials = Trial::all();
        return view('cases.edit', compact('case','trials'));
    }

    public function update(Request $request, $id) {
        $validated_data = $request->validate([
            'title' => 'required|string',
            'trial_id' => 'required|exists:trials,id',
            'date' => 'required|date',
            'origin' => 'required|string',
            'context' => 'required|string',
            'analysis' => 'required|string',
            'resolution' => 'required|string',
            'note' => 'nullable|string',
            'tags' => 'nullable'
        ]);

        $case = LegalCase::findOrFail($id);
        $case->update([
            'title' => $validated_data['title'],
            'trial_id' => $validated_data['trial_id'],
            'date' => $validated_data['date'],
            'origin' => $validated_data['origin'],
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

            if ($query != '') {
                $dbDriver = DB::getDriverName();

                // Use ILIKE for PostgreSQL and LIKE for others
                $likeOperator = $dbDriver === 'pgsql' ? 'ILIKE' : 'LIKE';

                // Perform search query
                $data = LegalCase::where('id', $likeOperator, '%' . $query . '%')
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

                $data = LegalCase::paginate(10);
            }

            $output = '';
            if (count($data) > 0) {
                foreach($data as $case){

                    $output .= '
                        <tr id="case_ids'.$case->id.'" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input name="ids" type="checkbox" value="'.$case->id.'" class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox_ids" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="px-6 py-4">'.$case->title.'</td>
                            <td class="px-6 py-4">'.$case->trial->subject->name.'</td>
                            <td class="px-6 py-4">'.$case->trial->name.'</td>
                            <td class="px-6 py-4">'.\Carbon\Carbon::parse($case->date)->format('d/m/Y').'</td>
                            <td class="px-6 py-4">'.$case->origin.'</td>
                            <td class="px-6 py-4">
                                <button data-modal-target="case-modal-'.$case->id.'" data-modal-toggle="case-modal-'.$case->id.'" class="block text-white bg-red-650 hover:bg-red-200 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">Ver</button>
                                <div id="case-modal-'.$case->id.'" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detalles del Caso</h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="case-modal-'.$case->id.'">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Cerrar modal</span>
                                                </button>
                                            </div>
                                            <div class="p-4 md:p-5 space-y-4">
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 dark:text-white">Contexto</h4>
                                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">'.$case->context.'</p>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 dark:text-white">Análisis</h4>
                                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">'.$case->analysis.'</p>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 dark:text-white">Resolución</h4>
                                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">'.$case->resolution.'</p>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 dark:text-white">Notas</h4>
                                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">'.$case->note.'</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <a href="'.route('cases.edit',$case->id).'" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                                        <img src="'.asset('svg/edit.svg').'" class="size-7" alt="Editar icon">
                                    </a>
                                    <form action="'.route('cases.destroy',$case->id).'" method="POST">
                                        '.csrf_field().'
                                        '.method_field('DELETE').'
                                        <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este registro?\')">
                                            <img src="'.asset('svg/delete.svg').'" class="size-7" alt="Borrar icon">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>';


                }
            } else {
                $output = '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                               <td colspan="8" class="px-6 py-12 font-bold text-2xl text-center">No se encontraron resultados</td>
                           </tr>';
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

        $cases = LegalCase::where('trial_id',$trial_id)->paginate(5);
        $trial = Trial::where('id',$trial_id)->first();
        $trial_name = $trial->name;
        return view('cases.byTrial', compact('cases','trial','trial_name'));
    }

    public function show($id){

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
