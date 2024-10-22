<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Subject::factory()->count(10)->create();

        Subject::create([
            'name' => 'Familia, Mujer, Niñez y Adolescencia',
            'description' => 'Casos relacionados con derechos y protección de la familia, mujeres, niños y adolescentes.',
            'image' => 'uploads/subjects/familia.jpg', 
        ]);

        Subject::create([
            'name' => 'Laboral',
            'description' => 'Asuntos sobre derechos y obligaciones laborales, contratos, despidos y relaciones de trabajo.',
            'image' => 'uploads/subjects/laboral.jpg', 
        ]);

//        Subject::create([
//            'name' => 'Inquilinato',
//            'description' => 'Casos vinculados a arrendamientos de inmuebles, derechos de inquilinos y propietarios.',
//        ]);

        Subject::create([
            'name' => 'Civil',
            'description' => 'Conflictos entre personas o entidades sobre contratos, propiedades y obligaciones civiles.',
            'image' => 'uploads/subjects/civil.jpg', 
        ]);

        Subject::create([
            'name' => 'Penal',
            'description' => 'Delitos y crímenes que afectan el orden público y que son sancionados por la ley penal.',
            'image' => 'uploads/subjects/penal.jpg', 
        ]);

//        Subject::create([
//            'name' => 'Tributario',
//            'description' => 'Casos relacionados con la recaudación de impuestos, derechos fiscales y obligaciones tributarias.',
//        ]);

        Subject::create([
            'name' => 'Procesal Código Orgánico Integral Penal',
            'description' => 'Procedimientos judiciales en el ámbito penal, conforme al Código Orgánico Integral Penal (COIP), que regula los delitos, las sanciones y el proceso para juzgarlos.',
            'image' => 'uploads/subjects/coip.jpg', 
        ]);

        Subject::create([
            'name' => 'Procesal Código Orgánico General de Procesos',
            'description' => 'Procedimientos judiciales en materia civil, mercantil, laboral y de familia, basados en el Código Orgánico General de Procesos (COGEP), que establece las reglas procesales para resolver conflictos de manera ordenada.',
            'image' => 'uploads/subjects/cogep.jpg', 
        ]);
    }
}
