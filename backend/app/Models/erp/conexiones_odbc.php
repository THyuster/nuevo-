<?php

namespace App\Models\erp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conexiones_odbc extends Model
{
    use HasFactory;
    protected $connection = "app";
    protected $table = "conexiones_odbc";
    protected $primaryKey = "id";
}
