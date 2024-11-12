<?php

namespace App\Models\modulo_contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contabilidad_empresas extends Model
{
    use HasFactory;
    protected $connection = "app";
    protected $table = "contabilidad_empresas";
}
