<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_id');
            $table->string('entidad');
            $table->string('correo');
            $table->string('telefono');
            $table->string('solicitado_por');
            $table->string('cargo_solicita');
            $table->string('recibido_por')->nullable();
            $table->string('cargo_recibe')->nullable();
            $table->string('objeto_obra');
            $table->text('trabajos_realizar');
            $table->text('adicional')->nullable();
            $table->string('estado_solicitud');
            $table->timestamps();
            $table->foreign('servicio_id')->references('id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
