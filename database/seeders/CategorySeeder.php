<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Subcategory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder{

    public function run(){
        //i. Delitos que atentan contra la vida y la integridad corporal
        $categories = [
            'Homicidio' => ['Homicidio', 'Homicidio clasificado', 'Homicidio doloso', 'Homicidio culposo', 'Homicidio en riña', 'Parricidio e infanticidio',],
            'Lesiones' => ['Lesiones', 'Lesiones calificadas', 'Lesiones dolosas', 'Lesiones culposas', 'Lesiones en riña', ' Lesiones agravadas por razón del parentesco'],
            'Feminicidio' => ['Feminicidio'],
            'Aborto' => ['Aborto'],
            'Otros delitos que atentan contra la vida y la integridad corporal' => ['Inducción o ayuda al suicidio', 'Peligro de contagio, inseminación artificial no consentida, entre otros'],
            //ii. Delitos que atentan contra la libertad personal
            'Secuestros' => ['Secuestro extorsivo', 'Secuestro con calidad de rehén', 'Secuestro para causar daño', 'Secuestro exprés', 'Otro tipo de secuestro'],
            'Trafico de menores' => ['Trafico de menores', 'Adopción ilegal', 'Venta de niños, niñas y adolescentes', 'Traslado indebido de niñas, niños o adolescentes de una institución asistencial'],
            'Rapto' => ['Rapto', 'Privación de la libertad con fines sexuales'],
            'Otros delitos que atentan contra la libertad personal' => ['Intermediación, colaboración, asesoría, intimidación a la víctima y otros actos relacionados con la privación ilegal de la libertad', 'Simulación (auto secuestro)',
                'Desaparición forzada de personas cometidas por particulares, retención y sustracción de incapaces, o cualquier otro que reúna los supuestos de conducta antes expuestos'],
            //iii Delitos que atentan contra la libertad y la seguridad sexual.
            'Abuso sexual' => ['Abuso sexual', 'Abuso sexual equiparado'],
            'Acoso sexual' => ['Acoso sexual'],
            'Hostigamiento sexual' => ['Hostigamiento sexual'],
            'Violación simple' => ['Violación genérica'],
            'Violación equiparada o agravada' => ['Violación equiparada', 'Violación impropia por instrumentos o elementos distinto al natural', 'Violación cuando se trata de menores de edad aun cuándo no concurra violencia'],
            'Incesto' => ['Incesto'],
            'Otros delitos que atentan contra la libertad y la seguridad sexual' => ['Estupro', 'Ultraje(s) a la moral publica', 'Exhibicionismo extremo', 'Lenocinio'],
            //iv Delitos que atentan contra el patrimonio.
            'Robo a casa habitación' => ['Robo de bienes en inmueble destinados a habitar'],
            'Robo de vehículo automotor' => ['Robo de coche de cuatro ruedas (incluye microbús)', 'Robo de motocicleta', 'Robo de embarcaciones pequeñas y grandes'],
            'Robo de autopartes' => ['Robo de refacciones', 'Robo de llantas', 'Robo de espejos, calaveras y/o cristales del vehículo automotor', 'Robo de objetos instalados en el interior del vehículo automotor'],
            'Robo a transportista' => ['Robo de tráiler o camión de carga', 'Robo de camionetas de carga', 'Robo de dollys', 'Robo de pipas', 'Robo de grúas', 'Robo de bienes muebles de estos transportes'],
            'Robo a transeúnte en vía publica' => ['Robo de bolso o cartera en vía pública', 'Robo de teléfono, aparato electrónico o prenda en vía pública', 'Robo de cualquier otro bien mueble, numerario u objeto en vía pública'],
            'Robo a transeúnte en espacio abierto al publico' => ['Robo de bolso o cartera en espacio abierto al público', 'Robo de teléfono, aparato electrónico o prenda en espacio abierto al publico', 'Robo de cualquier otro bien, numerario u objeto mueble en espacio abierto al público', 'Robo en centro comercial'],
            'Robo en transporte publico individual' => ['Robo de bolso o cartera en transporte publico individual (taxi)', 'Robo de teléfono, aparato electrónico o prenda en transporte publico individual (taxi)', 'Robo de cualquier otro bien mueble en transporte publico individual (taxi)', 'Cualquier otro que no se
                encuentre precedido de privación de la libertad (secuestro exprés)'],
            'Robo en transporte publico colectivo' => ['Robo de bolso o cartera en transporte publico colectivo (microbús, bus, Metro, tren, avión, etcétera)', 'Robo de teléfono, aparato electronico o prenda en  transporte publico colectivo (microbús, bus, Metro, etcétera)', 'Robo de cualquier otro bien mueble en
                     transporte publico colectivo (microbús, bus, Metro, etcétera)', 'Robo a conductor y a pasajero'],
            'Robo en transporte individual' => ['bo de bolso o cartera cuando la víctima se encuentra en vehículo particular', 'Robo de teléfono, aparato electrónico o prenda cuando la víctima se encuentra en vehículo particular', 'Robo de cualquier otro bien mueble cuando la víctima se encuentra en vehículo particular',
                'Robo a conductor y a pasajero'],
            'Robo a institución bancaria' => ['Robo a banco o institución financiera', 'Robo de cajero'],
            'Robo a negocio' => ['Robo a tienda o establecimiento comercial y/o de servicios'],
            'Robo de ganado' => ['Robo de todo tipo de ganado', 'Robo de aves', 'Robo de abejas', 'Robo animales exóticos', 'Abigeato'],
            'Robo de maquinaria' => ['Robo de herramienta industrial o agrícola', 'Robo de tractores', 'Robo de cables, tubos y otros objetos destinados a servicios públicos'],
            'Otros robos' => ['Otros robos no considerados en las categorías 4.1.1 a 4.1.13', 'Robo de mascotas, entre otros', 'Robo de aeronaves'],
            'Fraudes' => ['Fraude', 'Estafa apropiarse ilícitamente de un bien o la obtención de lucro'],
            'Abuso de confianza' => ['Abuso de confianza'],
            'Extorsión' => ['Extorsión', 'Chantaje'],
            'Daño a la propiedad' => ['Destrucción o deterioro parcial o total de objeto mueble o inmueble'],
            'Despojo' => ['Ocupación ilegal de inmueble'],
            'Otros delitos contra el patrimonio' => ['Otros delitos contra el patrimonio no considerados en las categorías previas'],

            //v. Delitos que atentan contra la familia.
            'Violencia familiar' => ['Violencia física, sexual y/o emocional al interior de una familia'],
            'Violencia de genero en todas sus modalidades distinta a la violencia familiar' => ['Uso deliberado de la fuerza física, como amenaza o efectivo, contra personas o comunidades'],
            'Incumplimiento de obligaciones de asistencia familiar' => ['Dejar de dar la pensión alimenticia', 'Incumplimiento de la obligación alimentaría. Colocarse dolosamente en estado de insolvencia'],
            'Otros delitos contra la familia' => ['Otros delitos contra la familia'],

            //vi Delitos que atentan contra la sociedad.
            'Corrupción de menores' => [' Corrupción de menores', 'Concertar, permitir o encubrir el comercio carnal de menores de edad', 'Corrupción de menores o de personas privadas de la voluntad', 'Mantener en corrupción a un menor o incapaz', 'Explotación e inducción a la mendicidad de menores',
                'Lenocinio relacionado con menores', 'Permitir el acceso a menores o incapaces a exhibiciones o espectáculos obscenos'],
            'Trata de personas' => ['Esclavitud', 'Explotación sexual de menores', 'Condición de siervo', 'Prostitución ajena u otras formas de explotación sexual', 'Explotación laboral', 'Empleo de menores en cantinas, tabernas y centros de vicio', 'Trabajo o servicios forzados', 'Mendicidad forzosa',
                'Utilización de personas menores de dieciocho años en actividades delictivas', 'Adopción ilegal de persona menor de dieciocho años', 'Matrimonio forzoso o servil', 'Tráfico de órganos, tejidos y células de seres humanos vivos', 'Experimentación biomédica ilícita en seres humanos', 'Explotación laboral de menores o incapaces',
                'Pornografía infantil', 'Turismo sexual con personas menores de edad o de quienes no tienen capacidad para comprender el significado del hecho'],
            'Otros delitos contra la sociedad' => ['Proporcionar inmuebles destinados al comercio carnal', 'Explotación de grupos socialmente desfavorecidos', 'Inducción a la mendicidad'],

            //vii Delitos que atentan contra otros bienes jurídicos afectados (del fuero común).
            'Narcomenudeo' => ['Venta/compra de drogas'],
            'Amenazas' => ['Amenazas', 'Intimidación'],
            'Allanamiento de morada' => ['Introducción ilegal a inmueble sin permiso'],
            'Evasión de preso(s)' => ['Favorecer la fuga, ya sea por acción u omisión', 'Procure o auxilie al fugado'],
            'Falsedad' => ['Mentir en acto ante autoridad publica', 'Ocultar la verdad en acto ante autoridad publica'],
            'Falsificación' => ['Alteración o reproducción apócrifa de documentación pública y/o privada', 'Imitación de sellos y/o cuños oficiales', 'Desaparición de los elementos señalados, para la obtención de beneficio indebido o causar daño'],
            'Contra el medio ambiente' => ['Invasión de áreas naturales protegidas de competencia estatal y/o municipal', 'Expulsión o descarga de contaminantes a la atmosfera y que dañen flora, fauna o ecosistemas de competencia estatal y/o municipal', 'Desecho de residuos sólidos y/o líquidos que afecten el suelo, subsuelo, mantos acuíferos, ríos, etcétera', 'Tala ilegal'],
            'Delitos cometidos por servidores públicos' => ['Actos de servidores públicos que contravengan normativas y afecten o tengan impacto en la ciudadanía', 'Actos contra la Administración y/o procuración de Justicia, entre otros', 'Desaparición forzada de personas', 'Tortura'],
            'Delitos electorales' => ['Actos que atenten contra el ejercicio electoral de los ciudadanos', 'Actos que atenten contra la equidad de los procesos electorales'],
            'Otros delitos del fuero común' => ['Otros delitos del fuero común no contemplados en este formato'],

        ];

        //Crea las categorias y subcategorias en la base de datos
        foreach ($categories as $categoryName => $subcategories) {
            $category = Category::create(['name' => $categoryName]); //Crea una nueva categoria

            foreach ($subcategories as $subcategoryName) {
                Subcategory::create([ //Crea una subcategoria asociada a la categria
                    'name' => $subcategoryName,
                    'category_id' => $category->id,
                ]);
            }
        }

    }
}
