<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionsTableSeeder extends Seeder
{
    public function run(): void
    {
        Institution::insert([
            ['name' => 'Guardia Nacional'],
            ['name' => 'Policía Federal Ministerial'],
            ['name' => 'Policía Ministerial'],
            ['name' => 'Policía Mando Único'],
            ['name' => 'Policía Estatal'],
            ['name' => 'Policía Municipal'],
        ]);
    }
}
