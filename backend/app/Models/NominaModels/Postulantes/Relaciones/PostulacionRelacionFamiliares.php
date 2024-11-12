<?php

namespace App\Models\NominaModels\Postulantes\Relaciones;

use App\Models\NominaModels\Postulantes\PostulacionFamiliares;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionRelacionFamiliares extends Model
{
    use HasFactory;
    protected $table = "nomina_postulantes_rel_familiares";
    protected $fillable = [
        "postulante_id",
        "familiares_id"
    ];
    
    public function familiares(){
        return $this->belongsTo(PostulacionFamiliares::class,'familiares_id','id');
    }
}
