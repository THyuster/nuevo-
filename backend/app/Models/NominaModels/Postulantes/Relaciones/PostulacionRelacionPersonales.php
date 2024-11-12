<?php

namespace App\Models\NominaModels\Postulantes\Relaciones;

use App\Models\NominaModels\Postulantes\PostulacionPersonales;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionRelacionPersonales extends Model
{
    use HasFactory;

    protected $table = "nomina_postulantes_rel_personales";
    protected $fillable = [
        "postulante_id",
        "personales_id"
    ];

    public function personales()
    {
        return $this->belongsTo(PostulacionPersonales::class, 'personales_id', 'id');
    }
}
