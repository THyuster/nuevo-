<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Models\modulo_nomina\nomina_centros_trabajo;
use App\Utils\Constantes\ModuloNomina\CCentroTrabajo;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ServicesCentrosTrabajo implements IServicesCentrosTrabajo
{

    private CCentroTrabajo $_cCentroTrabajo;
    private RepositoryDynamicsCrud $_repository;

    public function __construct(RepositoryDynamicsCrud $repository, CCentroTrabajo $cCentroTrabajo)
    {
        $this->_cCentroTrabajo = $cCentroTrabajo;
        $this->_repository = $repository;
    }

    public function crearCentroTrabajo($entidadCentroTrabajo)
    {
        $codigoModel = $this->_repository->sqlFunction($this->_cCentroTrabajo->sqlSelectByCode($entidadCentroTrabajo['codigo']));

        if ($codigoModel) {
            throw new Exception("Ya existe {$entidadCentroTrabajo['codigo']}", 1);
        }

        foreach ($entidadCentroTrabajo as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }

        $this->_repository->sqlFunction($this->_cCentroTrabajo->sqlInsert($entidadCentroTrabajo));

        return "Creo";
    }
    public function actualizarCentroTrabajo(int $id, $entidadCentroTrabajo)
    {
        $codigoModel = $this->_repository->sqlFunction($this->_cCentroTrabajo->sqlSelectByCode(strtoupper($entidadCentroTrabajo['codigo'])));
        $entidad = $this->_repository->sqlFunction($this->_cCentroTrabajo->sqlSelectById($id));

        if ($codigoModel) {
            if ($codigoModel[0]->codigo !== $entidad[0]->codigo) {
                throw new Exception("Este codigo {$entidadCentroTrabajo['codigo']} ya esta asignado", 1);
            }
        }

        foreach ($entidadCentroTrabajo as $atributo => $valor) {
            if ($valor == "''" || $valor == null || $valor == "") {
                throw new Exception("El campo $atributo no es valido", 1);
            }
        }
        
        return  $this->_repository->updateInfo("nomina_centros_trabajos", $entidadCentroTrabajo,$id);

    }
    public function eliminarCentroTrabajo(int $id): string
    {
        $response = $this->_repository->sqlFunction("SELECT id FROM gestion_calidad  WHERE nomina_centro_trabajo_id  = $id");
        if ($response) {
            throw new Exception("No se puede eliminar el centro de trabajo ya que se esta utilizando en un registro");
        }
        $response = $this->_repository->sqlFunction("SELECT nomina_centro_trabajo_id FROM nomina_solicitudes_empleo  WHERE nomina_centro_trabajo_id  = $id");
        
        if ($response) {
            throw new Exception("No se puede eliminar el centro de trabajo ya que se esta utilizando en un registro");
        }

        $this->_repository->sqlFunction($this->_cCentroTrabajo->sqlDelete($id));
        return "Elimino";
    }
    public function estadoCentroTrabajo(int $id): string
    {
        
        $entidadVehiculo = $this->_repository->sqlFunction($this->_cCentroTrabajo->sqlSelectById($id));
        if (empty($entidadVehiculo)) {
            throw new Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadVehiculo[0]->estado == 1) ? 0 : 1;
        $this->_repository->sqlFunction($this->_cCentroTrabajo->sqlUpdateEstado($id, $estado));
        return "Actualizado";
    }
    public function getCentroTrabajo()
    {
        $connection = $this->_repository->findConectionDB();

        return nomina_centros_trabajo::on($connection)->get();
        // $centrotrabajos = Cache::remember("centroTrabajos$connection", Carbon::now()->addHours(2), function () use ($connection) {
        //     return nomina_centros_trabajo::on($connection)->get();
        // });
     
        // return $centrotrabajos;
    }
}
