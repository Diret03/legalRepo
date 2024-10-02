<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request){

        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $users = User::orderBy($sortField, $sortDirection)->paginate(10);
        $roles = Role::all()->pluck('name');
//        dd($roles);
        return view('users.index', compact('users', 'roles'));
    }

    public function search(Request $request){

        if($request->ajax()){
            $query = $request->input('search');

            if ($query != '') {
                $dbDriver = DB::getDriverName();

                // Use ILIKE for PostgreSQL and LIKE for others
                $likeOperator = $dbDriver === 'pgsql' ? 'ILIKE' : 'LIKE';

                // Perform search query
                $users = User::where('id', $likeOperator, '%' . $query . '%')
                    ->orWhere('name', $likeOperator, '%' . $query . '%')
                    ->orWhere('last_name', $likeOperator, '%' . $query . '%')
                    ->orWhere('email', $likeOperator, '%' . $query . '%')
                    ->get();

            } else {
                // If search query is empty, return all users
                $users = User::paginate(10);
            }

            if (count($users) > 0) {
                $output = view('users.row', ['users' => $users])->render();

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
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'email' =>  ['required', 'unique:users', 'max:255', 'email'],
            'password' => 'required|string',
            'status' => 'required|boolean',
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
        ],[
            'name.regex' => 'El nombre solo debe contener letras.',
            'last_name.regex' => 'El apellido solo debe contener letras.',
        ]);

        $user = User::create([
            'name' => $validated_data['name'],
            'last_name' => $validated_data['last_name'],
            'email' => $validated_data['email'],
            'password' => Hash::make($validated_data['password']),
            'status' => $validated_data['status'],
        ]);

        if($validated_data['roles']){
            $user->syncRoles($validated_data['roles']);
            $user->save();
        }

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');

    }

    public function edit($id){

        $user = User::findOrFail($id);
        $roles = Role::all()->pluck('name');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated_data = $request->validate([
            'name' => ['nullable', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['nullable', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['nullable', 'max:255', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'status' => 'required|boolean',
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
        ],[
            'name.regex' => 'El nombre solo debe contener letras.',
            'last_name.regex' => 'El apellido solo debe contener letras.',
        ]);

        $user->status = $validated_data['status'];

        if (!empty($validated_data['name']) && Auth::id() === $user->id) {
            $user->name = $validated_data['name'];
        }
        if (!empty($validated_data['last_name']) && Auth::id() === $user->id) {
            $user->last_name = $validated_data['last_name'];
        }
        if (!empty($validated_data['email']) && Auth::id() === $user->id) {
            $user->email = $validated_data['email'];
        }

        if (!empty($validated_data['password']) && Auth::id() === $user->id) {
            $user->password = Hash::make($validated_data['password']);
        }

        if($validated_data['roles']){
            $user->syncRoles($validated_data['roles']);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }


    public function deleteSelected(Request $request){

        $ids = $request->ids;
        User::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Usuarios eliminados correctamente.']);

    }

    public function deactivateSelected(Request $request){
        $ids = $request->ids;

        $users = User::whereIn('id', $ids)->get();
        foreach ($users as $user) {
            $user->update(['status' => false]);
        }

        return response()->json(['success'=>'Usuarios desactivados correctamente.']);

    }

    public function destroy($id)
    {
        $project = User::findOrFail($id);
        $project->delete();

        return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
    }
}
