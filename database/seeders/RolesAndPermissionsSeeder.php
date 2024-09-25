<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        //casos
        Permission::create(['name' => 'ver cualquier caso']);
        Permission::create(['name' => 'ver cualquier caso']);
        Permission::create(['name' => 'crear casos']);
        Permission::create(['name' => 'editar cualquier caso']);
        Permission::create(['name' => 'eliminar cualquier caso']);
        Permission::create(['name' => 'editar propio caso']);
        Permission::create(['name' => 'eliminar propio caso']);
        Permission::create(['name' => 'revisar casos']);
        Permission::create(['name' => 'aprobar casos']);
        Permission::create(['name' => 'rechazar casos']);
        Permission::create(['name' => 'reportar casos']);

        //juicios
        Permission::create(['name' => 'editar juicios']);
        Permission::create(['name' => 'crear juicios']);
        Permission::create(['name' => 'ver juicios']);
        Permission::create(['name' => 'eliminar juicios']);

        //materias
        Permission::create(['name' => 'editar materias']);
        Permission::create(['name' => 'crear materias']);
        Permission::create(['name' => 'ver materias']);
        Permission::create(['name' => 'eliminar materias']);

        //usuarios
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'activar usuarios']);
        Permission::create(['name' => 'desactivar usuarios']);

        // create roles and assign created permissions

        $roleDigitador = Role::create(['name' => 'digitador'])
            ->givePermissionTo(['crear casos', 'editar propio caso', 'eliminar propio caso', 'ver casos']);

        $roleAdmin = Role::create(['name' => 'administrador'])
            ->givePermissionTo([
                'ver casos', 'editar cualquier caso', 'eliminar cualquier caso', 'crear casos',
                'crear materias', 'editar materias', 'eliminar materias', 'ver materias',
                'crear juicios', 'editar juicios', 'eliminar juicios', 'ver juicios',
                'crear usuarios', 'editar usuarios', 'eliminar usuarios', 'ver usuarios', 'activar usuarios', 'desactivar usuarios',
            ]);

        $roleReviewer = Role::create(['name' => 'revisor'])
            ->givePermissionTo(['ver casos', 'aprobar casos', 'rechazar casos','revisar casos']);
    }
}
