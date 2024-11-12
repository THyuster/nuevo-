<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class erp_roles_asignado_usuario extends Model
{
    use HasFactory;

    protected $table = 'erp_roles_asignado_usuario';
    protected $primaryKey = "erp_roles_asignado_usuario_id";
    protected $fillable = ['role_id', 'user_id'];

    protected $hidden = [
        'role_id',
        'user_id',
        'erp_roles_asignado_usuario_id',
        'created_at',
        'updated_at'
    ];



    public function getWithRolesAndUsers()
    {
        return $this->with(['role', 'user'])->get();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

}
