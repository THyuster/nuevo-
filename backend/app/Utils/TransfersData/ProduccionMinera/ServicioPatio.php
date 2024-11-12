<?php

namespace App\Utils\TransfersData\ProduccionMinera;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;

class ServicioPatio implements IServicioPatios
{
    private String $tablaPatio,  $tablaCentroTrabajo, $patioIdDesEncriptado, $tipoUsoIdDesEncriptado, $centroTrabajoIdDesEncriptado;

    private String $tablaNominaCentroTrabajo, $tablaTipoUso, $tablaTipoPatio;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioTipoPatios $servicioTipoPatios;
    private IServicioTipoUso $iServicioTipoUso;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, IServicioTipoPatios $servicioTipoPatios, IServicioTipoUso $iServicioTipoUso)
    {
        $this->tablaPatio = tablas::getTablaClientePmPatios();
        $this->tablaCentroTrabajo = tablas::getTablaClienteNominaCentrosTrabajos();
        $this->tablaNominaCentroTrabajo = tablas::getTablaClienteNominaCentrosTrabajos();
        $this->tablaTipoUso = tablas::getTablaClientePmTipoUso();
        $this->tablaTipoPatio = tablas::getTablaClientePmTiposPatios();

        $this->servicioTipoPatios = $servicioTipoPatios;
        $this->iServicioTipoUso = $iServicioTipoUso;
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
    }

    public function obtenerPatios()
    {
        $query = "SELECT 
          pmt.id,
          pmt.codigo,
          pmt.descripcion,
          pmt.propio,
          pmt.estado,
          pmt.centro_trabajo_id idCentroTrabajo,
          nct.codigo codigoCentroTrabajo,
          nct.descripcion descripcionCentroTrabajo,
          tu.id idTipoUso,
          tu.codigo codigoTipoUso,
          tu.descripcion descripcionTipoUso,
          tp.id idTipoPatio,
          tp.descripcion descripcionTipoPatio
         FROM $this->tablaPatio pmt 
        INNER JOIN $this->tablaNominaCentroTrabajo nct ON pmt.centro_trabajo_id = nct.id
        INNER JOIN $this->tablaTipoUso tu ON pmt.tipo_uso_id = tu.id
        INNER JOIN $this->tablaTipoPatio tp ON pmt.tipo_patio_id = tp.id
        ";
        $patiosDb =  $this->repositoryDynamicsCrud->sqlFunction($query);
        return array_map(function ($patio) {
            $patio->id = base64_encode($this->encriptarKey($patio->id));
            $patio->centroTrabajo = (object)[
                "id" => $patio->idCentroTrabajo,
                "codigo" => $patio->codigoCentroTrabajo,
                "descripcion" => $patio->descripcionCentroTrabajo
            ];
            $patio->tipoUso = (object)[
                "id" => base64_encode($this->encriptarKey($patio->idTipoUso)),
                "codigo" => $patio->codigoTipoUso,
                "descripcion" => $patio->descripcionTipoUso
            ];
            $patio->tipoPatio = (object)[
                "id" => base64_encode($this->encriptarKey($patio->idTipoPatio)),
                "descripcion" => $patio->descripcionTipoPatio
            ];
            unset(
                $patio->idCentroTrabajo,
                $patio->codigoCentroTrabajo,
                $patio->descripcionCentroTrabajo,
                $patio->idTipoUso,
                $patio->codigoTipoUso,
                $patio->descripcionTipoUso,
                $patio->idTipoPatio,
                $patio->descripcionTipoPatio,

            );
            return $patio;
        }, $patiosDb);
    }



    public function crearPatio(array $data)
    {
        try {
            $fksValidas = $this->validarFks($data);

            if ($fksValidas) {
                return $fksValidas;
            }
            $crearPatio = $this->mapperFKs($data);
            $this->repositoryDynamicsCrud->createInfo($this->tablaPatio, $crearPatio);
            return response()->json(['message' => 'Patio creado correctamente'], 200);
        } catch (\Throwable $th) {
            // throw new \Exception($th->getMessage());
            return response()->json(['message' => 'Error al crear el patio: ' . $th->getMessage()], 500);
        }
    }


    public function actualizarPatio($id, $data)
    {
        try {
            $id =  $this->desencriptarKey(base64_decode($id));
            $response = $this->obtenerPatioPorId($id);

            $fksValidas = $this->validarFks($data);

            if (!$response) {
                return response()->json(['message' => 'Patio  no encontrado'], 404);
            }
            if ($fksValidas) {
                return  $fksValidas;
            }

            $actualizarPatio = $this->mapperFKs($data);
            $this->repositoryDynamicsCrud->updateInfo($this->tablaPatio, $actualizarPatio, $id);
            return response()->json(['message' => 'Patio actualizado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar el patio: ' . $th->getMessage()], 500);
        }
    }

    public function eliminarPatio($id)
    {
        try {
            $id =  $this->desencriptarKey(base64_decode($id));
            $response = $this->obtenerPatioPorId($id);
            if (!$response) {
                return response()->json(['message' => 'Patio  no encontrado'], 404);
            }
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaPatio, $id);
            return response()->json(['message' => 'Patio eliminado correctamente: '], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al crear el patio'], 500);
        }
    }
    public function obtenerPatioPorId($id)
    {
        $query =  "SELECT * FROM $this->tablaPatio WHERE id = '$id'";
        $patioDb =  $this->repositoryDynamicsCrud->sqlFunction($query);
        if (!$patioDb) {
            return false;
        }
        return $patioDb;
    }
    public function validarPatioPorId($id)
    {
        $patioDb =    $this->obtenerPatioPorId($id);
        if (!$patioDb) {
            return response()->json(['message' => 'Patio  no encontrado'], 404);
        }
        return null;
    }
    public function actualizarEstadoPatio(string $id)
    {
        try {
            $id =  $this->desencriptarKey(base64_decode($id));
            $patioDb =  $this->obtenerPatioPorId($id);
            if (!$patioDb) {
                return response()->json(['message' => 'Patio  no encontrado'], 404);
            }
            $nuevoEstado = !$patioDb[0]->estado;
            $this->repositoryDynamicsCrud->updateInfo($this->tablaPatio, ["estado" => $nuevoEstado], $id);
            return response()->json(["respuesta" => "Registro actualizado exitosamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(["respuesta" => $th->getMessage()], $th->getCode());
        }
    }
    private function validarFks(array $data)
    {
        $this->patioIdDesEncriptado = $this->desencriptarKey(base64_decode($data['tipo_patio_id']));
        $this->tipoUsoIdDesEncriptado = $this->desencriptarKey(base64_decode($data['tipo_uso_id']));
        $this->centroTrabajoIdDesEncriptado = $data['centro_trabajo_id'];

        $centroTrabajo = $this->validarCentroTrabajoFk($this->centroTrabajoIdDesEncriptado);
        $tipoPatio = $this->validarTipoPatioFk($this->patioIdDesEncriptado);
        $tipoUso = $this->validarTipoUsoFk($this->tipoUsoIdDesEncriptado);

        if ($centroTrabajo != null || $tipoPatio != null || $tipoUso != null) {
            return $centroTrabajo ?? $tipoPatio ?? $tipoUso;
        }
        return null;
    }

    private function mapperFKs(array $data)
    {
        return [
            'codigo' => $data['codigo'],
            'descripcion' =>  $data['descripcion'],
            'propio' =>  $data['propio'],
            'tipo_patio_id' => $this->patioIdDesEncriptado,
            'tipo_uso_id' => $this->tipoUsoIdDesEncriptado,
            'centro_trabajo_id' => $this->centroTrabajoIdDesEncriptado
        ];
    }

    private function validarCentroTrabajoFk(string $id)
    {
        $query =  "SELECT * FROM $this->tablaCentroTrabajo WHERE id = '$id'";
        $centroTrabajoDb =  $this->repositoryDynamicsCrud->sqlFunction($query);
        if (!$centroTrabajoDb) {
            return response()->json(['message' => 'Centro de trabajo no encontrado'], 404);
        }
        return null;
    }
    private function validarTipoPatioFk(string $id)
    {
        $patioDb =  $this->servicioTipoPatios->obtenerPatioPorId($id);
        if (!$patioDb) {
            return response()->json(['message' => 'Patio  no encontrado'], 404);
        }
        return null;
    }
    private function validarTipoUsoFk(string $id)
    {

        $tipoUsoDb =  $this->iServicioTipoUso->obtenerTiposUsoPorId($id);
        if (!$tipoUsoDb) {
            return response()->json(['message' => 'Tipo de uso no encontrado'], 404);
        }
        return null;
    }


    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}
