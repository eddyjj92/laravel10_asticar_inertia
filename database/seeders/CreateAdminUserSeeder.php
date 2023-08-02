<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Comando para Correr el Seeder*/
        /*php artisan db:seed --class=CreateAdminUserSeeder*/
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@asticar.cu',
            'telefono' => '12345678',
            'entidad' => 'ASTICAR',
            'ocupacion' => 'Administrador de Sistemas',
            'habilitado' => true,
            'imagen' => 'user.png',
            'conexion' => '[]',
            'password' => bcrypt('qwerty'),
        ]);

        $role = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
