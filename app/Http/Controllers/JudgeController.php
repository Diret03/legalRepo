<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Judge;

class JudgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $judges = Judge::orderBy($sortField, $sortDirection)->paginate(10);

        // Append sort parameters to pagination links
        $judges->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        return view('judges.index', compact('judges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('judges.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'job_title' => 'required|string',
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

        Judge::create([
            'name' => $validated_data['name'],
            'last_name' => $validated_data['last_name'],
            'job_title' => $validated_data['job_title'],
            'image' => $path.$filename,
        ]);

        return redirect()->back()->with('success', 'Juez registrado exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $judge = Judge::findOrFail($id);

        return view('judges.edit', compact('judge'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $judge = Judge::findOrFail($id);

        $validated_data = $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'job_title' => 'required|string',
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

            $judge->update([
                'image' => $path.$filename,
            ]);
        }

        $judge->update([
            'name' => $validated_data['name'],
            'last_name' => $validated_data['last_name'],
            'job_title' => $validated_data['job_title'],
        ]);

        return redirect()->route('judges.index')->with('success', 'Juez actualizado exitosamente.');
    }


    public function deleteSelected(Request $request){

        $ids = $request->ids;
        $judges = Judge::whereIn('id', $ids)->get();
        $deletedNames = [];

        foreach ($judges as $judge) {
            $deletedNames[] = $judge->name.' '.$judge->last_name;
            $judge->delete();
        }

        $response['success'] = [
            'message' => 'Se han eliminado los siguientes jueces:',
            'names' => $deletedNames,
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $judge = Judge::findOrFail($id);
        $judge->delete();

        return redirect()->back()->with('success', 'Juez eliminado exitosamente.');
    }
}
