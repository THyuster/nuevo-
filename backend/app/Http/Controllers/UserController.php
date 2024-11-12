<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Utils\MyFunctions;
use Illuminate\Routing\Controller;
use App\Utils\Repository\RepositoryDynamicsCrud;

class UserController extends Controller
{
    protected $repository;
    protected $funciones;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->funciones = new MyFunctions;
    }
    public function index()
    {
        $resultado = $this->funciones->validar_administrador();
        return ($resultado == 'SI') ? view('modulo_configuracion.usuarios.index') : view('welcome');
    }

    public function show()
    {
        $resultado = $this->funciones->validar_administrador();
        $sql = "SELECT `id`, `email`, `administrador`, `name`, `estado`  FROM users WHERE `tipo_administrador` = 1 OR `tipo_administrador` = 3";
        $data = $this->repository->sqlFunction($sql);
        return ($resultado == 'SI') ? $data : throw new Exception(__('messages.permissionDeniedMessage'), 1);
    }

    public function changeAdministrador($id)
    {
        $user = Auth::user();
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $UserModel = $this->repository->sqlFunction($sql);
        $resultado = $this->funciones->validar_administrador();
        $administrador = ($UserModel[0]->administrador == "SI") ? "NO" : "SI";
        $sqlUpdate = "UPDATE `users`SET administrador = '$administrador' WHERE `id` = '$id'";

        if ($resultado == 'SI') {
            if ($user->id == $UserModel[0]->id) {
                throw new Exception(__('messages.invalidActionMessage'), 1);
            }
            return $this->repository->sqlFunction($sqlUpdate);
        }
        throw new Exception(__('messages.permissionDeniedMessage'), 1);
    }
    public function changeStatus($id)
    {

        $user = Auth::user();
        $resultado = $this->funciones->validar_administrador();

        $sql = "SELECT * FROM users WHERE id = '$id'";
        $UserModel = $this->repository->sqlFunction($sql);
        $estado = ($UserModel[0]->estado == "ACTIVO") ? "INACTIVO" : "ACTIVO";
        $tipo_adminstrador = ($estado == 'ACTIVO') ? 1 : 3;
        $sqlUpdate = "UPDATE `users`SET estado = '$estado', tipo_administrador = $tipo_adminstrador WHERE `id` = '$id'";

        if ($resultado == 'SI') {
            if ($user->id == $UserModel[0]->id) {
                throw new Exception(__('messages.invalidActionMessage'), 1);
            }
            return $this->repository->sqlFunction($sqlUpdate);
        }
        throw new Exception(__('messages.permissionDeniedMessage'), 1);
    }
    public function destroy($id)
    {
        $user = Auth::user();
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $resultado = $this->funciones->validar_administrador();
        $UserModel = $this->repository->sqlFunction($sql);
        $sqlDelete = "DELETE FROM users WHERE `users`.`id` = '$id'";

        if ($resultado == 'SI') {
            if ($user->id == $UserModel[0]->id) {
                throw new Exception(__('messages.invalidActionMessage'), 1);
            }
            return $this->repository->sqlFunction($sqlDelete);
        }
        throw new Exception(__('messages.permissionDeniedMessage'), 1);

    }
    public function languajeTest() {
        return __('messages.welcome');
    }
}