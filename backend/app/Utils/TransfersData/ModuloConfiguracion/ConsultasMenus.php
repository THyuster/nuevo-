<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use App\Utils\Constantes\ModuloConfiguracion\DisenoMenus;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\Constantes\ConstantConsultations;
use Illuminate\Support\Facades\DB;

class ConsultasMenus
{
    protected $repositoryDynamicCrud;
    protected $sqlConstantes;

    protected $disenoMenus;

    public function __construct()
    {
        $this->repositoryDynamicCrud = new RepositoryDynamicsCrud;
        $this->sqlConstantes = new ConstantConsultations;
        $this->disenoMenus = new DisenoMenus;
    }

    public function createMenu($jsonData)
    {
        $descripcion = $jsonData['descripcion'];
        $moduloId = $jsonData['modulo_id'];
        $estado = 1;

        $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
        $moduloId = htmlspecialchars($moduloId, ENT_QUOTES, 'UTF-8');

        $sql = $this->disenoMenus->sqlGetMenuByName($descripcion, $moduloId);
        $response = $this->repositoryDynamicCrud->sqlFunction($sql);

        if ($response) {
            throw new \Exception('Menu ya existente', 400);
        }

        $entidad['descripcion'] = $descripcion;
        $entidad['modulo_id'] = $moduloId;
        $entidad['estado'] = $estado;

        $createMenu = $this->repositoryDynamicCrud->createInfo('erp_menuses', $entidad);
        return $createMenu->getStatusCode();
    }

    public function updateMenu($jsonUpdate)
    {
        $id = $jsonUpdate["id"];
        $findMenu = $this->repositoryDynamicCrud->getInfoAllOrById('erp_menuses', [], $id);
        return (!$findMenu) ? 'Menu no encontrado'
            : $this->repositoryDynamicCrud->updateInfo('erp_menuses', $jsonUpdate, $id);
    }

    public function menuCheck()
    {
        try {
            $sql = '';
            return DB::select($sql);
        } catch (\Throwable $th) {
            print_r('Error en la consulta por favor conmunicarse con el administrador');
            exit();
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM erp_menuses WHERE modulo_id = '$id'";
            return (!(empty(DB::select($sql)))) ? true : false;
        } catch (\Throwable $th) {
            return 'Error en la consulta por favor conmunicarse con el administrador';
        }
    }

    public function updateDataMenus($id, $descripcion, $estado)
    {
        if ($this->findById($id)) {
            $checkUpdate = DB::table('erp_menuses')->where('modulo_id', $id)->update([
                'descripcion' => $descripcion,
                'estado' => $estado
            ]);
            return ($checkUpdate > 0) ? true : false;
        }
        return 'No es valido';
    }

    public function changeStatusMenus(int $id)
    {
        $status = $this->checkStatusMenus($id);
        $this->updateChangeStatusMenus($status, $id);
        $checkStatus = $this->checkStatusMenus($id);
        return ($status != $checkStatus) ? 'Actualizo' : 'Hubo un error';
    }

    private function updateChangeStatusMenus($status, $id)
    {
        $sql = "UPDATE erp_menuses SET estado = $status WHERE id = $id";
        $this->repositoryDynamicCrud->sqlFunction($sql);
        return;
    }

    private function checkStatusMenus(int $id)
    {
        $sql = "SELECT * FROM erp_menuses WHERE id = '$id'";
        $data =  $this->repositoryDynamicCrud->sqlFunction($sql);
        return ($data[0]->estado == 1) ? 0 : 1;
    }
}
