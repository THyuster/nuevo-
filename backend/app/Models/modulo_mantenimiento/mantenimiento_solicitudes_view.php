<?php

namespace App\Models\modulo_mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mantenimiento_solicitudes_view extends Model
{
    use HasFactory;
    protected $table = "mantenimiento_solicitudes_view";
    protected $primaryKey = "id";
}
