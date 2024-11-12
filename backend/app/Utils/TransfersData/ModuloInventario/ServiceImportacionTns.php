<?php

namespace App\Utils\TransfersData\ModuloInventario;

use App\Utils\ModulesCode;
use App\Utils\Constantes\ModuloInventario\Color\CColor;
use App\Utils\Constantes\ModuloInventario\Linea\CLinea;
use App\Utils\Constantes\ModuloInventario\Talla\CTalla;
use App\Utils\TransfersData\Erp\ServicesConexionesOdbc;
use App\Utils\TransfersData\ModuloInventario\Color\SColorInventario;
use App\Utils\TransfersData\ModuloInventario\Linea\SLineaInventario;
use App\Utils\TransfersData\ModuloInventario\Talla\STallaInventario;
use App\Utils\Constantes\ModuloInventario\Departamentos\CDepartamentos;
use App\Utils\TransfersData\ModuloInventario\Departamentos\SDepartamentosInventario;

use Exception;
use Illuminate\Support\Facades\Cache;

class ServiceImportacionTns
{

    private $servicioOdbc, $serviceGruposContables, $serviceGrupoArticulos, $serviceBodega, $modulos;
    private $servicioHomologaciones, $serviceUnidades, $serviceTipoArticulos, $serviceMarcas;
    private $serviceArticulos, $sTallaInventario, $sLineaInventario, $sDepartamentosInventario, $sColorInventario;

    public function __construct()
    {


        $this->inyeccionDependencias();
    }

    private function inyeccionDependencias()
    {
        $this->servicioOdbc = new ServicesConexionesOdbc;
        $this->servicioHomologaciones = new ServicioHomologaciones;
        $this->serviceUnidades = new ServiceUnidades;
        $this->serviceTipoArticulos =  new ServiceTipoArticulos;
        $this->serviceMarcas =  new ServiceMarcas;
        $this->serviceGruposContables =  new ServiceGruposContables;
        $this->serviceGrupoArticulos =  new ServiceGrupoArticulos;
        $this->serviceBodega =  new ServiceBodega;
        $this->serviceArticulos =  new ServiceArticulos;
        $this->sTallaInventario =  new STallaInventario(new CTalla);
        $this->sLineaInventario =  new SLineaInventario(new CLinea);
        $this->sDepartamentosInventario =  new SDepartamentosInventario(new CDepartamentos);
        $this->sColorInventario =  new SColorInventario(new CColor);

        $this->modulos = new ModulesCode;
    }
    public function importacionPorCodigoModulo($idModulo)
    {


        $funcionesPorModulo = [
            $this->modulos::CODIGO_TODOS => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_MANTENIMIENTO => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_MINERA => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_TALENTO_HUMANO => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_NOMINA => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_INVENTARIO => function () {
                 $this->importacionGeneralModuloInventarioTNS();
            },
            $this->modulos::CODIGO_FACTURACION => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_TESORERIA => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_CARTERA => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_CONFIGURACION => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_INICIO => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_BASCULA => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_CONTABILIDAD => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_LOGISTICA => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_ACTIVOS_FIJOS => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_SUPER_ADMIN => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_ADMINISTRADOR => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_GESTION_CALIDAD => function () {
                   throw new Exception("Modulo en construccion");
            },
            $this->modulos::CODIGO_SEGURIDAD_SST => function () {
                   throw new Exception("Modulo en construccion");
            },
        ];

        if (!isset($funcionesPorModulo[$idModulo])) {
            throw new Exception("Opcion al modulo no encontrado");
        }

        return $funcionesPorModulo[$idModulo]();
    }

    public function importacionGeneralModuloInventarioTNS()
    {
        $dsn = Cache::get('dsn');
        Cache::forget('dsn');

        $migracion = [
            $this->serviceMarcas->importacionMarcasTns($dsn),
            $this->serviceBodega->importacionBodegasTns($dsn),
            $this->sLineaInventario->importacionLineaTns($dsn),
            $this->sTallaInventario->importacionTallaTns($dsn),
            $this->sColorInventario->importacionColorTns($dsn),
            $this->serviceUnidades->importacionUnidadesTns($dsn),
            $this->serviceTipoArticulos->importacionTiposArticulosTns($dsn),
            $this->serviceGrupoArticulos->importacionGruposArticulosTns($dsn),
            $this->serviceGruposContables->importacionGruposContablesTns($dsn),
            $this->sDepartamentosInventario->importacionDepartamentoInventariosTns($dsn),
            $this->serviceArticulos->importacionArticulosTns($dsn),

            // // // $this->servicioHomologaciones->importacionHomologacionTns($dsn),
        ];
        return $migracion;
    }
    public function importacionGeneralModuloInventarioSTON()
    {
    }
}