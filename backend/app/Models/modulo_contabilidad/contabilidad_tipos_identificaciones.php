<?php

namespace App\Models\modulo_contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contabilidad_tipos_identificaciones extends Model
{
    use HasFactory;
    protected $table = "contabilidad_tipos_identificaciones";
    protected $primaryKey = "id";
}
