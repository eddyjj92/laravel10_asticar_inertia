<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\{Importable, ToModel, WithHeadingRow};
use Spatie\Permission\Models\Role;

class UsersImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User();
        $user->name = $row['nombre'];
        $user->email = 'sdfhsdjh@gksdfg.cu';
        $user->password = bcrypt($row['contrasena']);
        $user->telefono = $row['telefono'];
        $user->entidad = $row['entidad'];
        $user->ocupacion = $row['ocupacion'];
        $user->imagen = 'user.png';

        $role = Role::findByName('prueba');
        $user->assignRole([$role->id]);
        return $user;
    }
}

