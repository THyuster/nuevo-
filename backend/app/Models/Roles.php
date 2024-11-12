<?php

namespace App\Models;

use App\Utils\Encryption\EncryptionFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = "erp_roles";
    protected $connection = 'app';
    protected $hidden = ['estado', 'updated_at', 'created_at',"permisos_asignados"];
    protected $fillable = ["descripcion"];

    public function toArray()
    {
        $array = parent::toArray();
        $array['permisos_asignados'] = RolesAsignar::where('roles_id', $this->id)->get();
        return $array;
    }


    public function RolesAsignar()
    {
        return $this->hasMany(RolesAsignar::class, 'role_id');
    }
    public function RolesAsignadosUsuario()
    {
        return $this->hasMany(erp_roles_asignado_usuario::class, 'role_id');
    }

}
