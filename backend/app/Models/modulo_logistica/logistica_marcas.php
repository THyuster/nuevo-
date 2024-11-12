<?php

namespace App\Models\modulo_logistica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logistica_marcas extends Model
{
    use HasFactory;
    protected $table = "logistica_marcas";
    protected $primaryKey = "id";
    protected $fillable = ["descripcion"];
}
