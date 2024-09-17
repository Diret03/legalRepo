<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){

        $sortField = $request->query('sort', 'created_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $users = User::orderBy($sortField, $sortDirection)->paginate(10);

        return view('users', compact('users'));
    }

    public function search(Request $request){

        if($request->ajax()){
            $query = $request->input('search');

            if ($query != '') {
                // Perform search query with wildcards for matching substrings
                $data = User::where('id', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->get();
            } else {
                // If search query is empty, return all users
                $data = User::paginate(10);
            }

            $output = '';
            if (count($data) > 0) {
                foreach($data as $row){
                    $output .= '
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
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
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                                    <img src="' . asset('svg/edit.svg') . '" class="size-7" alt="Editar icon">
                                </a>
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    <img src="' . asset('svg/delete.svg') . '" class="size-7" alt="Editar icon">
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
            'name' => 'required|alpha:ascii',
            'last_name' => 'required|alpha:ascii',
            'email' =>  ['required', 'unique:users', 'max:255', 'email'],
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated_data['name'],
            'last_name' => $validated_data['last_name'],
            'email' => $validated_data['email'],
            'password' => Hash::make($validated_data['password']),
        ]);

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');

    }
}
