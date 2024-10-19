<?php

namespace Database\Seeders;

use App\Models\Trial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Trial::factory()->count(15)->create();
        // Familia, Mujer Niñez y Adolescencia
        Trial::create([
            'subject_id' => 1,
            'name' => 'Fijación de Pensión Alimenticia',
            'description' => 'Proceso judicial para la fijación de pensión alimenticia.'
        ]);

        Trial::create([
            'subject_id' => 1,
            'name' => 'Fijación de Pensión Alimenticia de Ayuda Prenatal',
            'description' => 'Juicio para la fijación de pensión alimenticia para ayuda prenatal.'
        ]);

        Trial::create([
            'subject_id' => 1,
            'name' => 'Incidente de Aumento o Rebaja de Pensión Alimenticia (Con Proceso Judicial)',
            'description' => 'Incidente para aumento o rebaja de pensión alimenticia con proceso judicial.'
        ]);

        Trial::create([
            'subject_id' => 1,
            'name' => 'Acuerdo de Pago de Alimentos con Juicio o Mediación',
            'description' => 'Acuerdo de pago de alimentos a través de juicio o mediación.'
        ]);

        Trial::create([
            'subject_id' => 1,
            'name' => 'Cambio de Modalidad de Pensión Alimenticia con Juicio o Mediación',
            'description' => 'Cambio de modalidad de pensión alimenticia con juicio o mediación.'
        ]);

        Trial::create([
            'subject_id' => 1,
            'name' => 'Régimen de Visitas y Tenencia para realizar el Divorcio',
            'description' => 'Proceso judicial para determinar régimen de visitas y tenencia durante un divorcio.'
        ]);

        // Laboral
        Trial::create([
            'subject_id' => 2,
            'name' => 'Despido Injustificado',
            'description' => 'Proceso judicial en el que el trabajador demanda por haber sido despedido sin causa justificada.'
        ]);

        Trial::create([
            'subject_id' => 2,
            'name' => 'Reclamación de Beneficios Sociales',
            'description' => 'Juicio laboral en el que el trabajador reclama el pago de beneficios sociales no percibidos.'
        ]);

        // Inquilinato
//        Trial::create([
//            'subject_id' => 3,
//            'name' => 'Desalojo por Falta de Pago',
//            'description' => 'Proceso judicial para solicitar el desalojo del inquilino por falta de pago de la renta.'
//        ]);
//
//        Trial::create([
//            'subject_id' => 3,
//            'name' => 'Reparación de Daños a la Propiedad',
//            'description' => 'Juicio en el que el propietario demanda al inquilino por daños a la propiedad durante el arrendamiento.'
//        ]);

        // Civil
        Trial::create([
            'subject_id' => 3,
            'name' => 'Deuda Lícita',
            'description' => 'Juicio para la recuperación de deudas lícitas.'
        ]);

        Trial::create([
            'subject_id' => 3,
            'name' => 'Alimentos Congruos y Necesarios',
            'description' => 'Juicio por alimentos congruos y necesarios.'
        ]);

        Trial::create([
            'subject_id' => 3,
            'name' => 'Incumplimiento de contratos',
            'description' => 'Juicio por incumplimiento de contratos.'
        ]);

        Trial::create([
            'subject_id' => 3,
            'name' => 'Contrato de servicios profesionales',
            'description' => 'Juicio por problemas en contratos de servicios profesionales.'
        ]);

        Trial::create([
            'subject_id' => 3,
            'name' => 'Conflictos vecinales',
            'description' => 'Juicios relacionados con conflictos entre vecinos.'
        ]);

        // Penal
        Trial::create([
            'subject_id' => 4,
            'name' => 'Tránsito Daños Materiales',
            'description' => 'Juicio por daños materiales en accidentes de tránsito.'
        ]);

        Trial::create([
            'subject_id' => 4,
            'name' => 'Tránsito Lesiones',
            'description' => 'Juicio por lesiones en accidentes de tránsito.'
        ]);

        // Tributario
//        Trial::create([
//            'subject_id' => 6,
//            'name' => 'SRI: multas recargos e intereses',
//            'description' => 'Juicio tributario sobre multas, recargos e intereses del SRI, con el 25% de la deuda cancelada.'
//        ]);

        //Procesal Código Orgánico Integral Penal
        Trial::create([
            'subject_id' => 5,
            'name' => 'Delitos Contra La Vida',
            'description' => 'Juicios relacionados con delitos que atentan contra la vida, de acuerdo con el Código Orgánico Integral Penal.',
        ]);

        Trial::create([
            'subject_id' => 5,
            'name' => 'Delitos Contra La Integridad Física',
            'description' => 'Juicios relacionados con delitos que afectan la integridad física de las personas bajo el Código Orgánico Integral Penal.',
        ]);
        //Procesal Código Orgánico General de Procesos
        Trial::create([
            'subject_id' => 6,
            'name' => 'Procesos De Insolvencia',
            'description' => 'Juicios relacionados con insolvencia y quiebra bajo el Código Orgánico General de Procesos.',
        ]);

        Trial::create([
            'subject_id' => 6,
            'name' => 'Procesos De Familia',
            'description' => 'Juicios relacionados con el derecho de familia bajo el Código Orgánico General de Procesos.',
        ]);
    }
}
