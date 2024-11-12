<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloActivosFijos\SqlActivosFijosEquipos;
use App\Utils\Constantes\ModuloInventario\ConstantesArticulos;
use App\Utils\Constantes\ModuloMantenimiento\CActas;
use App\Utils\Constantes\ModuloMantenimiento\CItemsDiagnostico;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\FileManager;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceArticulos;
use App\Utils\TypesAdministrators;
use App\Utils\TypesCharges;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;

class ServicesActas implements IServicesActas
{


    private RepositoryDynamicsCrud $_repository;

    private $_cActas, $nombreTablaActa, $_ConstantesArticulos, $tablaItemsDiagnostico, $date, $sqlItemsDiagnostico;
    private $sqlActivosFijosEquipos, $serviceArticulos, $_fileManager;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->date = date("Y-m-d H:i:s");
        $this->_repository = $repositoryDynamicsCrud;

        $this->_cActas = new CActas;
        $this->_fileManager = new FileManager;
        $this->_ConstantesArticulos = new ConstantesArticulos;
        $this->sqlItemsDiagnostico = new CItemsDiagnostico;
        $this->sqlActivosFijosEquipos = new SqlActivosFijosEquipos;
        $this->serviceArticulos = new ServiceArticulos;

        $this->nombreTablaActa = tablas::getTablaClienteMantenimientoActas();
        $this->tablaItemsDiagnostico = tablas::getTablaClientemantenimientoItemsDiagnostico();
    }

    public function obtenerTodosActas()
    {
        $user = Auth::user();
        $isCompanyAdmin = $user->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR;
        $isUPMDirector = $user->tipo_administrador == TypesAdministrators::USER && $user->tipo_cargo == TypesCharges::MAINTENANCE_MANAGER_POSITION;

        if ($isCompanyAdmin || $isUPMDirector) {
            $sql = $this->_cActas->sqlActas();
        } else {
            $sql = $this->_cActas->sqlActaAsignadasAlTecnico($user->id);
        }

        $response = $this->_repository->sqlFunction($sql);
        $actasMapeadas = [];
        foreach ($response as $actaActual) {
            $idActaActual = $actaActual->actaId;
            $actaEncontrada = $this->encontrarActaEnMapeadas($actasMapeadas, $actaActual);

            if (!$actaEncontrada) {
                $actaEncontrada = $this->crearNuevoActa($actasMapeadas, $actaActual);
            }

            $this->agregarArticuloSiNoExiste($actaEncontrada, $actaActual);
            $this->agregarHorasExtrasSiNoExiste($actaEncontrada, $actaActual);

            $this->agregarDiferenciaDiasActa($actaEncontrada);
        }



        // TODO: fin de actas

        foreach ($actasMapeadas  as $actaMapeada) {
            $sqlOrden = $this->_cActas->sqlObtenerTecnicosAlaActa($actaMapeada->ordenId, $actaMapeada->codigoOrden);
            $respuestaTecnicos = $this->_repository->sqlFunction($sqlOrden);
            $actaMapeada->tecnicosActas = [$respuestaTecnicos];

            if ($actaMapeada->actaId) {
                $sqlOrden = $this->sqlItemsDiagnostico->sqlItemsTipoOrden($actaMapeada->asignacionActa, $actaMapeada->actaId);
                $respuestaItems = $this->_repository->sqlFunction($sqlOrden);
                $actaMapeada->itemsConRespuesta = $respuestaItems;
            } else {
                $actaMapeada->itemsConRespuesta = [];
            }
        }


        foreach ($actasMapeadas  as $actaMapeada) {
            if ($actaMapeada->equipoId) {
                $sql = $this->sqlActivosFijosEquipos->sqlGetIdentification($actaMapeada->equipoId);
                $response = $this->_repository->sqlFunction($sql);
                $codigo = $response[0]->codigo;
                $serial  = $response[0]->serial_equipo;
            } else {
                $codigo = $actaMapeada->vehiculoId;
                $serial = null;
            }

            $actaMapeada->codigo = $codigo;
            $actaMapeada->serial = $serial;
        }
        return $actasMapeadas;
    }


    private function encontrarActaEnMapeadas(array $actasMapeadas = [], $actaActual)
    {
        foreach ($actasMapeadas as $obj) {
            if (($obj->actaId) && $obj->actaId == $actaActual->actaId && ($actaActual->codigoOrden == $obj->codigoOrden)) {
                return $obj;
            }
        }
        return null;
    }
    private function crearNuevoActa(array &$actasMapeadas, object $actaActual)
    {
        $arrayActa = json_decode(json_encode($actaActual), true);
        $acta = (object) $arrayActa;
        $acta->diasDiferencia = "";
        $acta->articulos = [];
        $acta->horasExtras = [];
        $actasMapeadas[] = $acta;

        return $acta;
    }

    private function agregarArticuloSiNoExiste(object $obj, object $actaActual)
    {
        $encontrarArticulo = collect($obj->articulos)->first(function ($articulo) use ($actaActual) {
            return $articulo['idArticulo'] == $actaActual->idArticuloMantInsumos;
        });

        if (!$encontrarArticulo) {
            $obj->articulos[] = [
                "idArticulo" => $actaActual->idArticuloMantInsumos,
                "descripcionArticulo" => "$actaActual->codigoInventarioArticulos - $actaActual->descripcionInventarioArticulos",

                "fecha" => $actaActual->fechaMantInsumos,
                "cantidad" => $actaActual->cantidadMantInsumos,
                "tipo" => $actaActual->clasificacion_articulo,
            ];
        }
    }

    private function agregarHorasExtrasSiNoExiste(object $obj, object $actaActual)
    {
        $encontrarHoraExtra = collect($obj->horasExtras)->first(function ($horaExtra) use ($actaActual) {
            return $horaExtra['id'] == $actaActual->idHorasExtras;
        });

        if (!$encontrarHoraExtra) {
            $obj->horasExtras[] = [
                "id" => $actaActual->idHorasExtras,
                "fecha_inicio" => $actaActual->fecha_inicio,
                "fecha_fin" => $actaActual->fecha_fin,
                "horaDiferencia" => $actaActual->horas_extras,
                "tecnicoId" => $actaActual->tecnicoHorasExtras ?? 0,
            ];
        }
    }
    private function agregarDiferenciaDiasActa(object $obj)
    {
        if (!$obj->fechaFinalSolicitud) {
            return;
        }

        $partes = explode(" ", $obj->fechaFinalSolicitud);
        $fechaFinal = $partes[0];

        $fechaInicial = strtotime($obj->fechaCreacionOrden);
        $fechaFinal2 = strtotime($fechaFinal);

        $diferenciaSegundos = $fechaFinal2 - $fechaInicial;
        $diferenciaDias2 = ceil($diferenciaSegundos / (60 * 60 * 24));
        $obj->diasDiferencia = $diferenciaDias2 + 1;
    }

    public function obtenerCentroTrabajo($entidadActa)
    {
        $userIdTecnico = Auth::user()->id;
        $sql = $this->_cActas->sqlObtenerCentro($entidadActa['ordenId'], $userIdTecnico, $entidadActa['tipoOrden']);
        return $this->_repository->sqlFunction($sql);
    }


    public function crearActas($request)
    {
        $entidadActas = $request->all();

        try {
            if (Auth::user()->tipo_administrador != 4) {
                $this->buscarTecnico();
                $this->validateActa($entidadActas);
            }
            $verficarArticulos = isset($entidadActas['articulos']);
            $validarHorasExtras = isset($entidadActas['horasExtras']);
            $validarItems = isset($entidadActas['itemDiagnostico']);

            $validarItems = isset($entidadTipoItemsDiagnosticos['itemDiagnostico']);

            if ($verficarArticulos) {
                $articulosDecode = json_decode($entidadActas['articulos'], true);
                $entidadActas['articulos'] = $articulosDecode;
                $this->validarArticulos($articulosDecode);
            }
            if ($validarHorasExtras) {
                $this->validarTecnicosAsociadosOrden($entidadActas['horasExtras'], $entidadActas['asig_acta_id']);
            }

            $entidadActas['ruta_imagen'] = $request->hasFile("ruta_imagen")
                ? $this->_fileManager->pushImagen($request, 'mantenimiento/actas', "")
                : "";
            // $insertaActa['ruta_imagen'] = $entidadActas['ruta_imagen'];
            $insertaActa = $this->mapearActa($entidadActas);
            $idActa = $this->_repository->getRecordId($this->nombreTablaActa, $insertaActa);

            if ($validarItems) {
                $this->actualizarOCrearItemsDiagnoticoDeActas($idActa, $entidadActas['itemDiagnostico']);
            }

            if ($verficarArticulos) {
                $insertActaInsumos = $this->maperActaInsumos($idActa, $entidadActas);
                $this->_repository->createInfo("mantenimiento_insumos", $insertActaInsumos);
            }

            if (isset($entidadActas['horasExtras'])) {
                $insertActaInsumos = $this->maperHorasExtras($idActa, $entidadActas['horasExtras']);
                $this->_repository->createInfo("mantenimiento_horas_extras", $insertActaInsumos);
            }

            $codigoEstadoFinalizacionSolicitud = 3;
            $solicitudArray = array("fecha_finalizacion" =>  $this->date, "estado_id" => $codigoEstadoFinalizacionSolicitud);
            $this->_repository->updateInfo("mantenimiento_solicitudes", $solicitudArray, $entidadActas["idSolicitud"]);

            return response()->json([json_encode($entidadActas['ruta_imagen'])], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    private function buscarTecnico()
    {
        $idTecnico = Auth::user()->id;
        $sql = $this->_cActas->sqlBuscarTecnico($idTecnico);
        return $this->buscarRegistro($sql, "Tecnico no encotrado");
    }

    private function validarArticulos(array $articulosId)
    {

        array_map(function ($articulo) {
            $idArticulo = $articulo->idArticulo;
            $sql = $this->_ConstantesArticulos->sqlSelectEntidadById($idArticulo);
            $response = $this->_repository->sqlFunction($sql);
            if (!$response) {
                throw new Exception("Articulo no encontrado $idArticulo");
            }
        }, json_decode(json_encode($articulosId)));
        return true;
    }


    private function validateActa(array $entidadActas)
    {
        try {

            $actaId = $entidadActas['asig_acta_id'];
            $acta = $this->buscarAsignacionActa($actaId);

            $sqlActa = $this->_cActas->sqlTipoOrdenActa($actaId);
            $respuestaActa = $this->_repository->sqlFunction($sqlActa);

            if (!$respuestaActa) {
                throw new Exception("Acta no valida");
            }
            $idUsuarioTecnico = Auth::user()->id;
            $sqlValidarTecnico = $this->_cActas->sqlValidarTecnicoPertenecienteAlaActa($idUsuarioTecnico, $acta[0]->tipo_orden_id, $acta[0]->orden_id);

            $respuestaValidarTecnico = $this->_repository->sqlFunction($sqlValidarTecnico);

            if (!$respuestaValidarTecnico) {
                throw new Exception("El tecnico no pertenece a la acta a reportar");
            }


            $sqlTecnicoPertenecienteALaOrden = $this->_cActas->sqlTecnicoPertenecienteALaOrden($idUsuarioTecnico, $respuestaValidarTecnico[0]->idTipoOrden);
            $response1 = $this->_repository->sqlFunction($sqlTecnicoPertenecienteALaOrden);
            if (!$response1) {
                throw new Exception("El tenico  no pertenece a la orden asignada");
            }

            $sqlactaAsignadaAlTecnico = $this->_cActas->sqlactaAsignadaAlTecnico($respuestaValidarTecnico[0]->idOrden, $respuestaValidarTecnico[0]->idTipoOrden, $idUsuarioTecnico);
            $response2 = $this->_repository->sqlFunction($sqlactaAsignadaAlTecnico);

            if (!$response2) {
                throw new Exception("El tenico de la orden no pertenece a la orden asignada");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private function buscarAsignacionActa(int $idActa)
    {

        $sql = $this->_cActas->sqlBuscarAsignacionActa($idActa);
        return $this->buscarRegistro($sql, "Asignacion de acta no encontrada");
    }

    private function mapearActa(array $entidadActas)
    {
        $esAdministrador = Auth::user()->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR;
        $acta =  array(
            'asig_acta_id' => $entidadActas['asig_acta_id'],
            'fecha' => $entidadActas['fecha'],
            'tipo_mantenimiento' => $entidadActas['tipo_mantenimiento'],
            'horometro' => $entidadActas['horometro'],
            'kilometraje' => $entidadActas['kilometraje'],
            'observacion' => $entidadActas['observacion'],
            'ruta_imagen' => $entidadActas['ruta_imagen'],
        );
        if (!$esAdministrador) {
            $acta['tecnico_id'] = Auth::user()->id;
        }
        return $acta;
    }

    private function validarIdsItemsDiagnostico(array $itemsDiagnosticos)
    {
        $sql = "SELECT id FROM $this->tablaItemsDiagnostico";
        $itemsExistentes = $this->_repository->sqlFunction($sql);
        array_map(function ($itemDiagnostico) use ($itemsExistentes) {
            $idItemDiagnostico = EncryptionFunction::StaticDesencriptacion($itemDiagnostico['id']);
            if ((in_array($idItemDiagnostico, $itemsExistentes, false))) {
                throw new Exception("item no encontrado $idItemDiagnostico");
            }
        }, $itemsDiagnosticos);
    }


    private function actualizarOCrearItemsDiagnoticoDeActas($actaId, array $itemsDiagnosticos)
    {
        $this->validarIdsItemsDiagnostico($itemsDiagnosticos);

        return array_map(function ($itemDiagnostico) use ($actaId) {
            $idItemDiagnostico = EncryptionFunction::StaticDesencriptacion($itemDiagnostico['id']);
            $sqlExisteItem = $this->_cActas->sqlVerificarSiExisteItem($actaId, $idItemDiagnostico);
            $existeRelacionItem = $this->_repository->sqlFunction($sqlExisteItem);


            $item = array(
                'acta_id' => $actaId,
                'item_diagnostico_id' => $idItemDiagnostico,
                'respuesta' => isset($itemDiagnostico['respuestaItems']) ? $itemDiagnostico['respuestaItems'] : '',
                'observacion' => isset($itemDiagnostico['observacionItems']) ? $itemDiagnostico['observacionItems'] : ''
            );
            if (!$existeRelacionItem) {
                return  $this->_repository->createInfo("mantenimiento_actas_diag", $item);
            }

            return $this->_repository->updateInfo("mantenimiento_actas_diag", $item, $existeRelacionItem[0]->id);
        }, $itemsDiagnosticos);
    }
    private function maperActaInsumos(int $actaId, array $entidadActas)
    {
        return array_map(function ($idArticulo) use ($actaId, $entidadActas) {
            return array(
                'acta_id' => $actaId,
                'articulo_id' => $idArticulo->idArticulo,
                'fecha' => $entidadActas['fecha'],
                'cantidad' => isset($idArticulo->cantidad) ? $idArticulo->cantidad : '',
                'clasificacion_articulo' => isset($idArticulo->tipo) ? $idArticulo->tipo : '',
            );
        }, json_decode(json_encode($entidadActas['articulos'])));
    }

    private function maperHorasExtras(int $actaId, array $horasExtras)
    {
        return array_map(function ($horaExtra) use ($actaId) {
            $horasExtras = $this->calcularHorasExtras($horaExtra->fecha_inicio, $horaExtra->fecha_fin);
            return array(
                'acta_id' => $actaId,
                'tecnico_id' => isset($horaExtra->tecnicoId) ? $horaExtra->tecnicoId : '',
                'fecha_inicio' => isset($horaExtra->fecha_inicio) ? $horaExtra->fecha_inicio : '',
                'fecha_fin' => isset($horaExtra->fecha_fin) ? $horaExtra->fecha_fin : '',
                'horas_extras' => $horasExtras
            );
        }, json_decode(json_encode($horasExtras)));
    }




    // TODO: ------------------------------
    public function actualizarActas($id, $request)
    {
        $entidadTipoItemsDiagnosticos = $request->all();
        try {
            if (Auth::user()->tipo_administrador != TypesAdministrators::COMPANY_ADMINISTRATOR) {
                $this->buscarTecnico();
                $this->validateActa($entidadTipoItemsDiagnosticos);
            }
            $verficarArticulos = isset($entidadTipoItemsDiagnosticos['articulos']);

            $validarItems = isset($entidadTipoItemsDiagnosticos['itemDiagnostico']);
            if ($verficarArticulos) {
                $articulosDecode = json_decode($entidadTipoItemsDiagnosticos['articulos'], true);
                $entidadTipoItemsDiagnosticos['articulos'] = $articulosDecode;
                $this->validarArticulos($articulosDecode);
            }
            $sqlBuscarActa = "SELECT * FROM $this->nombreTablaActa WHERE id = '$id'";
            $actaDb =   $this->_repository->sqlFunction($sqlBuscarActa);
            $respuestaImagen = "no modificada";
            if ($request->hasFile("ruta_imagen")) {
                $pathImagen = $actaDb[0]->ruta_imagen;
                if ($pathImagen) {
                    $this->_fileManager->deleteImage($pathImagen);
                }
                $respuestaImagen = $this->_fileManager->pushImagen($request, 'mantenimiento/actas', "");
                $entidadTipoItemsDiagnosticos['ruta_imagen'] = $respuestaImagen;
            } else {
                $entidadTipoItemsDiagnosticos['ruta_imagen'] = $actaDb[0]->ruta_imagen;
            }
            $insertaActa = $this->mapearActa($entidadTipoItemsDiagnosticos);;
            $response = $this->_repository->updateInfo($this->nombreTablaActa, $insertaActa, $id);

            if ($validarItems) {
                $this->actualizarOCrearItemsDiagnoticoDeActas($id, $entidadTipoItemsDiagnosticos['itemDiagnostico']);
            }

            if ($verficarArticulos) {
                $this->eliminarRelacionesConArticulos($id);
                $insertActaInsumos = $this->maperActaInsumos($id, $entidadTipoItemsDiagnosticos);
                $this->_repository->createInfo("mantenimiento_insumos", $insertActaInsumos);
            }

            if (isset($entidadTipoItemsDiagnosticos['horasExtras'])) {
                $this->eliminarRelacionesHorasExtras($id);
                $insertActaInsumos = $this->maperHorasExtras($id, $entidadTipoItemsDiagnosticos['horasExtras']);
                $this->_repository->createInfo("mantenimiento_horas_extras", $insertActaInsumos);
            }

            $solicitudArray = array("fecha_finalizacion" =>  $this->date, "estado_id" => 4);
            $this->_repository->updateInfo("mantenimiento_solicitudes", $solicitudArray, $entidadTipoItemsDiagnosticos["idSolicitud"]);
            return response()->json("Registro actualizado exitosamente !!!!!!!!!!!!!!!!!!!!!!!", 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function buscarCodigoItem(string $codigo, int $id = null)
    {
        $sql = ($id) ?
            "SELECT * FROM $this->nombreTablaActa WHERE codigo = '$codigo' AND id !=$id"
            : "SELECT * FROM $this->nombreTablaActa WHERE codigo = '$codigo'";
        $response = $this->_repository->sqlFunction($sql);
        if ($response) {
            throw new Exception("Codigo ya disponible");
        }
        return $response;
    }

    public function obtenerVehiculoOEquipo($data)
    {
        $userTecnicoId = Auth::user()->id;
        $sql = $this->_cActas->sqlObtenerVehiculoOEquipo(
            $data['ordenId'],
            $userTecnicoId,
            $data['tipoOrden'],
        );
        return $this->_repository->sqlFunction($sql);
    }

    private function buscarRegistro(string $sql, string $mensajeError)
    {

        $response = $this->_repository->sqlFunction($sql);

        if (empty($response)) {
            throw new Exception($mensajeError);
        }

        return $response;
    }

    private function desencriptarKey(string $id)
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }

    private function eliminarRelacionesConArticulos($actaId)
    {
        $sql = "DELETE FROM mantenimiento_insumos WHERE acta_id = $actaId";
        return $this->_repository->sqlFunction($sql);
    }
    private function eliminarRelacionesHorasExtras(int $actaId)
    {
        $sql = "DELETE FROM mantenimiento_horas_extras WHERE acta_id = $actaId";
        return $this->_repository->sqlFunction($sql);
    }

    private function validarTecnicosAsociadosOrden(array $horasExtras, int $idAsig)
    {
        array_map(function ($horaExtra) use ($idAsig) {
            $tecnicoId = json_encode($horaExtra['tecnicoId']);
            $sql =
                "SELECT mot.* 
                FROM mantenimiento_asig_actas maa 
                LEFT JOIN mantenimiento_ordenes_tecnicos mot ON mot.orden_id = maa.orden_id 
                WHERE maa.id = $idAsig AND mot.tecnico_id = $tecnicoId;
            ";

            $response = $this->_repository->sqlFunction($sql);
            if (!$response) {
                throw new Exception("Hay tecnicos que no estan asociados a la orden");
            }

            $datetime1 = new DateTime($horaExtra['fecha_inicio']);
            $datetime2 = new DateTime($horaExtra['fecha_fin']);
            if ($datetime2 < $datetime1) {
                throw new Exception('La fecha final no puede ser antes de la inicial ');
            }
            return true;
        }, $horasExtras);
    }

    private function calcularHorasExtras($fechaInicial, $fechaFinal)
    {
        $datetime1 = new DateTime($fechaInicial);
        $datetime2 = new DateTime($fechaFinal);
        $interval = $datetime1->diff($datetime2);

        $totalHoras = $interval->days * 24 + $interval->h;
        return "$totalHoras:$interval->i";
    }
    public function tecnicosAsociadasOrden($ordenId)
    {
        $sql = $this->_cActas->sqlTecnicoAsociadoAlaOrden($ordenId);
        return $this->_repository->sqlFunction($sql);
    }
}
