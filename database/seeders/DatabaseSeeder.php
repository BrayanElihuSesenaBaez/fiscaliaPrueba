<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{

    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        //Si se llama solamente el comando de ' sail artisan db:seed' llama los seeders creados que se encuentran dentro de esta funcion
        $this->call(CategorySeeder::class);
    }
}
