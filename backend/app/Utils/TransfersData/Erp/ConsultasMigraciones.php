<?php

namespace App\Utils\TransfersData\Erp;

use Illuminate\Support\Facades\DB;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\MyFunctions;
use App\Utils\Constantes\Migraciones\ConstantesMigraciones;

class ConsultasMigraciones
{

    protected $constantesMigraciones;
    protected $myFunctions;
    protected $repositoryDynamicsCrud;
    protected $constantesVistas;

    public function __construct()
    {
        $this->constantesMigraciones = new ConstantesMigraciones;
        $this->myFunctions = new myFunctions;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->constantesVistas = new ConstantesMigraciones;
    }

    // Crear

    public function create($data)
    {
        return $this->sql_create($data['tabla'], $data['campo'], $data['atributo'], $data['accion'], $data['script_db']);
    }

    // Editar

    public function edit($id, $data)
    {
        return $this->sql_edit($id, $data['tabla'], $data['campo'], $data['atributo'], $data['accion'], $data['script_db']);
    }

    /*ELIMINAR REGISTRO*/

    public function delete($id)
    {
        return $this->deleteMigracion($id);
    }

    public function status($id)
    {
        $data = $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->getMigracion($id));
        $status = ($data[0]->estado == 1) ? 0 : 1;
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->updateSqlMigracionEstado($status, $id));
        $dataNew = $this->repositoryDynamicsCrud->sqlFunction($this->constantesVistas->getMigracion($id));
        return ($dataNew[0]->estado == $status) ? 'Actualizo' : 'No actualizo';
    }

    // Funciones Privadas

    private function sql_create($tabla, $campo, $atributo, $accion, $script_db)
    {

        $dataInsert= array (
            'tabla'=>$tabla,
            'campo'=>$campo,
            'atributo'=>$atributo,
            'accion'=>$accion,
            'script_db'  =>$script_db
        );
        return $this->repositoryDynamicsCrud->createInfo("erp_migraciones",$dataInsert);
        // return $this->repositoryDynamicsCrud->sqlFunction($this->constantesMigraciones->insertMigracion($tabla, $campo, $atributo, $accion, $script_db));
    }

    private function sql_edit($id, $tabla, $campo, $atributo, $accion, $script_db)
    {
        $data = $this->repositoryDynamicsCrud->sqlFunction($this->constantesMigraciones->getMigracion($id));
        if (empty($data)) {
            return;
        }
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesMigraciones->updateMigracion($tabla, $campo, $atributo, $accion, $script_db, $id));
        $dataActualizada = $this->repositoryDynamicsCrud->sqlFunction($this->constantesMigraciones->getMigracion($id));
        return ($dataActualizada[0]->campo == $campo && $dataActualizada[0]->tabla == $tabla && $dataActualizada[0]->atributo == $atributo && $dataActualizada[0]->accion == $accion && $dataActualizada[0]->script_db == $script_db) ? 'Actualizo' : 'No actualizo';
    }

    private function deleteMigracion($id)
    {
        $this->repositoryDynamicsCrud->sqlFunction($this->constantesMigraciones->deleteMigracion($id));
        return 'Borro';
    }

}
