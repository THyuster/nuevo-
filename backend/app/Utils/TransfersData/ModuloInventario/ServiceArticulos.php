<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\ModuloInventario\Color\CColor;
use App\Utils\Constantes\ModuloInventario\ConstantesArticulos;
use App\Utils\Constantes\ModuloInventario\ConstantesGrupoArticulos;
use App\Utils\Constantes\ModuloInventario\ConstantesGruposContables;
use App\Utils\Constantes\ModuloInventario\ConstantesMarcas;
use App\Utils\Constantes\ModuloInventario\ConstantesTipoArticulos;
use App\Utils\Constantes\ModuloInventario\ConstantesUnidades;
use App\Utils\Constantes\ModuloInventario\Departamentos\CDepartamentos;
use App\Utils\Constantes\ModuloInventario\Linea\CLinea;
use App\Utils\Constantes\ModuloInventario\Talla\CTalla;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\FileManager;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloConfiguracion\LogImportaciones;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use stdClass;

class ServiceArticulos
{
    protected $constantesArticulos, $constantesGrupoContable,  $tablaLogImportaciones, $serviceLogImportaciones;
    protected $constantesGrupoArticulo, $constantesTipoArticulo, $constantesUnidad, $tablaGrupoArticulo;
    protected $constantesMarca, $repository, $fileManager, $funciones, $sqlLinea, $tablaGrupoContable;
    protected $sqlTalla, $sqlColor, $sqlDepartamentos, $tableName = "inventarios_articulos2";
    private $tablaLinea, $tablaGrupoColor, $tablaGrupoDepartamento, $tablaMarca, $tablaUnidades, $tablaCodigoBienServicio,
        $tablaCodigoUnidades;
    public function __construct()
    {
        $this->inyeccionDependencias();
    }

    public function createArticulo($formularioData, Request $request)
    {
        try {
            $this->validateInputs($formularioData);
            
            
            $formularioData['ruta_imagen'] = "";
            $formularioData['ruta_ficha_tecnica'] = "";
            $formularioData['IPUU'] = isset($formularioData['IPUU']) ? "✔️" : null;
            $formularioData['iva_mayor_costo'] = isset($formularioData['iva_mayor_costo']) ? "✔️" : null;
            if ($request->hasFile("ruta_imagen")) {
                $formularioData['ruta_imagen'] = $this->fileManager->pushImagen($request, "articulos", "");
            }

            return $this->repository->createInfo("inventarios_articulos2", $formularioData);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateArticulo($id, $dataUpdate, Request $request)
    {
        try {

            $sqlArticulos = $this->constantesArticulos->sqlSelectEntidadById($id);
            $this->validateInputs($dataUpdate, $id);
            
            $entidadArticuloAfter = $this->findRecord($sqlArticulos, "Articulo No Encontrado");
            
            if ($request->hasFile("ruta_imagen")) {
                if ($entidadArticuloAfter[0]->ruta_imagen) {

                    $this->fileManager->deleteImage($entidadArticuloAfter[0]->ruta_imagen);
                }
                $dataUpdate['ruta_imagen'] = $this->fileManager->pushImagen($request, "articulos", "");
            } else {
                $dataUpdate['ruta_imagen'] = $entidadArticuloAfter[0]->ruta_imagen;
            }
            $dataUpdate['IPUU'] = isset($dataUpdate['IPUU']) ? "✔️" : null;
            $dataUpdate['iva_mayor_costo'] = isset($dataUpdate['iva_mayor_costo']) ? "✔️" : null;

            return $this->repository->updateInfo($this->tableName, $dataUpdate, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private function validateInputs($formularioData, $id = null)
    {
        try {
            $this->validateCode($formularioData['codigo'], $id);

            $queryAccountingGroup = $this->constantesGrupoContable->sqlSelectById($formularioData['grupo_contable_id']);
            $this->findRecord($queryAccountingGroup, "Grupo Contable No Encontrado");

            $queryArticle = $this->constantesGrupoArticulo->sqlSelectById($formularioData['grupo_articulo_id']);
            $this->findRecord($queryArticle, "Grupo Articulo No Encontrado");

            $queryUnit = $this->constantesUnidad->sqlSelectById($formularioData['tipo_unidad_id']);
            $this->findRecord($queryUnit, "Unidad No Encontrada");
            //-------
            $fksOptional = array(
                'marca_id' => 'inventarios_marcas',
                'linea_id' => 'inventarios_linea',
                'talla_id' => 'inventarios_talla',
                'color_id' => 'inventarios_color',
                'departamento_id' => 'inventarios_departamento',
            );

            foreach ($fksOptional as $fk => $tabla) {
                if (isset($formularioData[$fk])) {
                    $value = $formularioData[$fk];
                    $query = "SELECT * FROM $tabla WHERE id =  '$value'";
                    $this->findRecord($query, "$fk No Encontrada");
                }
            }
        } catch (\Throwable $th) {
            throw new ($th->getMessage());
        }
    }

    public function deleteArticulo($id)
    {
        $sqlArticulo = $this->constantesArticulos->sqlSelectEntidadById($id);
        $article = $this->findRecord($sqlArticulo, "Articulo No Encontrado");
        if ($article[0]->ruta_imagen) {
            $this->fileManager->deleteImage($article[0]->ruta_imagen);
        }
        return $this->repository->deleteInfoAllOrById($this->tableName, $id);
    }



    private function findRecord($sql, $messageError)
    {
        $response = $this->repository->sqlFunction($sql);
        if (!$response) {
            throw new \Exception($messageError, 404);
        }
        return $response;
    }
    private function validateCode($codigo, $id)
    {
        $sql = ($id) ? "SELECT * FROM inventarios_articulos2 WHERE codigo ='{$codigo}' AND id !='{$id}'"
            : "SELECT * FROM inventarios_articulos2 WHERE codigo =  '{$codigo}'";

        // dump($sql);
        $response = $this->repository->sqlFunction($sql);

        return !$response ? $response : throw new \Exception('Codigo ya existe');
    }

    public function  articlesApprovals()
    {
        $sql  = "SELECT * FROM ( SELECT DISTINCT mrh.*, ia.id idArticulo, ia.descripcion descripcionArticulo, ia.codigo codigoArticulo, mi.clasificacion_articulo FROM inventarios_articulos2 ia LEFT JOIN mantenimiento_relacion_homologaciones_articulos mrh ON ia.id = mrh.id_articulo LEFT JOIN mantenimiento_insumos mi ON (mi.articulo_id = ia.id)  ORDER BY mi.clasificacion_articulo, mrh.id_homologacion IS NULL, mrh.id_homologacion, mrh.articulo_principal DESC ) AS unique_articles;";
        $response = $this->repository->sqlFunction($sql);

        $dataArticulo = [];
        foreach ($response as $dataActual) {
            if (!$dataActual->id_homologacion) {
                $dataArticulo[] = (object)[
                    "tipo" => $dataActual->clasificacion_articulo,
                    "principal" => null,
                    "idArticulo" => $dataActual->idArticulo,
                    "codigoArticulo" => $dataActual->codigoArticulo,
                    "descripcionArticulo" => $dataActual->descripcionArticulo,
                    "articulosSecundarios" => []
                ];
                continue;
            }
            $idHomologacionEncotrado = collect($dataArticulo)->firstWhere('id_homologacion', $dataActual->id_homologacion);
            if (!$idHomologacionEncotrado) {
                $articuloPrincipal = $dataActual->articulo_principal ?? false;
                $objectoHomologacion = json_decode(json_encode($dataActual), true);
                $nuevaHomologacion = (object) $objectoHomologacion;
                $nuevaHomologacion->tipo = $dataActual->clasificacion_articulo;
                $nuevaHomologacion->articuloPrincipal = $dataActual->idArticulo;
                $nuevaHomologacion->articuloPrincipalTrue = true;
                $nuevaHomologacion->articulosSecundarios = [];
                $dataArticulo[] = $nuevaHomologacion;

                $idHomologacionEncotrado = $nuevaHomologacion;
            }

            $encontrarArticuloSecundario = collect($idHomologacionEncotrado->articulosSecundarios)->first(function ($articuloSecundario) use ($dataActual) {
                return $articuloSecundario["idArticulo"] == $dataActual->idArticulo;
            });

            if (!$encontrarArticuloSecundario && ($dataActual->articulo_principal == 0)) {
                $idHomologacionEncotrado->articulosSecundarios[] = [
                    // "id" =>  $dataActual->idArticulo,
                    "homologacion" => true,
                    "tipo" => $dataActual->clasificacion_articulo,
                    "idArticulo" => $dataActual->idArticulo,
                    "codigoArticulo" => $dataActual->codigoArticulo,
                    "descripcionArticulo" => $dataActual->descripcionArticulo,
                ];
            }
        }
        return $dataArticulo;
    }

    public function importacionArticulosTns($dsn)
    {

        $codigos = $this->obtenerCodigoArticulosBD();
        $camposValidar = $this->camposAvalidar();

        $codigosMapeados = $this->mapearCodigo($codigos);
        $sqlQuery = $this->constantesArticulos->sqlArticleImportacion(implode(",", $codigosMapeados));

        $dataMapeada =  $this->funciones->getDataOdbc($sqlQuery, $dsn);
        $datosDelasTablasValidar = $this->obtenerDatos();

        $nuevaData = array();
        foreach ($dataMapeada as $datoActual) {
            foreach ($camposValidar as $campos) {

                $campoValidar =  $campos['campoValidar'];
                $codigoActual = (empty($datoActual[$campoValidar]) ? '00' : $datoActual[$campoValidar]);

                $encontrar = false;
                $idRegistroCodigoEncontrado = 0;

                foreach ($datosDelasTablasValidar[$campoValidar] as $obj) {
                    if ($codigoActual == $obj->codigo) {
                        $encontrar = true;
                        $idRegistroCodigoEncontrado = $obj->id;
                        break;
                    }
                }

                if (!$encontrar) {
                    $idCreado = $this->crearCodigo($campos['tabla']);
                    $registroCreado =  (object) ["id" => $idCreado, "codigo" => "00"];
                    array_push($datosDelasTablasValidar[$campoValidar], $registroCreado);
                }
                unset($datoActual[$campoValidar]);
                $campoAñadir = $campos['campoAñadir'];
                $datoActual[$campoAñadir] = $idRegistroCodigoEncontrado == 0 ? $idCreado : $idRegistroCodigoEncontrado;
            }
            array_push($nuevaData, $datoActual);
        }

        $this->repository->createInfo($this->tableName, $nuevaData);
        return $this->serviceLogImportaciones->crearLogImportacion("TNS", $dsn, "Inventario", 1, "Articulos", "Creo");
    }


    private function BuscarCodigo($tabla, $codigo)
    {
        $sql = "SELECT id FROM $tabla WHERE codigo = '$codigo'";
        $registro =  $this->repository->sqlFunction($sql);
        return ($registro) ? $registro[0]->id :  false;
    }
    private function crearCodigo($tabla)
    {

        $newCodigo = array('codigo' => '00', 'descripcion' => 'Sin clasificar');
        $sql = "SELECT * FROM $tabla WHERE codigo = '00'";

        $registro =  $this->repository->sqlFunction($sql);

        if (!$registro) {
            return $this->repository->getRecordId($tabla, $newCodigo);
        }

        return $registro[0]->id;
    }

    private function camposAvalidar()
    {
        $campos =   [
            [
                'tabla' =>  $this->tablaGrupoContable,
                'campoValidar' => 'CODIGO_GRUPO_CONTABLE',
                'campoAñadir' => 'grupo_contable_id'
            ],
            [
                'tabla' =>  $this->tablaGrupoArticulo,
                'campoValidar' => 'CODIGO_GRUPO_ARTICULO',
                'campoAñadir' => 'grupo_articulo_id'
            ],
            [
                'tabla' =>  $this->tablaGrupoDepartamento,
                'campoValidar' => 'CODIGO_DEPARTAMENTO',
                'campoAñadir' => 'departamento_id'
            ],
            [
                'tabla' =>  $this->tablaLinea,
                'campoValidar' => 'CODIGO_LINEA',
                'campoAñadir' => 'linea_id'
            ],
            [
                'tabla' =>  $this->tablaMarca,
                'campoValidar' => 'CODIGO_MARCA',
                'campoAñadir' => 'marca_id'
            ],
            [
                'tabla' =>  $this->tablaGrupoColor,
                'campoValidar' => 'CODIGO_COLOR',
                'campoAñadir' => 'color_id'
            ],
            [
                'tabla' =>  $this->tablaCodigoUnidades,
                'campoValidar' => 'CODIGO_UNIDADES_ID',
                'campoAñadir' => 'codigo_unidades_id'
            ],
            [
                'tabla' =>  $this->tablaCodigoBienServicio,
                'campoValidar' => 'CODIGO_BIEN_SERVICIO_ID',
                'campoAñadir' => 'codigo_bien_servicio_id'
            ],
        ];
        return $campos;
    }


    private function obtenerDatos()
    {
        $sqlGrupoContable = "SELECT * FROM $this->tablaGrupoContable";
        $sqlGrupoArticulo = "SELECT * FROM $this->tablaGrupoArticulo";
        $sqlLinea = "SELECT * FROM $this->tablaLinea";
        $sqlGrupoColor = "SELECT * FROM $this->tablaGrupoColor";
        $sqlGrupoDepartamento = "SELECT * FROM $this->tablaGrupoDepartamento";
        $sqlMarca = "SELECT * FROM $this->tablaMarca";
        $sqlUnidades = "SELECT * FROM $this->tablaCodigoUnidades";
        $sqlCodigoBienServicio = "SELECT * FROM $this->tablaCodigoBienServicio";

        $respuestaContable =   $this->repository->sqlFunction($sqlGrupoContable);
        $respuestaArticulo =   $this->repository->sqlFunction($sqlGrupoArticulo);
        $respuestaLinea =   $this->repository->sqlFunction($sqlLinea);
        $respuestaaGrupoColor =   $this->repository->sqlFunction($sqlGrupoColor);
        $respuestaGrupoDepartamento =   $this->repository->sqlFunction($sqlGrupoDepartamento);
        $respuestaMarca =   $this->repository->sqlFunction($sqlMarca);
        $tablaCodigoUnidades =   $this->repository->sqlFunction($sqlUnidades);
        $respuestaCodigoBienServicio =   $this->repository->sqlFunction($sqlCodigoBienServicio);

        return [
            'CODIGO_GRUPO_CONTABLE' => $respuestaContable,
            'CODIGO_GRUPO_ARTICULO' => $respuestaArticulo,
            'CODIGO_DEPARTAMENTO' => $respuestaGrupoDepartamento,
            'CODIGO_LINEA' => $respuestaLinea,
            'CODIGO_MARCA' => $respuestaMarca,
            'CODIGO_COLOR' => $respuestaaGrupoColor,
            'CODIGO_UNIDADES_ID' => $tablaCodigoUnidades,
            'CODIGO_BIEN_SERVICIO_ID' => $respuestaCodigoBienServicio
        ];
    }

    private function obtenerDatosRefactorizado()
    {

        $tablas = [
            $this->tablaGrupoContable,
            $this->tablaGrupoArticulo,
            $this->tablaLinea,
            $this->tablaGrupoColor,
            $this->tablaGrupoDepartamento,
            $this->tablaMarca,
            $this->tablaUnidades
        ];
        $campos = $this->camposAvalidar();
        $nuevosDatos = new stdClass();

        for ($i = 0; $i < count($tablas); $i++) {
            $tabla = $tablas[$i];
            $sql = "SELECT * FROM $tabla";

            $campo = $campos[$i]['campoValidar'];
            $response = $this->repository->sqlFunction($sql);

            $nuevosDatos->$campo = $response;
        }
        return json_decode(json_encode($nuevosDatos), true);
    }

    private function filtrarArticulosNoReptidosTns(array $articulos)
    {
        $articulosDB =  $this->repository->sqlFunction("SELECT codigo FROM $this->tableName");
        $codigos = array_column($articulosDB, "codigo");
    }


    private function obtenerCodigoArticulosBD()
    {
        $articulosDB =  $this->repository->sqlFunction("SELECT codigo FROM $this->tableName");
        return array_column($articulosDB, "codigo");
    }
    private function mapearCodigo($codigosArticulos)
    {
        foreach ($codigosArticulos as &$element) {
            $element =  (is_numeric($element)) ? "'" . $element . "'" : "'$element'";
        }
        // salida: ['1025', '2421']
        return $codigosArticulos;
    }

    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }

    private function inyeccionDependencias()
    {
        $this->sqlColor = new CColor;
        $this->sqlLinea = new CLinea;
        $this->sqlTalla = new CTalla;

        $this->sqlDepartamentos = new CDepartamentos;
        $this->constantesMarca = new ConstantesMarcas;
        $this->constantesUnidad = new ConstantesUnidades;
        $this->constantesArticulos = new ConstantesArticulos;
        $this->constantesTipoArticulo = new ConstantesTipoArticulos;
        $this->constantesGrupoArticulo = new ConstantesGrupoArticulos;
        $this->constantesGrupoContable = new ConstantesGruposContables;

        $this->funciones = new MyFunctions;
        $this->fileManager = new FileManager;

        $this->repository = new RepositoryDynamicsCrud;
        $this->serviceLogImportaciones = new LogImportaciones;

        $this->tablaGrupoContable = tablas::getTablaClienteInventarioGrupoContables();
        $this->tablaGrupoArticulo = tablas::getTablaClienteInventarioGrupoArticulos();
        $this->tablaLinea = tablas::getTablaClienteInventarioLinea();
        $this->tablaGrupoColor = tablas::getTablaClienteInventarioColor();
        $this->tablaGrupoDepartamento = tablas::getTablaClienteInventarioDepartamento();
        $this->tablaMarca = tablas::getTablaClienteInventarioMarcas();
        $this->tablaUnidades = tablas::getTablaClienteInventarioUnidades();
        $this->tablaCodigoBienServicio = tablas::getTablaErpInventarioCodigoBienServicio();
        $this->tablaCodigoUnidades = tablas::getTablaErpInventarioCodigoUnidades();
        $this->tablaLogImportaciones = tablas::getTablaClienteLogImportaciones();
    }
}