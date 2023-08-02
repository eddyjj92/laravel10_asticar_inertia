<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getImages(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => Imagen::all()]);
    }
}
