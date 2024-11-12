<?php

namespace App\Utils\TransfersData\ModuloConfiguracion;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Support\Facades\Auth;

class LogImportaciones
{
    protected $repositoryDynamicsCrud, $_tableDb, $tablaLogImportaciones, $date;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->_tableDb = tablas::getTablaClienteLogImportaciones();

        $this->tablaLogImportaciones = tablas::getTablaClienteLogImportaciones();
        $this->date = date("Y-m-d H:i:s");
    }

    public function obtenerImportaciones()
    {
        $sql = "SELECT li.*, u.name importacionUsuario  FROM $this->_tableDb li LEFT JOIN users u ON li.usuario = u.id ";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }

    public function crearLogImportacion($app, $dsn, $modulo, $estado, $vista, $accion)
    {
        try {
            $newData = array(
                "app" => $app,
                "dsn" => $dsn,
                "modulo" => $modulo,
                "usuario" => Auth::user()->id,
                "estado" => $estado,
                "vista" => $vista,
                "fecha_importacion" => $this->date,
                'accion' => $accion
            );
            return $this->repositoryDynamicsCrud->createInfo($this->tablaLogImportaciones, $newData);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}