<?php

namespace Database\Seeders;

use App\Models\LegalCase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LegalCase::create([
            'user_id' => 1,
            'trial_id' => 1,
            'title' => "Pago mixto de la pensión alimenticia",
            'date' => date("Y/m/d"),
            'origin' => 'Ibarra',
            'status' => 'accepted',
            'context' =>'<p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">La se&ntilde;ora A (madre) presenta una demanda de Alimentos en contra del se&ntilde;or B (padre) en la que se reclama la pensi&oacute;n alimenticia a favor de su hijo en com&uacute;n NNA, seg&uacute;n la legislaci&oacute;n ecuatoriana.</span></p>
                        <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
                        <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">Resulta que los padres A y B est&aacute;n casados, pero se han separado hace algunos a&ntilde;os, su hijo NNA vive con ambos progenitores en distintos d&iacute;as de la semana (m&aacute;s de dos d&iacute;as con cada uno). Los padres ven&iacute;an asumiendo los gastos de manutenci&oacute;n mientras su hijo convive con cada uno, pero la madre
ya ten&iacute;a entablada la demanda de alimentos desde el a&ntilde;o 2015.</span></p>',
            'analysis' => '<p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">Seg&uacute;n el Art. innumerado 6 #1 de la Ley Reformatoria al C&oacute;digo de la Ni&ntilde;ez y Adolescencia, est&aacute; legitimada para interponer una demanda de alimentos a favor de un ni&ntilde;o, ni&ntilde;a o adolescente (NNA), el progenitor que ejerza su representaci&oacute;n legal, que por lo general suele ser aqu&eacute;l con quien vive el hijo o hija, o la persona que por cualquier raz&oacute;n ostente el cuidado del NNA.</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">Por tanto, si &ldquo;A&rdquo; presenta una demanda de alimentos en contra de &ldquo;B&rdquo;, deber&iacute;a entenderse que se le ha confiado la tenencia del NNA o al menos que es la progenitora que vive con el NNA exclusivamente. </span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">No obstante, no se le ha encargado la tenencia a &ldquo;A&rdquo;, pues como &ldquo;A&rdquo; y &ldquo;B&rdquo; siguen casados, no se ha resuelto la situaci&oacute;n de tenencia de su hijo NNA.</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">La ley no ha previsto una soluci&oacute;n para este tipo de casos, raz&oacute;n por la cual se busca una soluci&oacute;n, considerando el derecho comparado, en donde se establecen reglas para determinar la tenencia compartida, mismas que deben ser compatibles con la situaci&oacute;n de hecho que se analiza.</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">Sin embargo, la soluci&oacute;n ha surgido mediante un acuerdo entre las partes procesales, por las cuales se establece lo siguiente:</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong style="mso-bidi-font-weight: normal;"><span lang="ES-TRAD">&nbsp;</span></strong></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong><span lang="ES-TRAD">1. </span></strong><span lang="ES-TRAD">Se ha efectuado el c&aacute;lculo de la pensi&oacute;n alimenticia que corresponder&iacute;a establecer en caso de que &ldquo;A&rdquo; fuera quien ejerce la tenencia de su hijo de forma exclusiva, determinando que el monto que podr&iacute;a establecerse ser&iacute;a de </span><span lang="ES-TRAD">USD $213.oo, estableciendo una modalidad de pago mixta:</span></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="margin-left: 35.4pt; text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong><span lang="ES-TRAD">a)</span></strong><span lang="ES-TRAD"> La cantidad de USD $100.oo, mediante pago en efectivo mediante dep&oacute;sito en el C&oacute;digo SUPA, a fin de atender las necesidades de educaci&oacute;n entre otros (en el caso, pago de internet para las tareas); y, </span></span></p>
            <p class="MsoNormal" style="margin-left: 35.4pt; text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong><span lang="ES-TRAD">b) </span></strong><span lang="ES-TRAD">La cantidad de USD $113.oo se pagar&aacute; de manera directa, en raz&oacute;n de que &ldquo;B&rdquo; atender&aacute; las necesidades de alimentaci&oacute;n, vestimenta, transporte, entre otras necesidades b&aacute;sicas del NNA que se generen durante el tiempo que &eacute;ste se encuentre bajo su cuidado.</span></span></p>
            <p class="MsoNormal" style="margin-left: 35.4pt; text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">Esta situaci&oacute;n ha sido aceptada por &ldquo;A&rdquo;, acuerdo que es aprobado por la autoridad judicial en raz&oacute;n de que &ldquo;B&rdquo; no justifica los ingresos que percibe, pues refiere que conduce el taxi de propiedad de su padre, por el cual obtiene ingresos diarios por la cantidad de $15.oo; y que adem&aacute;s posee otras cargas familiares, esto es, sus hijos X, Y, Z, de 18, 17 y 10 a&ntilde;os de edad. </span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong><span lang="ES-TRAD">2. </span></strong><span lang="ES-TRAD">La cantidad acordada como pensi&oacute;n alimenticia a favor del NNA ha sido el resultado de considerar los gastos permanentes que ha referido &ldquo;B&rdquo; satisface por concepto de alimentaci&oacute;n, pago de pensi&oacute;n escolar y otros a favor de su hijo NNA, por lo que calcular la pensi&oacute;n alimenticia en aplicaci&oacute;n de la Tabla de Pensiones Alimenticias ir&iacute;a en desmedro de los derechos del NNA, y constituir&iacute;a una regresi&oacute;n del derecho a alimentos que de hecho ya est&aacute; siendo cubierto por &ldquo;B&rdquo;. </span></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong><span lang="ES-TRAD">3. </span></strong><span lang="ES-TRAD">&ldquo;A&rdquo; ha referido que adeuda pensiones escolares en la entidad de estudios de su hijo, mismas que no han sido cubiertas oportunamente por falta de recursos econ&oacute;micos.</span></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong><span lang="ES-TRAD">4. </span></strong><span lang="ES-TRAD">Este acuerdo encuentra su sustento en el Art. innumerado 14 de la Ley Reformatoria al C&oacute;digo de la Ni&ntilde;ez y Adolescencia que determina la posibilidad de que el juez autorice el pago de la pensi&oacute;n alimenticia y de los subsidios y beneficios adicionales mediante <strong>el pago o satisfacci&oacute;n directos por parte del obligado, de las necesidades del beneficiario que &eacute;ste determine</strong>.</span> </span></p>
            <p class="MsoNormal" style="margin-left: 35.4pt; text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong><span lang="ES-TRAD">5. </span></strong><span lang="ES-TRAD">De efectuar el c&aacute;lculo de las pensiones alimenticias, considerando los ingresos reportados en el Informe de Trabajo Social se hubiera efectuado el siguiente c&aacute;lculo: </span></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">Ingresos: $1200.oo<span style="mso-spacerun: yes;">&nbsp; </span>* 49.51% (nivel 2) = $594.12 / 4 (n&uacute;mero total de hijos) = $148.53 pensi&oacute;n m&iacute;nima. </span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-family: figtree; font-size: 12pt;"><strong><span lang="ES-TRAD">6. </span></strong><span lang="ES-TRAD">Por lo expuesto lo acordado por las partes
procesales satisface de mejor manera el derecho alimenticio del NNA.</span></span></p>',
            'resolution' => '<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt; font-family: figtree;"><strong><span lang="ES-TRAD">7. Se resuelve que:</span></strong></span></p>
            <p class="MsoNormal" style="text-align: justify;">&nbsp;</p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt; font-family: figtree;"><strong><span lang="ES-TRAD">7.1. </span></strong><span lang="ES-TRAD">Aprobar el acuerdo al que han llegado las partes procesales y en tal virtud, se fija por concepto de PENSI&Oacute;N ALIMENTICIA definitiva que el se&ntilde;or B debe pasar a favor de su hijo NNA, de doce (12) a&ntilde;os de edad, en la cantidad de USD $213.oo mensuales, m&aacute;s los correspondientes subsidios y beneficios legales, la misma que rige a partir de la fecha de presentaci&oacute;n de la demanda, esto es, desde el 26 de marzo del 2015, de conformidad a lo dispuesto en el Art&iacute;culo 8 de la Ley Reformatoria al C&oacute;digo Org&aacute;nico de la Ni&ntilde;ez y la Adolescencia, pensi&oacute;n que ser&aacute; sufragada de la siguiente forma: </span></span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">a) La cantidad de USD $100.oo que ser&aacute; depositada por mesadas anticipadas dentro de los cinco primeros d&iacute;as de cada mes en el C&oacute;digo SUPA que se abra para el efecto.</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">b) Por la cantidad de USD $113.oo mensual, el alimentante asumir&aacute; de manera directa los gastos de alimentaci&oacute;n, transporte, colaciones escolares, entre otros que permitan atender las necesidades b&aacute;sicas y m&aacute;s elementales de su hijo menor de edad, durante los d&iacute;as que se halle bajo su cuidado y protecci&oacute;n. </span></p>
            <p class="MsoNormal" style="text-align: justify;"><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">&nbsp;</span></p>
            <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 12pt; font-family: figtree;"><strong><span lang="ES-TRAD">7.2.</span></strong><span lang="ES-TRAD"> Se dispone a la Oficina de Pagadur&iacute;a que proceda a crear el c&oacute;digo SUPA seg&uacute;n lo dispuesto en esta resoluci&oacute;n, principalmente lo previsto en la letra &ldquo;a&rdquo; de esta resoluci&oacute;n, considerando la cuenta que haya proporcionado &ldquo;A&rdquo;; as&iacute; tambi&eacute;n se emita un informe de pensiones alimenticias adeudadas que existieran en la presente causa, considerando para ello el rubro se&ntilde;alado en el literal &ldquo;a&rdquo; antes mencionado y la fecha de presentaci&oacute;n de la demanda, a fi
n de proseguir con la ejecuci&oacute;n del pago.</span></span></p>',
            'note' => '<p><span lang="ES-TRAD" style="font-size: 12pt; font-family: figtree;">Esta es s&oacute;lo una de las formas en que pod&iacute;a haberse resuelto la causa, no debe olvidarse que lo que se busca a trav&eacute;s de los &oacute;rganos jurisdiccionales es solucionar los conflictos de la ciudadan&iacute;a, mediante soluciones justas, adecuando el Derecho (reglas existentes) o creando reglas que no se contrapongan a la ley o a la Constituci&oacute;n (no se opon
ga a una norma expresa de car&aacute;cter prohibitiva).</span></p>',
        ]);


        LegalCase::factory()
            ->count(50)
            ->withTags()
            ->create();
    }
}
