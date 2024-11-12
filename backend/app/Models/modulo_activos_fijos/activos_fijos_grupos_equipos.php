<?php

namespace App\Models\modulo_activos_fijos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activos_fijos_grupos_equipos extends Model
{
    use HasFactory;
    protected $table = "activos_fijos_grupos_equipos";
    protected $primaryKey = "id";
    protected $fillable = [
        "codigo",
        "descripcion"
    ];
}
