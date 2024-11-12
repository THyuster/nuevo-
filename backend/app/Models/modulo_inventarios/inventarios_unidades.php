<?php

namespace App\Models\modulo_inventarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventarios_unidades extends Model
{
    use HasFactory;
    protected $table = "inventarios_unidades";
    protected $primaryKey = "id";
}
