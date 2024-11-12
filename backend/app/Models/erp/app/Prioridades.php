<?php

namespace App\Models\erp\app;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prioridades extends Model
{
    use HasFactory;
    protected $table = "prioridades";
    protected $connection = "app";
    protected $primaryKey = "id";
}
