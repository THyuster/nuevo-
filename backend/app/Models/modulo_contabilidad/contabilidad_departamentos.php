<?php

namespace App\Models\modulo_contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contabilidad_departamentos extends Model
{
    use HasFactory;
    protected $table = "contabilidad_departamentos";
    protected $primaryKey = "id";
}
