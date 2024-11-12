<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\accountingModule\ModuleAssignmentValidation;
use App\Utils\CatchToken;
use App\Utils\Constantes\ConstantConsultations;
use App\Utils\Constantes\Erp\SqlUsers;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\AdminUser;
use App\Utils\TransfersData\ModuloConfiguracion\ConsultasModulos;
use App\Utils\TypesAdministrators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class erp_permisos_modulosController extends Controller
{
    protected $function;
    protected $consulta, $repositoryDynamicsCrud;
    protected $encrypt, $myFunctions, $sqlConsultas, $consultasModulos;
    private $sqlUser, $catchToken, $adminUser;

    public function __construct(
        ConsultasModulos $consulta,
        RepositoryDynamicsCrud $function,
        EncryptionFunction $encryption,
        MyFunctions $myFunctions,
        ConstantConsultations $sqlConsultas,
        ConsultasModulos $consultasModulos,
        RepositoryDynamicsCrud $repositoryDynamicsCrud
    ) {
        $this->function = $function;
        $this->consulta = $consulta;
        $this->encrypt = $encryption;
        $this->myFunctions = $myFunctions;
        $this->sqlConsultas = $sqlConsultas;
        $this->consultasModulos = $consultasModulos;
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->sqlUser = new SqlUsers;
        $this->adminUser = new AdminUser;
        $this->catchToken = new CatchToken;
    }

    public function index()
    {

        // if (MyFunctions::validar_superadmin() === true) {
        $usuarios = ($this->myFunctions->checkAdmin())
            ? $this->function->sqlFunction($this->sqlConsultas->getSqlAdmin())
            : $this->function->sqlFunction($this->sqlConsultas->getSqlNotAdmin());

        $users = $this->function->sqlFunction($this->sqlConsultas->getUserActive());

        $modulos = $this->function->getInfoAllOrById('erp_modulos', [], '*');

        return view('modulo_configuracion/usuarios_modulos/index', compact('usuarios', 'modulos', 'users'));
    }


    public function create(Request $request)
    {
        $this->validatePermission();
        // if (MyFunctions::validar_superadmin() === true) {

        return $this->consulta->insertData($request->all());
        // }
    }

    public function update(ModuleAssignmentValidation $request, string $id)
    {
        $this->validatePermission();
        // if (MyFunctions::validar_superadmin() === true) {
        return $this->consultasModulos->updateModule($request->all(), $id);
        // }
    }

    public function ObtenerUsuariosPermisos()
    {
        $empresaId = $this->catchToken->Claims();
        $sql = $this->sqlUser->getSqlDataUsersPermisos($empresaId);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    public function ObtenerUsuarioEmpresa()
    {
        $empresaId = $this->catchToken->Claims();
        $sql = $this->sqlUser->getSqlDataUsers($empresaId);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    public function ObtenerModulosEmpresa()
    {
        $empresaId = CatchToken::Claims();

        $query = "SELECT erp_modulos.id, erp_modulos.descripcion FROM erp_modulos 
        INNER JOIN `erp_relacion_licencias` ON erp_modulos.id = erp_relacion_licencias.modulo_id 
        INNER JOIN `contabilidad_empresas` ON contabilidad_empresas.id = erp_relacion_licencias.empresa_id 
        WHERE (erp_relacion_licencias.empresa_id = '$empresaId' AND erp_modulos.descripcion <> 'Configuracion')";

        return $this->function->sqlFunction($query);
        // return $this->function->getInfoAllOrById('erp_modulos', [], '*');
    }

    public function show($empresaId)
    {
        // $this->validatePermission();
        // if (MyFunctions::validar_superadmin() === true) {
        $sql = $this->sqlConsultas->sqlObtenerModulosPorLicencia($empresaId);
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
        // }
    }
    public function destroy($id)
    {
        // $this->validatePermission();
        // if (MyFunctions::validar_superadmin() === true) {
        return $this->consultasModulos->deleteData($id);
        // }
    }
    public function changeStatus($id)
    {
        $this->validatePermission();
        return $this->consultasModulos->cambiarEstado($id);
    }

    public function test()
    {
        return view('modulo_configuracion/test/index');
    }

    public function getUser()
    {


        if (!Auth::check()) {

            throw new \Exception("Usuario no logueado", 401);
        }
        return Auth::user();
    }


    private function validatePermission()
    {
        $user = $this->getUser();
        $adminType = $user->tipo_administrador;

        if ($adminType != TypesAdministrators::COMPANY_ADMINISTRATOR) {
            throw new \Exception("Acceso denegado no tiene permisos", 403);
        }

        return true;
    }
}
