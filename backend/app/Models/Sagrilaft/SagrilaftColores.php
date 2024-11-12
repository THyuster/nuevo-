<?php

namespace App\Models\Sagrilaft;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagrilaftColores extends Model
{
    use HasFactory;
    protected $table = "sagrilaft_colores";
    protected $primaryKey = "id";

    protected $fillable = [
        "descripcion",
        "color"
    ];
}
