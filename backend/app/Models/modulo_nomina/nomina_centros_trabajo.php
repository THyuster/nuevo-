<?php

namespace App\Models\modulo_nomina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nomina_centros_trabajo extends Model
{
    use HasFactory;
    protected $table = "nomina_centros_trabajos";
    protected $primaryKey = "id";
}
