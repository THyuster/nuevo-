<?php

namespace App\Models\modulo_contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contabilidad_terceros extends Model
{
    use HasFactory;
    protected $table = "contabilidad_terceros";
    protected $primaryKey = "id";
}
