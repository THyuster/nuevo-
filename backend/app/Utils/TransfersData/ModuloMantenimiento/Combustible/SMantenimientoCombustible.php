<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Combustible;

use App\Utils\AuthUser;
use App\Utils\Constantes\ModuloMantenimiento\Combustible\CCombustible;
use App\Utils\Constantes\ModuloNomina\CCentroTrabajo;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Illuminate\Support\Facades\Auth;


class SMantenimientoCombustible extends RepositoryDynamicsCrud implements IMantenimientoCombustible
{

    private CCombustible $_Combustible;
    private CCentroTrabajo $_CentroTrabajo;

    private MyFunctions $_MYFunctions;


    public function __construct(CCombustible $Combustible, CCentroTrabajo $centroTrabajo, MyFunctions $myFunctions)
    {
        $this->_Combustible = $Combustible;
        $this->_CentroTrabajo = $centroTrabajo;
        $this->_MYFunctions = $myFunctions;
    }

    public function getIMantenimientoCombustible()
    {
        return $this->sqlFunction($this->_Combustible->sqlSelectAll());
    }
    public function addIMantenimientoCombustible($EntidadCombustible)
    {
        // foreach ($EntidadCombustible as $atributo => $valor) {

        //     if ($valor === "''" || $valor === null || $valor === "") {
        //         throw new Exception("El campo $atributo $valor no es valido", 1);
        //     }

        //     if(is_numeric($valor)) {
        //         if(!$this->_MYFunctions->isNumber($valor)){
        //             throw new Exception("$atributo no es un valor valido",1);
        //         };
        //     }
        // }
        $sql = $this->_Combustible->sqlInsert($EntidadCombustible);

        //code...
        $result = $this->sqlFunction($sql);


        // $result = $this->sqlFunction($sql);
        return $result;
    }
    public function removeIMantenimientoCombustible($id)
    {
        return $this->sqlFunction($this->_Combustible->sqlDelete($id));
    }
    public function updateIMantenimientoCombustible($id, $EntidadCombustible)
    {
        $entidad = $this->sqlFunction($this->_Combustible->sqlSelectById($id));

        if (empty($entidad)) {
            return;
        }

        foreach ($EntidadCombustible as $atributo => $valor) {
            if ($valor === "''" || $valor === null || $valor === "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
            if (is_numeric($valor)) {
                if (!$this->_MYFunctions->isNumber($valor)) {
                    throw new Exception("$atributo no es un valor valido", 1);
                };
            }
        }

        $result = $this->sqlFunction($this->_Combustible->sqlUpdate($id, $EntidadCombustible));

        return $result;
    }
}
