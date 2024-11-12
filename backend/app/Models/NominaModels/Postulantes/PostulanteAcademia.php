<?php

namespace App\Models\NominaModels\Postulantes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulanteAcademia extends Model
{
    use HasFactory, HasUuids;
    protected $table = "nomina_postulantes_academica";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "institucion",
        "titulo_obtenido",
        "fecha_inicial",
        "fecha_final",
        "ciudad"
    ];
}
