<?php

namespace App\Models\Sagrilaft;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagrilaftEmpleadoRecursos extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "sagrilaft_empleado_recursos";
    protected $fillable = [
        "path",
        "empleado_rel_url_id"
    ];
}
