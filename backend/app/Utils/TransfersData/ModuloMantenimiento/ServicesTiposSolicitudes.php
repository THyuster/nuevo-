<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use App\Utils\Constantes\ModuloMantenimiento\CTiposSolicitudes;
use App\Utils\Repository\RepositoryDynamicsCrud;

use Exception;

class ServicesTiposSolicitudes implements IServicesTiposSolicitudes
{
    private CTiposSolicitudes $_cTiposSolicitudes;
    private RepositoryDynamicsCrud $_repository;

    public function __construct(RepositoryDynamicsCrud $repository, CTiposSolicitudes $cTiposSolicitudes)
    {
        $this->_cTiposSolicitudes = $cTiposSolicitudes;
        $this->_repository = $repository;
    }

    public function crearTipoSolicitud($entidadTiposSolicitudes)
    {
        $codigoModel = $this->_repository->sqlFunction($this->_cTiposSolicitudes->sqlSelectByCode($entidadTiposSolicitudes['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$entidadTiposSolicitudes['codigo']}", 1);
        }

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $this->_repository->sqlFunction($this->_cTiposSolicitudes->sqlInsert($entidadTiposSolicitudes));

        return "Creo";
    }
    public function actualizarTipoSolicitud(int $id, $entidadTiposSolicitudes): string
    {
        $codigoModel = $this->_repository->sqlFunction($this->_cTiposSolicitudes->sqlSelectByCode(strtoupper($entidadTiposSolicitudes['codigo'])));

        $entidad = $this->_repository->sqlFunction($this->_cTiposSolicitudes->sqlSelectById($id));

        if ($codigoModel) {
            if ($codigoModel[0]->codigo !== $entidad[0]->codigo) {
                throw new Exception("Este codigo {$entidadTiposSolicitudes['codigo']} ya esta asignado", 1);
            }
        }

        foreach ($entidadTiposSolicitudes as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $this->_repository->sqlFunction($this->_cTiposSolicitudes->sqlUpdate($id, $entidadTiposSolicitudes));

        return "Actualizo";
    }
    public function eliminarTipoSolicitud(int $id): string
    {
        $this->_repository->sqlFunction($this->_cTiposSolicitudes->sqlDelete($id));
        return "Elimino";
    }

    public function getTipoSolicitud()
    {
        return $this->_repository->sqlFunction($this->_cTiposSolicitudes->sqlSelectAll());
    }
}
