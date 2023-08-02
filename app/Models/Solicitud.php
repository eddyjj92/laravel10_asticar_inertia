<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solicitud extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entidad',
        'correo',
        'telefono',
        'solicitado_por',
        'cargo_solicita',
        'recibido_por',
        'cargo_recibe',
        'objeto_obra',
        'trabajos_realizar',
        'adicional',
        'estado_solicitud',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    /**
     *Obtener el servicio al que pertenece una Solicitud.
     */
    public function servicio(): BelongsTo
    {
      return $this->belongsTo(Servicio::class);
    }

}
