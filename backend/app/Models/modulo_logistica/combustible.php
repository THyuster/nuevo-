<?php

namespace App\Models\modulo_logistica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class combustible extends Model
{
    use HasFactory;
    protected $table = "logistica_combustibles";
    protected $primaryKey = "id";
}
