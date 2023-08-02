<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected $casts = [
        'habilitado' => 'boolean'
    ];

    /**
     *Obtener las solicitudes que pertenecen a un Servicio.
     */
    public function solicitudes(): HasMany
    {
      return $this->hasMany(Solicitud::class);
    }
}
