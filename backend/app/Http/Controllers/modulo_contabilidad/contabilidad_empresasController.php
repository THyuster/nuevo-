<?php

namespace App\Http\Controllers\modulo_contabilidad;


use App\Http\Controllers\Controller;
use App\Http\Requests\modulo_contabilidad\CompaniesValidation;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\Constantes\ModuloContabilidad\SqlThird;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\moduloContabilidad\Companies;
use App\Utils\TypesAdministrators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class contabilidad_empresasController extends Controller
{
    protected $companies;
    protected $repositoryDynamicsCrud, $nameDataBase, $sqlCompanies, $sqlThird;
    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->companies = new Companies;
        $this->sqlCompanies = new SqlCompanies;
        $this->sqlThird = new SqlThird;
        $this->nameDataBase = "contabilidad_empresas";
    }

    public function index()
    {
        $companieGroups = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_grupo_empresarial");
        // $terceros = $this->repositoryDynamicsCrud->sqlFunction($this->sqlThird->getThirdsWithoutDv());
        return view("modulo_contabilidad.empresas.index", compact("companieGroups"));
    }
    public function getUser()
    {


        if (!Auth::check()) {
            throw new \Exception("Usuario no logueado", 401);
        }
        return Auth::user();
    }



    public function validatePermission($idPermisos)
    {
        $user = $this->getUser();
        $adminType = $user->tipo_administrador;

        if ($adminType != $idPermisos) {
            throw new \Exception("Acceso denegado no tiene permisos", 403);
        }
        return true;
    }

    public function create(CompaniesValidation $request)
    {
        // $this->validatePermission(2);
        return $this->companies->create($request);
    }

    public function show()
    {
        // $this->validatePermission();
        return $this->repositoryDynamicsCrud->sqlFunction(
            $this->sqlCompanies->getSqlCompanieAndRelationThird()
        );
    }


    public function update(CompaniesValidation $request, string $id)
    {
        // $this->validatePermission(1);
        return $this->companies->update($id, $request);
    }


    public function destroy(string $id)
    {
        // $this->validatePermission(TypesAdministrators::SUPER_ADMIN);
        return $this->companies->delete($id);
    }
    public function updateStatus(string $id)
    {
        // $this->validatePermission(1);
        return $this->companies->updateStatus($id);
    }

    public function getCompanies()
    {
        return
            $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM contabilidad_empresas");
    }
}