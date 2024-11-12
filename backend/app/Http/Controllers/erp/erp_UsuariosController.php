<?php

namespace App\Http\Controllers\erp;

use App\Data\Dtos\Usuario\UsuarioCreateDTO;
use App\Data\Dtos\Usuario\UsuarioCreateRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Erp\UserValidation;
use App\Utils\CatchToken;
use App\Utils\Constantes\Erp\SqlUsers;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\AdminUser;
use App\Utils\TransfersData\Erp\Users;
use App\Utils\TypesAdministrators;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class erp_UsuariosController extends Controller
{

    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    private Users $user;

    private $sqlUser, $catchToken, $adminUser;


    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, Users $user)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->user = $user;
        $this->sqlUser = new SqlUsers;
        $this->adminUser = new AdminUser;
        $this->catchToken = new CatchToken;
    }


    public function getUser()
    {
        return Auth::check() ? Auth::user() : "No logueado";
    }

    public function validatePermission()
    {
        $user = $this->getUser();
        $adminType = $user->tipo_administrador;

        if ($adminType != TypesAdministrators::COMPANY_ADMINISTRATOR) {
            if ($user->tipo_administrador == TypesAdministrators::USER && $user->tipo_cargo == 2) {
                return true;
            }
            throw new Exception("Acceso denegado no tiene permisos", Response::HTTP_UNAUTHORIZED);
        }
        return true;
    }


    public function index()
    {
        $clients = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_grupo_empresarial");
        return view("superAdmin.administrador_general.index", compact("clients"));
    }


    public function create(UserValidation $userValidation)
    {
        $this->validatePermission();
        $usuarioCreateDTO = UsuarioCreateRequestDTO::fromArray($userValidation->all());
        return $this->user->create($usuarioCreateDTO);
    }

    public function show()
    {
        $this->validatePermission();
        $empresaId = $this->catchToken->Claims();
        $sql = $this->sqlUser->getSqlDataUsers($empresaId);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }


    public function update(Request $request, string $id)
    {
        $this->validatePermission();
        return $this->user->update($id, $request->all());
    }


    public function destroy(string $id)
    {
        $this->validatePermission();

        $user = $this->getUser();
        if ($user->tipo_administrador == TypesAdministrators::USER) {
            throw new Exception("No tiene permisos para eliminar", 403);
        }
        return $this->user->delete($id);
    }

    public function updateStatus(string $id)
    {
        $this->validatePermission();
        return $this->user->statusUpdate($id);
    }

    public function updateStatusByCompanie(string $id)
    {
        $this->validatePermission();
        return $this->adminUser->statusUpdateByCompanie($id);
    }
     public function showSinValidate()
    {
        $empresaId = $this->catchToken->Claims();
        $sql = $this->sqlUser->getSqlDataUsers($empresaId);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

}