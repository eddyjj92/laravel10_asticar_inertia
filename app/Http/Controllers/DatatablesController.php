<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatatablesController extends Controller
{
    public function datatables_es(){
        return response()->file(public_path('img/datatables/es-ES.json'));
    }
}
