<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use App\Utils\FileManager;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Utils\Constantes\ModuloConfiguracion\DisenoModulos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\MyFunctions;

class ConsultasModulosNavegacion extends RepositoryDynamicsCrud
{
    protected $disenoModulos;
    protected $constantsModulesNavegation;
    protected $myFunctions;
    protected $repositoryDynamicsCrud;
    protected $_fileManager;

    public function __construct()
    {
        $this->myFunctions = new myFunctions;
        $this->disenoModulos = new DisenoModulos;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->_fileManager = new FileManager();
    }

    public function findModuleByName(string $module)
    {
        return $this->disenoModulos->sqlGetByModule($module);
    }

    public function create($data, $request)
    {
        $descripcion = $data['descripcion'];
        // $descripcion = htmlspecialchars($data;

        $sql = $this->findModuleByName($descripcion);
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);

        if (!empty($response)) {
            throw new Exception("Error Processing Request", 1);
        }

        if ($request->hasFile("ruta_imagen")) {

            $newImagePath = $this->_fileManager->pushImagen($request, "navbar", '');

            if ($newImagePath === "No se encontro imagen" || $newImagePath === "No es una imagen valida") {
                return $newImagePath;
            }

            $data["logo"] = $newImagePath;
        }

        $data['activo'] = 1;

        unset($data["ruta_imagen"]);

        $idModule = DB::table('erp_modulos')->insertGetId($data);

        $updateFildCode = array('codigo' => "M$idModule");
        $this->repositoryDynamicsCrud->updateInfo('erp_modulos', $updateFildCode, $idModule);
        return true;
    }

    public function delete($id)
    {
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById('erp_modulos', $id);
    }

    public function edit($data, $request)
    {
        $id = $data["id"];
        // $id = htmlspecialchars($id;

        $sql = "SELECT * FROM erp_modulos WHERE id = '$id'";

        $consulta_datos = $this->sqlFunction($sql);
        
        $oldImagen = $consulta_datos[0]->logo;

        if ($request->hasFile("ruta_imagen")) {

            $newImagePath = $this->_fileManager->pushImagen($request, "navbar", '');

            if ($newImagePath === "No se encontro imagen" || $newImagePath === "No es una imagen valida") {
                return $newImagePath;
            }

            $data["ruta_imagen"] = $newImagePath;
        } else {
            $data["ruta_imagen"] = $oldImagen;
        }

        $descripcion = $data['descripcion'];
        $ubicacion = $data['ubicacion'];
        $orden = $data['orden'];
        $tipoUsuario = $data["tipo_usuario"];
        $rutaImagen = $data["ruta_imagen"];

        $this->updateModuloNavegacion($descripcion, $ubicacion, $orden, $tipoUsuario, $rutaImagen, $id);
        return true;
    }

    public function changeStatusModulo($id)
    {
        $modulo = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM `erp_modulos` WHERE `id` = '$id'");
        $estado = ($modulo[0]->activo === 1) ? 0 : 1;
        $this->repositoryDynamicsCrud->sqlFunction("UPDATE `erp_modulos` SET `activo`='$estado' WHERE `id`='$id'");
        return true;
    }

    private function updateModuloNavegacion($descripcion, $ubicacion, $orden, $tipo_acceso, $logo, $id)
    {
        $this->repositoryDynamicsCrud->sqlFunction($this->disenoModulos->updateSqlDisenoModulos($descripcion, $ubicacion, $orden, $tipo_acceso, $logo, $id));
    }
}
