<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
                $data = User::where('id', $likeOperator, '%' . $query . '%')
                    ->orWhere('name', $likeOperator, '%' . $query . '%')
                    ->orWhere('last_name', $likeOperator, '%' . $query . '%')
                    ->orWhere('email', $likeOperator, '%' . $query . '%')
                    ->get();

            } else {
                // If search query is empty, return all users
                $data = User::paginate(10);
            }

            $output = '';
            if (count($data) > 0) {
                foreach($data as $row){
                    $output .= '
                    <tr id="user_ids'.$row->id.'" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input name="ids" type="checkbox" value='.$row->id.'
                                       class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox_ids " class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="px-6 py-4">' . $row->name . '</td>
                        <td class="px-6 py-4">' . $row->last_name . '</td>
                        <td class="px-6 py-4">' . $row->email . '</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                Activo
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <a href="'.route('users.edit',$row->id).'" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                                        <img src="' . asset('svg/edit.svg') . '" class="size-7" alt="Editar icon">
                                </a>
                                <form action="' . route('users.destroy', $row->id) . '" method="POST">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                            onclick="return confirm(\'¿Estás seguro de que deseas eliminar este registro?\')">
                                        <img src="' . asset('svg/delete.svg') . '" class="size-7" alt="Borrar icon">
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
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'max:255', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'status' => 'required|boolean',
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
        ],[
            'name.regex' => 'El nombre solo debe contener letras.',
            'last_name.regex' => 'El apellido solo debe contener letras.',
        ]);

        $user->name = $validated_data['name'];
        $user->last_name = $validated_data['last_name'];
        $user->email = $validated_data['email'];
        $user->status = $validated_data['status'];

        if (!empty($validated_data['password'])) {
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

    public function destroy($id)
    {
        $project = User::findOrFail($id);
        $project->delete();

        return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
    }
}
