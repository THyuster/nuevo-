<?php

namespace App\Models\NominaModels\Postulantes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionFamiliares extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_postulantes_familiares";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "nombre_completo",
        "telefono",
        "direccion",
        "parentesco",
        "cedula"
    ];
}
