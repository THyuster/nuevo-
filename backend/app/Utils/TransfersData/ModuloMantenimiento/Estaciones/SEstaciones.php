<?php

namespace App\Utils\TransfersData\ModuloMantenimiento\Estaciones;

use App\Utils\Constantes\ModuloContabilidad\SqlMunicipality;
use App\Utils\Constantes\ModuloInventario\Departamentos\CDepartamentos;
use App\Utils\Constantes\ModuloMantenimiento\Estaciones\CEstaciones;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class SEstaciones extends RepositoryDynamicsCrud implements IEstaciones
{
    protected SqlMunicipality $_municipios;
    protected CEstaciones $_estaciones;

    public function __construct(SqlMunicipality $m, CEstaciones $ce)
    {
        $this->_municipios = $m;
        $this->_estaciones = $ce;
    }

    public function getIMantenimientoEstaciones()
    {
        $entidad = $this->sqlFunction($this->_estaciones->sqlSelectAll());
        $entidad = json_decode(json_encode($entidad), true);
        // return $entidad;
        $data = array_map(function ($relacion) {
            return [
                                      
                'id' => base64_encode(EncryptionFunction::StaticEncriptacion($relacion["id"])),
                'codigo' => $relacion["codigo"],
                'nit' => $relacion["nit"],
                'razon_social' => $relacion["razon_social"],
                'municipio_id' => $relacion["municipio_id"],
                'telefono' => $relacion["telefono"],
                'municipio' => $relacion["descripcion"],
                'estado' => $relacion["estado"]

            ];
        }, $entidad);

        return $data;
    }
    public function addIMantenimientoEstaciones($estaciones)
    {
        $keyCodigo = "codigo";
        $keyRazonSocial = "razon_social";
        $keyNit = "nit";
        $keyMunicipioId = "municipio_id";
        $keyTelefono = "telefono";

        $keys = [$keyCodigo, $keyRazonSocial, $keyNit, $keyMunicipioId, $keyTelefono];
        $estacionesEntidad = [];

        foreach ($keys as $key) {
            $estacionesEntidad[$key] = (array_key_exists($key, $estaciones) && $estaciones[$key] !== null) ? $estaciones[$key] : null;
        }

        $codigoDescripcion = $estacionesEntidad[$keyCodigo];
        $municipioDescripcion = $estacionesEntidad[$keyMunicipioId];

        $codigo = $this->sqlFunction($this->_estaciones->sqlSelectByCode($codigoDescripcion));

        if (!empty($codigo)) {
            throw new Exception("$codigoDescripcion " . __("messages.alreadyExistsMessage"), Response::HTTP_CONFLICT);
        }

        $municipio = $this->sqlFunction($this->_municipios->getSqlFindMunicipalityBy($municipioDescripcion));

        if (empty($municipio)) {
            throw new Exception("$municipioDescripcion " . __("messages.notFoundMessages"), Response::HTTP_NOT_FOUND);
        }

        return $this->sqlFunction($this->_estaciones->sqlInsert($estacionesEntidad));
    }
    public function removeIMantenimientoEstaciones($id)
    {
        $id = EncryptionFunction::StaticDesencriptacion(base64_decode($id));
        $entidad = $this->sqlFunction($this->_estaciones->sqlSelectById($id));

        if (empty($entidad)) {
            throw new Exception(__("messages.notFounMessages"), Response::HTTP_NOT_FOUND);
        }

        return $this->sqlFunction($this->_estaciones->sqlDelete($id));
    }
    public function updateIMantenimientoEstaciones($id, $estaciones)
    {
              
        $id = EncryptionFunction::StaticDesencriptacion(base64_decode($id));

        $keyCodigo = "codigo";
        $keyRazonSocial = "razon_social";
        $keyNit = "nit";
        $keyMunicipioId = "municipio_id";
        $keyTelefono = "telefono";

        $keys = [$keyCodigo, $keyRazonSocial, $keyNit, $keyMunicipioId, $keyTelefono];
        $estacionesEntidad = [];

        foreach ($keys as $key) {
            $estacionesEntidad[$key] = (array_key_exists($key, $estaciones) && $estaciones[$key] !== null) ? $estaciones[$key] : null;
        }
        
        $entidadBefore = $this->sqlFunction($this->_estaciones->sqlSelectById($id));

        if (empty($entidadBefore)) {
            throw new Exception("No se encontro la estación", 1);
        }

        $codigo = $this->sqlFunction($this->_estaciones->sqlSelectByCode($estacionesEntidad[$keyCodigo]));

        if (!empty($codigo) && $entidadBefore[0]->id !== $codigo[0]->id) {
            throw new Exception("El codigo digitado ya se encuentra registrado", 1);
        }

        $municipio = $this->sqlFunction($this->_municipios->getSqlFindMunicipalityBy($estacionesEntidad[$keyMunicipioId]));

        if (empty($municipio)) {
            throw new Exception("No existe el municipio", 1);
        }

        foreach ($estacionesEntidad as $key => $value) {
            if ($value == null) {
                throw new Exception("falta el campos $key", 1);
            }
        }

        return $this->sqlFunction($this->_estaciones->sqlUpdate($id, $estacionesEntidad));
    }
    public function EstadoIMantenimientoEstaciones($id)
    {
        $id = EncryptionFunction::StaticDesencriptacion(base64_decode($id));

        $entidad = $this->sqlFunction($this->_estaciones->sqlSelectById($id));

        if (empty($entidad)) {
            throw new Exception("Estacion no encontrada", 1);
        }
        $estado = ($entidad[0]->estado == 1) ? 0 : 1;

        return $this->sqlFunction($this->_estaciones->sqlEstado($id, $estado));
    }
}