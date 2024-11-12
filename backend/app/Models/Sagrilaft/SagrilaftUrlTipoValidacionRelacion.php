<?php

namespace App\Models\Sagrilaft;

use App\Data\Dtos\Sagrilaft\Validacion\Url\Response\SagrilaftUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagrilaftUrlTipoValidacionRelacion extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "sagrilaft_urls_tipos_validacion_rel";
    protected $fillable = ["url_id", "tipo_validacion_id"];

    public function sagrilaftUrl()
    {
        return $this->belongsTo(SagrilaftUrl::class, 'id', 'url_id');
    }

    public function sagrilaftValidaciones()
    {
        return $this->hasMany(SagrilaftUrlTipoValidacion::class, 'id', 'tipo_validacion_id');
    }
}
