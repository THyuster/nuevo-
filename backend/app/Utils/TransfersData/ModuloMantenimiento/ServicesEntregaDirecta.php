<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloMantenimiento\CEntregasDirectas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ServicesEntregaDirecta implements IServicesEntregaDirectas
{
    private String $tablaBaseDatos, $tablaRelacionArticuloEntregaBaseDatos, $tablaArticulos;
    private String $tablaCentroTrabajo;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;
    private CEntregasDirectas $cEntregasDirectas;

    public function __construct()
    {
        $this->cEntregasDirectas = new cEntregasDirectas;

        $this->tablaArticulos = tablas::getTablaErpInventarioArticulos();
        $this->tablaCentroTrabajo = tablas::getTablaClienteNominaCentrosTrabajos();
        $this->tablaBaseDatos = tablas::getTablaClientemantenimientoEntregaDirecta();
        $this->tablaRelacionArticuloEntregaBaseDatos = tablas::getTablaClientemantenimientoRelacionArticuloEntregaDirecta();

        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
    }
    public function obtenerTodosEntregaDirecta()
    {

        $datos =   $this->obtenerData();
        $datosDecodificados = json_decode($datos, true);
        $respuestaDb =  $datosDecodificados['data'];

        $nuevaData = [];
        foreach ($respuestaDb as $dataActual) {
            $idSinEncriptar = $dataActual['idEntregaDirecta'];
            $dataActual['idEntregaDirecta'] = base64_encode($this->encriptarKey($idSinEncriptar));
            $idActual = $dataActual['idEntregaDirecta'];
            $datoEncontrado = $this->buscarEntregaDirecta($nuevaData, $idActual);

            if (!$datoEncontrado) {
                $datoEncontrado = $this->agregarDato($nuevaData, (object)$dataActual, $idSinEncriptar);
            }

            $this->agregarArticulo((object) $datoEncontrado, (object) $dataActual);
            unset($datoEncontrado->articuloId, $datoEncontrado->descripcion_articulo);
        }
        $datosDecodificados['data'] = $nuevaData;
        return json_encode($datosDecodificados);
    }

    private function buscarEntregaDirecta(array $nuevaData = [], String $idActual)
    {

        foreach ($nuevaData as $nuevaDataActual) {
            if ($nuevaDataActual->idEntregaDirecta == $idActual) {
                return $nuevaDataActual;
            }
        }
        return false;
    }
    private function agregarDato(array &$nuevaData, object $entregaActual, int $idSinEncriptar)
    {
        $arrayEntrega = json_decode(json_encode($entregaActual), true);
        $entrega = (object) $arrayEntrega;
        $entrega->articulos = [];
        $entrega->codigo = "COD - " . $idSinEncriptar;
        $nuevaData[] = $entrega;
        return $entrega;
    }

    private function agregarArticulo(object $entrega, object $datoActual)
    {

        $encontrarArticulo = collect($entrega->articulos)->first(function ($articulo) use ($datoActual) {
            return $articulo['articuloId'] == $datoActual->articuloId;
        });

        if (!$encontrarArticulo) {
            $entrega->articulos[] = [
                "articuloId" => $datoActual->articuloId,
                "descripcion" => "$datoActual->codigo_articulo - $datoActual->descripcion_articulo",
                "cantidad" => $datoActual->cantidad_articulos,
            ];
        }
    }

    public function crearEntregaDirecta(array $entidadTiposEntregaDirecta)
    {

        try {

            $this->validarCentroTrabajo($entidadTiposEntregaDirecta['centroTrabajoId']);
            $articulos =  $this->validarArticulos($entidadTiposEntregaDirecta['articulosEntregas']);

            $entidadTiposEntregaDirecta['usuario_entrega'] = Auth::user()->id;
            $entidadTiposEntregaDirecta['centro_trabajo_id'] =  $entidadTiposEntregaDirecta['centroTrabajoId'];
            $entidadTiposEntregaDirecta['usuario_recibe'] =  $entidadTiposEntregaDirecta['usuarioRecibe'];

            unset($entidadTiposEntregaDirecta['articulosEntregas'], $entidadTiposEntregaDirecta['centroTrabajoId'], $entidadTiposEntregaDirecta['usuarioRecibe']);

            $idEntregaDirecta =  $this->repositoryDynamicsCrud->getRecordId($this->tablaBaseDatos, $entidadTiposEntregaDirecta);
            $entregasYArticulos = $this->mapperArticuloConEntregaDirecta($idEntregaDirecta, $articulos);
            return $this->repositoryDynamicsCrud->createInfo($this->tablaRelacionArticuloEntregaBaseDatos, $entregasYArticulos);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function actualizarEntregaDirecta($id, $entidadTiposEntregaDirecta)
    {
        try {
            // return $entidadTiposEntregaDirecta;
            $idDesEncriptado = $this->desencriptarKey(base64_decode($id));
            $this->buscarEntregaDirectaPorId($idDesEncriptado);

            $this->validarCentroTrabajo($entidadTiposEntregaDirecta['centroTrabajoId']);

            $entidadTiposEntregaDirecta['centro_trabajo_id'] =  $entidadTiposEntregaDirecta['centroTrabajoId'];
            $entidadTiposEntregaDirecta['usuario_recibe'] =  $entidadTiposEntregaDirecta['usuarioRecibe'];

            $articulos =  $this->validarArticulos($entidadTiposEntregaDirecta['articulosEntregas']);

            $articulosNuevos =  $this->eliminarArticulosORetonarAñadir($idDesEncriptado, $articulos);
            unset($entidadTiposEntregaDirecta['articulosEntregas'], $entidadTiposEntregaDirecta['centroTrabajoId'], $entidadTiposEntregaDirecta['usuarioRecibe']);
            $entregasYArticulos = $this->mapperArticuloConEntregaDirecta($idDesEncriptado, $articulosNuevos);
            $this->repositoryDynamicsCrud->updateInfo($this->tablaBaseDatos, $entidadTiposEntregaDirecta, $idDesEncriptado);
            if (!empty($articulosNuevos)) {
                return $this->repositoryDynamicsCrud->createInfo($this->tablaRelacionArticuloEntregaBaseDatos, $entregasYArticulos);
            }
            return "Actualizado exitosamente";
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function eliminarEntregaDirecta($id)
    {
        try {
            $idDesEncriptado = $this->desencriptarKey(base64_decode($id));
            $this->buscarEntregaDirectaPorId($idDesEncriptado);
            $sql = "DELETE  FROM $this->tablaRelacionArticuloEntregaBaseDatos  WHERE entrega_directa_id = '$idDesEncriptado'";
            $this->repositoryDynamicsCrud->sqlFunction($sql);
            $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaBaseDatos, $idDesEncriptado);
            return "Entrega eliminada";
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function validarArticulos(array $articulos): array
    {
        $articulosId = array_column($articulos, "articuloId");
        $idArticulosString = implode(",", $articulosId);

        $sql = "SELECT * FROM $this->tablaArticulos WHERE id IN ($idArticulosString)";
        $idsEntregaDirecta =  $this->repositoryDynamicsCrud->sqlFunction($sql);

        $articulosDecodificados = json_decode(json_encode($idsEntregaDirecta), true);
        $idsArticulos = array_column($articulosDecodificados, "id");

        $idsNoExistentes = array_diff($articulosId, $idsArticulos);

        if ($idsNoExistentes) {
            throw new Exception("Articulos no existentes");
        }
        return $articulos;
    }

    private function validarCentroTrabajo(int $id): void
    {

        $sql = "SELECT * FROM $this->tablaCentroTrabajo WHERE id = '$id'";
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new Exception("Centro trabajo no exitente!!");
        }
    }



    private function mapperArticuloConEntregaDirecta($idEntregaDirecta, array $articulos): array
    {
        return array_map(function ($articulo) use ($idEntregaDirecta) {
            return [
                "entrega_directa_id" => $idEntregaDirecta,
                "articulo_id" => $articulo['articuloId'],
                "cantidad" =>  $articulo['cantidad']
            ];
        }, $articulos);
    }


    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
    private function searchOdbc()
    {
        $campos = [
            "idEntregaDirecta",
            "codigo",
            "fecha",
            "centro_trabajo",
            "usuario_entrega",
            "usuario_recibe",
            "observaciones",
            "articuloId",
            "descripcion_articulo",
            "cantidad_articulos",
            "centro_trabajo_id",
            "codigo_articulo",
        ];
        $query = $this->repositoryDynamicsCrud->sqlSSR("mantenimiento_entregas_directas_view", $campos);
        return $query;
    }

    private function obtenerData()
    {
        $campos = [
            "idEntregaDirecta",
            "codigo",
            "fecha",
            "centro_trabajo",
            "usuario_entrega",
            "usuario_recibe",
            "observaciones",
            "articuloId",
            "descripcion_articulo",
            "cantidad_articulos",
            "codigo_articulo",
            "centro_trabajo_id",
        ];

        $columns = [];

        for ($i = 0; $i < sizeof($campos); $i++) {
            $columns[] = [
                'db' => $campos[$i],
                'dt' => $i,
            ];
        }

        $request = Request::capture();

        $query = $this->searchOdbc();
        $totalRecords = $query->count();

        if ($request->has('search') && $request->input('search.value')) {
            $searchValue = $request->input('search.value');

            $query->where(function ($q) use ($campos, $searchValue) {
                foreach ($campos as $campo) {
                    $q->orWhere($campo, 'LIKE', "%$searchValue%");
                }
            });
        }

        $filteredRecords = $query->count();


        if ($request->has('order')) {

            foreach ($request->input('order') as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex]['db'];
                $direction = $order['dir'];
                $query->orderBy($columnName, $direction);
            }
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        if ($length != -1) {
            $query->offset($start)->limit($length);
        }

        $data = $query->get();

        $response = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data->toArray(),
        ];

        return json_encode($response);
    }

    private function buscarEntregaDirectaPorId($id): array
    {
        $sql = "SELECT * FROM $this->tablaBaseDatos  WHERE id ='$id'";
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new Exception("Entrega directa no encontrada");
        }
        return $response;
    }

    private function eliminarArticulosORetonarAñadir($idEntrega, $articulosNuevos): array
    {

        $sql = "SELECT articulo_id FROM $this->tablaRelacionArticuloEntregaBaseDatos WHERE entrega_directa_id= '$idEntrega'";
        $articulosDB = $this->repositoryDynamicsCrud->sqlFunction($sql);

        $idsArticulosDb = array_column($articulosDB, "articulo_id");
        // $idsArticulosNuevos = array_column($articulosNuevos, "articuloId");

        // $articulosEliminar = array_diff($idsArticulosDb, $idsArticulosNuevos);
        $articulosEliminarString = implode(",", $idsArticulosDb);


        // if ($articulosEliminar) {

        $sqlEliminar = "DELETE FROM $this->tablaRelacionArticuloEntregaBaseDatos WHERE entrega_directa_id= '$idEntrega' AND articulo_id  IN ($articulosEliminarString)  ";
        $this->repositoryDynamicsCrud->sqlFunction($sqlEliminar);
        // }

        return $articulosNuevos;
    }
}
