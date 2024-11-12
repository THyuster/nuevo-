<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesPermisos extends Model
{
    use HasFactory;


    protected $table = 'permisos_crud';

    protected $primaryKey = "permisos_crud_id";


    public function RolePermiso()
    {
        return $this->hasMany(RolesAsignar::class, 'permisos_crud_id');
    }
}
