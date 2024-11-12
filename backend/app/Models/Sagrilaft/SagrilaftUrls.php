<?php

namespace App\Models\Sagrilaft;

// use App\Data\Dtos\Sagrilaft\Validacion\Url\Response\SagrilaftUrlRelacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagrilaftUrls extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "sagrilaft_urls";
    protected $fillable = [
        "descripcion"
    ];
    public function urls()
    {
        return $this->hasMany(SagrilaftUrlRelacion::class, 'sagrilaftUrlId', 'id');
    }

    public function tipoValidaciones()
    {
        return $this->belongsTo(SagrilaftUrlTipoValidacionRelacion::class, 'id', 'url_id')->with(['sagrilaftValidaciones']);
    }
}
