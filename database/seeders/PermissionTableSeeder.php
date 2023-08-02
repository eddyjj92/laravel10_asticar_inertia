<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Comando para Correr el Seeder*/
        /*php artisan db:seed --class=PermissionTableSeeder*/
        $permissions = [
            'ver-config', 'editar-config',
            'ver-rol','crear-rol','editar-rol','eliminar-rol',
            'ver-usuario','crear-usuario','editar-usuario','editar-usuario(perfil)','eliminar-usuario','banear-usuario',
            'ver-servicio','crear-servicio','editar-servicio','eliminar-servicio','habilitar-servicio',
            'ver-solicitud(todas)','ver-solicitud(usuario)','crear-solicitud','editar-solicitud','eliminar-solicitud',
            'ver-noticia','crear-noticia','editar-noticia','eliminar-noticia',
            'ver-imagen','crear-imagen','eliminar-imagen',
            'ver-mensaje','eliminar-mensaje',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
