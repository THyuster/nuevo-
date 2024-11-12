<?php

namespace App\Http\Controllers\modulo_superadmin;

use App\Data\Dtos\UsuariosDto;
use App\Data\Models\UsuarioModel;
use App\Http\Controllers\Controller;
use App\Utils\AuthUser;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloSuperAdmin\ISuAdminService;
use Illuminate\Http\Request;

class superadminController extends Controller
{
    private AuthUser $_users;
    private RepositoryDynamicsCrud $_repository;
    private ISuAdminService $_suAdminService;

    private EncryptionFunction $_encriptacion;
    public function __construct(EncryptionFunction $encryptionFunction, RepositoryDynamicsCrud $repositoryDynamicsCrud, AuthUser $users, ISuAdminService $iSuAdminService)
    {
        $this->_repository = $repositoryDynamicsCrud;
        $this->_users = $users;
        $this->_suAdminService = $iSuAdminService;
        $this->_encriptacion = $encryptionFunction;
    }
    public function index()
    {
        if (!MyFunctions::validar_superadmin()) {
            return view("welcome");
        }

        $loggedInUser = $this->_users->getUsuariosLogin();

        $otherUsers = $this->_repository->sqlFunction("SELECT * FROM users WHERE `id` <> '{$loggedInUser->getId()}' AND `tipo_administrador`<>'2' AND `name` <> 'API_FILES_USER'  ");

        $typesUser = $this->_repository->sqlFunction("SELECT id_tipo_administrador, tipo_administrador FROM `tipo_administrador`");

        $usuarios = array_map(function ($user) {
            $usuario = new UsuarioModel($user->id, $user->name, $user->email, $user->tipo_administrador, $user->estado, null);
            $usuarioDto = new UsuariosDto($usuario);
            return $usuarioDto->jsonSerialize();
        }, $otherUsers);

        return view("superAdmin.super_administrador.index", compact('usuarios', 'typesUser'));
    }

    public function create(Request $usuario)
    {
        $usuario = new UsuarioModel(null, $usuario->nombre, $usuario->email, null, null, $usuario->password);
        $usuario = $this->_suAdminService->crearAdmin($usuario);

        return response(["mensaje" => $usuario], 200, [
            'Accept' => 'Application/json',
            'Content-type' => 'Application/json',
        ]);
    }

    public function show()
    {
        $loggedInUser = $this->_users->getUsuariosLogin();
        $otherUsers = $this->_repository->sqlFunction("SELECT * FROM users WHERE `id` <> '{$loggedInUser->getId()}' AND `name` <> 'API_FILES_USER' AND `tipo_administrador`='2'");

        $usuarios = array_map(function ($user) {
            $usuario = new UsuarioModel($user->id, $user->name, $user->email, $user->tipo_administrador, $user->estado, null);
            $usuarioDto = new UsuariosDto($usuario);
            $usuarioDto = $usuarioDto->jsonSerialize();
            return [
                "id" => $this->_encriptacion->Encriptacion($usuarioDto["id"]),
                "Nombre" => $usuarioDto["name"],
                "tipo administrador" => $usuarioDto["entidad_administrador"]["tipo_administrador"],
                "Correo Electronico" => $usuarioDto["email"]
            ];
        }, $otherUsers);

        return $usuarios;
    }

    public function destroy($id)
    {
        return response([
            "mensaje" => $this->_suAdminService->eliminarSuAdmin($id)
        ]);
    }

}