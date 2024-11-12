<?php

namespace App\Models\NominaModels\Postulantes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionPersonales extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_postulantes_personales";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "nombre_completo",
        "telefono",
        "direccion",
        "relacion",
        "cedula"
    ];
}
