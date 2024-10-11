<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; // Importar el modelo User

class RolesAndPermissionsSeeder extends Seeder{

    public function run(): void{

        // Definir permisos
        $permissions = ['create reports', 'edit reports', 'delete reports', 'view reports'];
        // Crear y asignar permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear rol de Fiscal General y asignar permisos
        $fiscalGeneral = Role::firstOrCreate(['name' => 'Fiscal General']);
        $fiscalGeneral->syncPermissions($permissions);

        // Crear fiscales especializados
        $fiscalesEspecializados = [
            'Fiscal Homicidio',
            'Fiscal Lesiones',
            'Fiscal Feminicidio',
            'Fiscal Secuestro',
            'Fiscal Robo',
            'Fiscal Delitos Sexuales',
            'Fiscal Delitos Patrimoniales',
        ];

        foreach ($fiscalesEspecializados as $fiscalRole) {
            Role::firstOrCreate(['name' => $fiscalRole]);
        }

        // Crear usuario Fiscal General (admin) si no existe
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Busca el usuario por su email
            [
                'name' => 'Admin',
                'password' => bcrypt('password'), // Cambia la contraseña si es necesario
            ]
        );

        // Asignar rol de Fiscal General al usuario
        if (!$user->hasRole('Fiscal General')) {
            $user->assignRole($fiscalGeneral);
        }
    }
}
