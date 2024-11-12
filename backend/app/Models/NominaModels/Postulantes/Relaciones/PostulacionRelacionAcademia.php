<?php

namespace App\Models\NominaModels\Postulantes\Relaciones;

use App\Models\NominaModels\Postulantes\PostulanteAcademia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionRelacionAcademia extends Model
{
    use HasFactory;
    protected $table = "nomina_postulantes_rel_academia";
    protected $primaryKey = "id";
    protected $fillable = [
        "postulante_id",
        "academica_id"
    ];

    public function academia()
    {
        return $this->belongsTo(PostulanteAcademia::class, 'academica_id');
    }
}
