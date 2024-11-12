<?php

namespace App\Utils\TransfersData\IntegracionImportacion;

use App\Utils\Constantes\NavbarMenus\ConstantesMenu;
use App\Utils\ModulesCode;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\ServicesConexionesOdbc;
use App\Utils\TransfersData\ModuloInventario\ServiceImportacionTns;
use Exception;
use Illuminate\Support\Facades\Cache;

class IntengracionData extends RepositoryDynamicsCrud
{
    private $servicioOdbc, $tratamientoTns;
    private $aplicacion = [
        "TNS" => "TNS",
        "STON" => "STON",
        "SIGO" => "SIGO"
    ];

    public function __construct()
    {

        $this->servicioOdbc = new ServicesConexionesOdbc;
        $this->tratamientoTns = new TratamientoTns;
    }

    public function validacionDeOpciones(array $request)
    {
        try {
            $registroOdbc = $this->obtenerConexionOdbc($request['idOdbc']);
            Cache::put('dsn', $registroOdbc->dsn);
            // return $registroOdbc->aplicacion; 
            switch (strtoupper($registroOdbc->aplicacion)) {
                case "TNS":
                    return $this->importacionTNS($request['modulos']);
                case "SIGO":
                    // return $this->importacionSIGO($request['modulos']);
                default:
                    return __('messages.invalidApplicationOption');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    private function obtenerConexionOdbc(int $idOdbc)
    {
        $response = $this->servicioOdbc->findConnectionConexionOdbc($idOdbc);
        if (!$response) {
            throw new Exception(__('messages.connectionNotFound'));
        }
        return $response[0];
    }

    private function importacionTNS(array $modulosSolicitados)
    {

        return $this->tratamientoTns->importacionTNS($modulosSolicitados);
    }
}