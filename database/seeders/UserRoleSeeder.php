<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $digitador = User::factory()->create([
            'name' => 'Jordan',
            'last_name' => 'Puruncajas',
            'email' => 'digitador@gmail.com',
        ]);

        $revisor = User::factory()->create([
            'name' => 'Galo',
            'last_name' => 'Recalde',
            'email' => 'revisor@gmail.com',
        ]);

        $admin = User::factory()->create([
            'name' => 'El',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);

        $superAdmin = User::factory()->create([
            'name' => 'Diego',
            'last_name' => 'Recalde',
            'email' => 'diegodavidrecalde@gmail.com',
        ]);

        $superAdmin->assignRole('administrador','digitador','revisor');
        $admin->assignRole('administrador');
        $revisor->assignRole('revisor');
        $digitador->assignRole('digitador');
    }
}
