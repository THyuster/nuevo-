<?php

namespace App\Utils\TransfersData\IntegracionImportacion;

use App\Utils\Constantes\NavbarMenus\ConstantesMenu;
use App\Utils\ModulesCode;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceImportacionTns;
use Exception;

class TratamientoTns extends RepositoryDynamicsCrud
{
    private $constantesMenu, $modulos, $servicioImportacion;
    public function __construct()
    {
        $this->constantesMenu = new ConstantesMenu;
        $this->modulos = new ModulesCode;
        $this->servicioImportacion = new ServiceImportacionTns();
    }
    public  function importacionTNS(array $modulosSolicitados)
    {
        $modulosDesdeDB = $this->obtenerModulosDesdeDB();
        $modulosFiltrados = $this->filtrarModulos($modulosDesdeDB); //eliminar el id del modulo de inicio
        $modulosNoPermitidos = array_diff($modulosSolicitados, $modulosFiltrados);

        if ($modulosNoPermitidos) {
            throw new Exception("Acceso a modulos no permitidos");
            // throw new Exception("Acceso a módulos no permitidos: " . implode(', ', $modulosNoPermitidos));
        }
        return array_map(function ($idModulo) {
            return $this->ejecutarImportacionPorCodigoModulo($idModulo);
        }, $modulosSolicitados);
    }
    private function filtrarModulos(array $modulos)
    {
        $modulosFiltrados = array();
        array_map(function ($modulo) use (&$modulosFiltrados) {
            $idModulo =  $modulo->idModulo;
            if ($idModulo != $this->modulos::CODIGO_INICIO) {
                return array_push($modulosFiltrados, $idModulo);
            }
        }, $modulos);

        return  $modulosFiltrados;
    }

    private function obtenerModulosDesdeDB()
    {
        $sql = $this->constantesMenu->getModulosMain();
        return   $this->sqlFunction($sql);
    }
    private function ejecutarImportacionPorCodigoModulo($idModulo)
    {
        return $this->servicioImportacion->importacionPorCodigoModulo($idModulo);
    }
}