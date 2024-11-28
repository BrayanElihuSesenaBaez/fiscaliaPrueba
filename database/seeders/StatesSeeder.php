<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\Municipality;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        // Desactivar restricciones de claves foráneas
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpia la tabla de estados, eliminando los duplicados
        \DB::table('states')->truncate();

        // Reactivar restricciones de claves foráneas
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $states = [
            'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 'Coahuila de Zaragoza', 'Colima','Chiapas', 'Chihuahua',
            'Ciudad de México', 'Durango', 'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'Estado de México', 'Michoacán de Ocampo', 'Morelos',
            'Nayarit', 'Nuevo León', 'Oaxaca', 'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa', 'Sonora', 'Tabasco',
            'Tamaulipas', 'Tlaxcala', 'Veracruz de Ignacio de la Llave', 'Yucatán', 'Zacatecas'
        ];

        foreach ($states as $stateName) {
            State::firstOrCreate(['name' => $stateName]);
        }
    }
}
