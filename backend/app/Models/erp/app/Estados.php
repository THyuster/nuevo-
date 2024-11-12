<?php

namespace App\Models\erp\app;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    use HasFactory;
    protected $connection = "app";
    protected $table = "estados";

}
