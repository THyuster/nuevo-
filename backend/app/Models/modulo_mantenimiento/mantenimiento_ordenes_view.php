<?php

namespace App\Models\modulo_mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mantenimiento_ordenes_view extends Model
{
    use HasFactory;
    protected $table = "mantenimiento_ordenes_view";
    protected $primaryKeys = "id";
}
