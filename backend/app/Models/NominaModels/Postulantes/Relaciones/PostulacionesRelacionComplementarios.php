<?php

namespace App\Models\NominaModels\Postulantes\Relaciones;

use App\Models\NominaModels\Postulantes\PostulanteComplementarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionesRelacionComplementarios extends Model
{
    use HasFactory;
    protected $table = "nomina_postulantes_rel_complementarios";
    protected $fillable = [
        "postulante_id",
        "complementarios_id"
    ];
    public function complementarios(){
        return $this->belongsTo(
            PostulanteComplementarios::class,
            'complementarios_id',
            'id'
        );
    }
}
