<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GruposEmpresariales extends Model
{
    use HasFactory;

    protected $table = 'erp_grupo_empresarial';
    protected $connection = "app";
}