<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Erp\AdminUserRequest\AdminUserRequestUpdateStatusCompanie;
use App\Http\Requests\Erp\AdminUserValidation;
use App\Utils\Constantes\Erp\SqlAdminUser;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\AdminUser;
use App\Utils\TypesAdministrators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class erp_AdminUserController extends Controller
{

    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    private AdminUser $adminUser;
    private $sqlAdminUser;


    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, AdminUser $adminUser)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->adminUser = $adminUser;
        $this->sqlAdminUser = new SqlAdminUser;
    }

    public function getUser()
    {
        return Auth::check() ?
            Auth::user()
            : throw new \Exception("No esta logueado", 403);
    }

    public function validatePermission()
    {
        $user = $this->getUser();
        $adminType = $user->tipo_administrador;

        if ($adminType != TypesAdministrators::ADMINISTRATOR_BUSINESS_GROUP) {
            throw new \Exception("Acceso denegado no tiene permisos", 403);
        }
        return true;
    }

    public function index()
    {
        $clients = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_grupo_empresarial");
        return view("superAdmin.administrador_general.index", compact("clients"));
    }

    public function create(AdminUserValidation $request)
    {
        $this->validatePermission();
        return $this->adminUser->create($request->all());
    }



    public function show($clientId)
    {
        $this->validatePermission();

        $sql = $this->sqlAdminUser->getSqlDataUsersByCompanie($clientId);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        return $this->adminUser->dataMapper($response);
    }


    public function update(Request $request, string $id)
    {
        $this->validatePermission();
        return $this->adminUser->update($id, $request->all());
    }


    public function destroy(Request $request, string $id)
    {
        $this->validatePermission();
        $request->validate(['companieId' => 'required|int'], __("messages.validation"));

        $data = $request->all();
        return $this->adminUser->delete($id, $data['companieId']);
    }

    public function updateStatus(string $id)
    {
        $this->validatePermission();
        return $this->adminUser->statusUpdate($id);
    }

    public function updateStatusByCompanie(AdminUserRequestUpdateStatusCompanie $adminUserRequestUpdateStatusCompanie)
    {
        $this->validatePermission();
        // 
        // return $adminUserRequestUpdateStatusCompanie->all();
        $array = $adminUserRequestUpdateStatusCompanie->all();
        return $this->adminUser->statusUpdateByRelationByUserAdmin($array['relacion_id']);
    }
    public function getCompanies()
    {
        $user = $this->getUser();
        $sql = $this->sqlAdminUser->sqlgetCompaniesByUser($user->id);
        return $this->repositoryDynamicsCrud->sqlFunction($sql, 1);
    }
}
