<?php

namespace App\Models\modulo_mantenimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{
    use HasFactory;
    protected $table = "mantenimiento_ordenes";
    protected $primaryKey = "id";
    protected $fillable = [
        "solicitud_id",
        "user_id",
        "id_orden"
    ];
}
