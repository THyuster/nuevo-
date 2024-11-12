<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuario_confirmacion_empresa extends Model
{
    use HasFactory;

    protected $table = 'usuario_confirmacion_empresa';

    protected $primary_key = "usuario_confirmacion_empresa_id";

    protected $connection = "app";


    

}
