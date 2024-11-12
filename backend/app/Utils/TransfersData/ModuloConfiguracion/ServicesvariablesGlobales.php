<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use App\Utils\CatchToken;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloConfiguracion\VariablesGlobales;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TypesAdministrators;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class ServicesvariablesGlobales implements IvariablesGlobales
{
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    private string $_tableDb, $date, $_tablDBModulos, $_tablaDBEmpresa, $_tablaRespuestaVariablesGlb, $_tablaRespuestaMantenimiento;
    private CatchToken $catchToken;
    private VariablesGlobales $constantesVariables;
 

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->_tablDBModulos = tablas::getTablaErpModulo();
        $this->_tableDb = tablas::getTablaErpVariablesGlobales();
        $this->_tablaDBEmpresa = tablas::getTablaContabilidadEmpresas();
        $this->_tablaRespuestaVariablesGlb = tablas::getTablaClienteRespuestaVariablesGlobales();
        $this->_tablaRespuestaMantenimiento = tablas::getTablaErpMantenimientoRespuesta();

        $this->catchToken = new CatchToken;
        $this->constantesVariables = new VariablesGlobales;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;



    }

    public function listarVariableGlobal(): array
    {
        $user = Auth::user();
 
        
        $sql = "";
        if ($user->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR) {
            $empresaLogueado = $this->catchToken->Claims();
            $sql = $this->constantesVariables->sqlGetVariablesConRespuestaConEmpresaLogueado($empresaLogueado);

        } else if ($user->tipo_administrador == TypesAdministrators::SUPER_ADMIN) {
            
            $sql = $this->constantesVariables->sqlGetVariablesConRespuesta();
        }
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        return array_map(function ($variable) {
            $variable->id = base64_encode($this->encriptarKey($variable->id));
            return $variable;
        }, $response);
    }

    public function crearVariableGlobal(array $entidad)
    {
        
      
        try {
            $this->buscarModuloId($entidad['modulo_id']);
            $this->buscarTipoRespuestaId($entidad['tipo_respuesta']);
            $this->buscarPorNombre($entidad['nombre']);
            $empresasRespuesta = $this->obtenerEmpresas();
            $usuarioLogueado = Auth::user();
            $this->validarAdministradorConTipoVariable($usuarioLogueado, $entidad);

            $valorRespuesta = isset($entidad['valor']) ? $entidad['valor'] : null;
            unset($entidad['valor']);

            $empresaLogueado = $this->catchToken->Claims();
            
            $respuestaParaTodos = strtoupper($entidad['tipo'])=='SISTEMAGLOBAL';

            $esSuperAdmin= $usuarioLogueado->tipo_administrador == TypesAdministrators::SUPER_ADMIN;
            
            if ($esSuperAdmin && $respuestaParaTodos) {
                $entidad['respuesta_sistema']= $valorRespuesta;
            }
            $entidad['empresa_id'] = $empresaLogueado;
            $idRegistro = $this->repositoryDynamicsCrud->getRecordId($this->_tableDb, $entidad);

            if($esSuperAdmin && $respuestaParaTodos) {
                return response()->json("Registro creado exitosamente ", Response::HTTP_CREATED);
            }
            foreach ($empresasRespuesta as $empresa) {
                $arrayInsertar = array(
                    "id_variable_global" => $idRegistro, 
                    "id_empresa"     => $empresa->id, 
                    "valor" => null, 
                    "created_at" => $this->date
                );
            
                $respuestaConexion = DB::connection("app")->table('conexiones_database_empresas')
                    ->where('contabilidad_empresa_id', $empresa->id)->first();
            
                if ($usuarioLogueado->tipo_administrador == TypesAdministrators::SUPER_ADMIN) {
                    DB::connection($respuestaConexion->nombre)->table($this->_tablaRespuestaVariablesGlb)->insert($arrayInsertar);
                }
            
                if ($usuarioLogueado->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR && $empresaLogueado == $empresa->id) {
                    $arrayInsertar['valor']= $valorRespuesta;
                    DB::connection($respuestaConexion->nombre)->table($this->_tablaRespuestaVariablesGlb)->insert($arrayInsertar);
                }
            }
            return response()->json("Registro creado exitosamente ", Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function actualizarVariableGlobal($id, array $entidad)
    {
        try {

            $idDesEncriptada = $this->desencriptarKey(base64_decode($id));
            $this->buscarVariableGlobal($idDesEncriptada);

            if (isset($entidad['valor']) && count($entidad) > 2) {
                throw new NotAcceptableHttpException("Solo puede modificar el valor de la variable");
            }
            
            if (Auth::user()->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR) {
                $entidad["updated_at"] = $this->date;

                $sql = "SELECT id FROM $this->_tablaRespuestaVariablesGlb  WHERE id_variable_global= '$idDesEncriptada' ";
                $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

                return $this->repositoryDynamicsCrud->updateInfo($this->_tablaRespuestaVariablesGlb, $entidad, $response[0]->id);
            }

            $respuesta = $entidad['valor'];
            unset($entidad['valor']);
    
            $respuestaParaTodos = strtoupper($entidad['tipo'])=='SISTEMAGLOBAL';
          
            
            if ($respuestaParaTodos) {
                $entidad['respuesta_sistema']= $respuesta;
            }
            
            
            $idRespuestaGlobal = $idDesEncriptada;
            DB::connection("app")->table($this->_tableDb)->where('id', $idRespuestaGlobal)->update($entidad);
        
            return response()->json("Registro actualizado exitosamente ", Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function eliminarVariableGlobal($id): Response
    {
        try {

            $idDesEncriptada = $this->desencriptarKey(base64_decode($id));
            $variable = $this->buscarVariableGlobal($idDesEncriptada);
            $usuarioLogueado = Auth::user();
            if ($usuarioLogueado->tipo_administrador == TypesAdministrators::SUPER_ADMIN) {
                throw new NotAcceptableHttpException("Como Super Admin no puede eliminar la variable");
            }
            if ($usuarioLogueado->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR && strtoupper($variable[0]->tipo) != 'USUARIO') {
                throw new NotAcceptableHttpException("Solo puede eliminar variables de tipo Usuario");
            }

            $sql = "SELECT id FROM $this->_tablaRespuestaVariablesGlb  WHERE id_variable_global= '$idDesEncriptada' ";
            $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
            // if (strtoupper($variable[0]->tipo) == 'SISTEMA') {
            //     throw new Exception("No puede eliminar una variable de tipo sistema");
            // }
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->_tablaRespuestaVariablesGlb, $response[0]->id);
            return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->_tableDb, $idDesEncriptada);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function buscarModuloId($id)
    {
        $sql = "SELECT * FROM $this->_tablDBModulos WHERE id = '$id'";
        return $this->findRecord($sql, "Modulo no encontrado", 404);
    }
    private function buscarTipoRespuestaId($id)
    {
        $sql = "SELECT * FROM erp_mant_respuestas WHERE id = '$id'";
        return $this->findRecord($sql, "Respuesta no encontrada", 404);
    }
    private function buscarPorNombre($nombre)
    {
        $sql = "SELECT * FROM $this->_tableDb WHERE nombre = '$nombre'";
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if ($response) {
            throw new \Exception("Nombre existente");
        }
    }
    private function obtenerEmpresas()
    {
        $sqlEmpresas = "SELECT id FROM $this->_tablaDBEmpresa";
        return $this->repositoryDynamicsCrud->sqlFunction($sqlEmpresas);
    }
    private function buscarVariableGlobal($id)
    {
        $sql = "SELECT * FROM $this->_tableDb WHERE id = '$id'";
        return $this->findRecord($sql, "Variable no encontrado", 404);
    }
    private function findRecord($sql, $messageError, $status)
    {

        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new \Exception($messageError, $status);
        }
        return $response;
    }
    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }

    private function validarAdministradorConTipoVariable($usuarioLogueado, $entidad)
    {
        $esAdmin = $usuarioLogueado->tipo_administrador == TypesAdministrators::SUPER_ADMIN;
        $respuesta = strtoupper($entidad['tipo']);
        if ($esAdmin && ($respuesta != "SISTEMAGLOBAL" && $respuesta != "SISTEMAEMPRESA" )) {
            throw new NotAcceptableHttpException("Solo puede crear variables de tipo sistema");
        }
        $esUsuario = $usuarioLogueado->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR;
        
        if ( $esUsuario && $respuesta=="usuario" ) {
            throw new NotAcceptableHttpException("Solo puede crear variables de tipo usuario");
        }
    }

    private function validarPermiso($empresaLogueado, $usuarioLogueado, $empresa)
    {
        if ($usuarioLogueado->tipo_administrador == TypesAdministrators::SUPER_ADMIN) {
            return true;
        }

        if ($empresaLogueado == $empresa->id && $usuarioLogueado->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR) {
            return true;
        }
        return false;
    }
}
