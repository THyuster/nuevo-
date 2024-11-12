<?php

namespace App\Models\Sagrilaft;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagrilaftUrlTipoValidacion extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "sagrilaft_urls_tipos_validacion";
    // protected $fillable = [];
}
