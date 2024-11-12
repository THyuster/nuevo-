<?php

namespace App\Models\Sagrilaft;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagrilaftUrlRelacion extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "sagrilaft_url_rel";
    protected $fillable = [
        "sagrilaftUrlId",
        "url",
        "principal"
    ];
    
}
