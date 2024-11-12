<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Erp\AdminValidation;
use App\Utils\Constantes\Erp\SqlAdmin;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\Admin;
use App\Utils\TypesAdministrators;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class erp_AdminController extends Controller
{

    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    private Admin $admin;
    private $sqlAdmin;


    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, Admin $admin)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->admin = $admin;
        $this->sqlAdmin = new SqlAdmin;
    }
    public function index()
    {
        $clients = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_grupo_empresarial");
        return view("superAdmin.administrador_general.index", compact("clients"));
    }

    public function getUser()
    {
        return Auth::user();
    }

    public function validatePermission()
    {
        $user = $this->getUser();
        $adminType = $user->tipo_administrador;

        if ($adminType != TypesAdministrators::SUPER_ADMIN) {
            throw new Exception(__("messages.permissionDeniedMessage"), Response::HTTP_UNAUTHORIZED);
        }
        return true;
    }

    public function create(AdminValidation $request)
    {
        $this->validatePermission();
        return $this->admin->create($request->all());
    }

    public function getData()
    {
        $sql = "SELECT usuario.id, usuario.name, usuario.email,e.descripcion,e.id AS cliente_id, usuario.estado FROM erp_relacion_user_cliente INNER JOIN mla_erp_data.users usuario ON usuario.id = erp_relacion_user_cliente.user_id INNER JOIN erp_grupo_empresarial e ON e.id = erp_relacion_user_cliente.cliente_id WHERE usuario.tipo_administrador = 1";
        return  $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    public function show()
    {

        $user = $this->getUser();
        $id = $user->id;
        $data = $this->repositoryDynamicsCrud->sqlFunction($this->sqlAdmin->getSqlDataCompanieByLicence($id));
        return $this->admin->transferData($data);
    }


    public function update(Request $request, string $id)
    {
        $this->validatePermission();
        return $this->admin->update($id, $request->all());
    }


    public function destroy(string $id)
    {
        $this->validatePermission();
        return $this->admin->delete($id);
    }

    public function updateStatus(string $id)
    {
        $this->validatePermission();
        return $this->admin->statusUpdate($id);
    }
}
