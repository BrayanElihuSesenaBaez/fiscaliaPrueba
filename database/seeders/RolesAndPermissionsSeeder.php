<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; // Importar el modelo User

class RolesAndPermissionsSeeder extends Seeder{

    //Crea roles y permisos en la base de datos

    public function run(): void{

        // Se definen los permisos disponibles
        $permissions = ['create reports', 'edit reports', 'delete reports', 'view reports'];

        // Se crean y se asignan los permisos a la base de datos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);//Se crea el permiso si no existe
        }

        // Se crea el rol de 'Fiscal General' y se asignan sus permisos
        $fiscalGeneral = Role::firstOrCreate(['name' => 'Fiscal General']);
        $fiscalGeneral->syncPermissions($permissions); //Se asignan todos los permisos al rol

        // Roles para fiscales especializados
        $fiscalesEspecializados = [
            'Fiscal Homicidio',
            'Fiscal Lesiones',
            'Fiscal Feminicidio',
            'Fiscal Secuestro',
            'Fiscal Robo',
            'Fiscal Delitos Sexuales',
            'Fiscal Delitos Patrimoniales',
        ];

        //Creacion de roles para fiscales especializados
        foreach ($fiscalesEspecializados as $fiscalRole) {
            Role::firstOrCreate(['name' => $fiscalRole]);
        }

        // Crear usuario Fiscal General (admin) si no existe
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Busca el usuario por su email
            [
                'name' => 'Admin',
                'password' => bcrypt('password'), // Contraseña encriptada para el usuario
            ]
        );

        // Asignar rol de Fiscal General al usuario
        if (!$user->hasRole('Fiscal General')) {
            $user->assignRole($fiscalGeneral);
        }
    }
}
