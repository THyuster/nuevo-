<?php

namespace App\Utils\TransfersData\ModuloLogistica;

use App\Utils\Constantes\ModuloLogistica\CTrailers;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicesTrailers implements IServiceTrailers
{
    private CTrailers $_ctrailer;
    private RepositoryDynamicsCrud $_repository;

    public function __construct(CTrailers $trailes, RepositoryDynamicsCrud $repository)
    {
        $this->_ctrailer = $trailes;
        $this->_repository = $repository;
    }
    public function crearTrailer($entidadTrailer): string
    {
        $codigoModel = $this->_repository->sqlFunction($this->_ctrailer->sqlSelectByCode($entidadTrailer['codigo']));

        if ($codigoModel) {
            return "Ya existe {$entidadTrailer['codigo']}";
        }

        if ($entidadTrailer['codigo'] == "" || $entidadTrailer['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($entidadTrailer['descripcion'] == "" || $entidadTrailer['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->_repository->sqlFunction($this->_ctrailer->sqlInsert($entidadTrailer));
        return "Creo";
    }

    public function actualizarTrailer(int $id, $entidadTrailer): string
    {
        $codigoModel = $this->_repository->sqlFunction($this->_ctrailer->sqlSelectByCode(strtoupper($entidadTrailer['codigo'])));

        if (!empty($codigoModel) && $codigoModel[0]->codigo != $entidadTrailer['codigo']) {
            return  "Este codigo {$entidadTrailer['codigo']} ya esta asignado";
        }

        if ($entidadTrailer['codigo'] == "" || $entidadTrailer['codigo'] == null) {
            return "el dato de codigo esta vacio";
        }

        if ($entidadTrailer['descripcion'] == "" || $entidadTrailer['descripcion'] == null) {
            return "el dato de descripcion esta vacio";
        }

        $this->_repository->sqlFunction($this->_ctrailer->sqlUpdate($id, $entidadTrailer));
        
        return "Actualizo";
    }

    public function eliminarTrailer(int $id): string
    {
        $this->_repository->sqlFunction($this->_ctrailer->sqlDelete($id));
        return "elimino";
    }

    public function getTrailer()
    {
        return $this->_repository->sqlFunction($this->_ctrailer->sqlSelectAll());
    }

}