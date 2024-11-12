<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesAsignar extends Model
{
    use HasFactory;

    protected $connection = 'app';
    protected $table = "roles_permiso";
    protected $fillable = ['roles_id', 'permisos_crud_id', 'vista_id', 'empresa_id'];

    protected $hidden = [
        'roles_permiso_id',
        'permisos_crud_id',
        'roles_id',
        'empresa_id',
        'created_at',
        'updated_at'
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['permisos'] = RolesPermisos::where('permisos_crud_id', $this->permisos_crud_id)->get();
        return $array;
    }



    public function getWithRoles()
    {
        return $this->with(['role'])->get();
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'roles_id');
    }

    public function permisos()
    {
        return $this->belongsTo(RolesPermisos::class, 'permisos_crud_id');
    }

}
