<?php

namespace App\Providers;

//MODULO DE MANTENIMIENTO
use App\Utils\TransfersData\ModuloActivosFijos\EquiposServices;
use App\Utils\TransfersData\ModuloActivosFijos\GruposEquiposServices;
use App\Utils\TransfersData\ModuloActivosFijos\IEquiposServices;
use App\Utils\TransfersData\ModuloActivosFijos\IGruposEquiposServices;
use App\Utils\TransfersData\ModuloActivosFijos\Repositories\Equipos\EquiposRepository;
use App\Utils\TransfersData\ModuloActivosFijos\Repositories\Equipos\IEquiposRepository;
use App\Utils\TransfersData\ModuloActivosFijos\Repositories\GruposEquipos\GruposEquiposRepository;
use App\Utils\TransfersData\ModuloActivosFijos\Repositories\GruposEquipos\IGruposEquiposRepository;
use App\Utils\TransfersData\moduloContabilidad\PlanUnicoCuentas\IServicioCuentaAuxiliares;
use App\Utils\TransfersData\moduloContabilidad\PlanUnicoCuentas\ServicioCuentaAuxiliares;
use App\Utils\TransfersData\moduloContabilidad\Repositories\TiposIdentificaciones\ITipoIdentificacionRepository;
use App\Utils\TransfersData\moduloContabilidad\Repositories\TiposIdentificaciones\TipoIdentificacionRepository;
use App\Utils\TransfersData\ModuloInventario\Repositories\Unidades\IUnidadesRepository;
use App\Utils\TransfersData\ModuloInventario\Repositories\Unidades\UnidadesRepository;
use App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas\Repository\IMarcasRepository;
use App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas\Repository\MarcasRepository;
use App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\Repository\IRepositoryVehiculo;
use App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\Repository\RepositoryVehiculo;
use App\Utils\TransfersData\ModuloMantenimiento\Combustible\IMantenimientoCombustible;
use App\Utils\TransfersData\ModuloMantenimiento\Combustible\Repository\CombustibleRepository;
use App\Utils\TransfersData\ModuloMantenimiento\Combustible\Repository\ICombustibleRepository;
use App\Utils\TransfersData\ModuloMantenimiento\Combustible\SMantenimientoCombustible;
use App\Utils\TransfersData\ModuloMantenimiento\Estaciones\IEstaciones;
use App\Utils\TransfersData\ModuloMantenimiento\Estaciones\SEstaciones;
use App\Utils\TransfersData\ModuloMantenimiento\Horometros\IMantenimientoHorometros;
use App\Utils\TransfersData\ModuloMantenimiento\Horometros\SMantenimientoHorometros;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesActas;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesEntregaDirectas;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesItemsDiagnostico;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesSolicitudes;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesTecnicos;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesTiposOrdenes;
use App\Utils\TransfersData\ModuloMantenimiento\IServicesTiposSolicitudes;
use App\Utils\TransfersData\ModuloMantenimiento\Kilometros\IMantenimientoKilometros;
use App\Utils\TransfersData\ModuloMantenimiento\Kilometros\SMantenimientoKilometros;
use App\Utils\TransfersData\ModuloMantenimiento\Mediciones\IMediciones;
use App\Utils\TransfersData\ModuloMantenimiento\Mediciones\SMediciones;
use App\Utils\TransfersData\ModuloMantenimiento\Ordenes\Repository\IOrdenRepository;
use App\Utils\TransfersData\ModuloMantenimiento\Ordenes\Repository\OrdenRepository;
use App\Utils\TransfersData\ModuloMantenimiento\Repositories\Solicitudes\ISolicitudRepository;
use App\Utils\TransfersData\ModuloMantenimiento\Repositories\Solicitudes\SolicitudRepository;
use App\Utils\TransfersData\ModuloMantenimiento\ServicesActas;
use App\Utils\TransfersData\ModuloMantenimiento\Ordenes\IServicesOrdenes;
use App\Utils\TransfersData\ModuloMantenimiento\Ordenes\ServicesOrdenes;
use App\Utils\TransfersData\ModuloMantenimiento\ServicesEntregaDirecta;
use App\Utils\TransfersData\ModuloMantenimiento\ServicesItemsDiagnostico;
use App\Utils\TransfersData\ModuloMantenimiento\ServicesSolicitudes;
use App\Utils\TransfersData\ModuloMantenimiento\ServicesTecnicos;
use App\Utils\TransfersData\ModuloMantenimiento\ServicesTiposOrdenes;
use App\Utils\TransfersData\ModuloMantenimiento\ServicesTiposSolicitudes;

//MODULO DE LOGISTICA
use App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\IServicesVehiculos;
use App\Utils\TransfersData\ModuloLogistica\IServiceTrailers;
use App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas\IMarcas;
use App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas\SMarcas;
use App\Utils\TransfersData\ModuloLogistica\ServicesTrailers;
use App\Utils\TransfersData\ModuloLogistica\LogisticaVehiculos\ServicesVehiculos;

//MODULO ACTIVO FIJO
// use App\Utils\TransfersData\ModuloActivosFijos\ActivosFijosEquipos;
// use App\Utils\TransfersData\ModuloActivosFijos\IActivosFijosEquipos;

//MODULO DE INVENTARIO
use App\Utils\TransfersData\ModuloInventario\Color\IColorInventario;
use App\Utils\TransfersData\ModuloInventario\Color\SColorInventario;
use App\Utils\TransfersData\ModuloInventario\Departamentos\IDepartamentosInventario;
use App\Utils\TransfersData\ModuloInventario\Departamentos\SDepartamentosInventario;
use App\Utils\TransfersData\ModuloInventario\IServicioHomologaciones;
use App\Utils\TransfersData\ModuloInventario\Linea\ILineaInventario;
use App\Utils\TransfersData\ModuloInventario\Linea\SLineaInventario;
use App\Utils\TransfersData\ModuloInventario\ServicioHomologaciones;
use App\Utils\TransfersData\ModuloInventario\Talla\ITallaInventario;
use App\Utils\TransfersData\ModuloInventario\Talla\STallaInventario;

//MODULO DE CONTABILIDAD
use App\Utils\TransfersData\moduloContabilidad\Areas\IContabilidadAreas;
use App\Utils\TransfersData\moduloContabilidad\Areas\SContabilidadAreas;
use App\Utils\TransfersData\moduloContabilidad\Bancos\IContabilidadBancos;
use App\Utils\TransfersData\moduloContabilidad\Bancos\SContabilidadBancos;
use App\Utils\TransfersData\moduloContabilidad\Centros\IContabilidadCentros;
use App\Utils\TransfersData\moduloContabilidad\Centros\SContabilidadCentros;


//MODULO DE NOMINA
use App\Utils\TransfersData\ModuloNomina\Blacklist\IServiceNominaBlacklist;
use App\Utils\TransfersData\ModuloNomina\Blacklist\Repository\IRepositoryBlacklist;
use App\Utils\TransfersData\ModuloNomina\Blacklist\Repository\RepositoryBlacklist;
use App\Utils\TransfersData\ModuloNomina\Blacklist\ServicesNominaBlacklist;
use App\Utils\TransfersData\ModuloNomina\IServiceCargosNomina;
use App\Utils\TransfersData\ModuloNomina\IServiceEntidadesNomina;
use App\Utils\TransfersData\ModuloNomina\IServiceNominaConvocatorias;
use App\Utils\TransfersData\ModuloNomina\IServiceNominaSolicitudEmpleo;
use App\Utils\TransfersData\ModuloNomina\IServicesCentrosTrabajo;
use App\Utils\TransfersData\ModuloNomina\IServicesUserCentros;
use App\Utils\TransfersData\ModuloNomina\Postulaciones\Repository\Postulantes\IRepositoryPostulacion;
use App\Utils\TransfersData\ModuloNomina\Postulaciones\Repository\Postulantes\RepositoryPostulaciones;
use App\Utils\TransfersData\ModuloNomina\Postulaciones\Services\IServicePostulaciones;
use App\Utils\TransfersData\ModuloNomina\Postulaciones\Services\ServicesPostulaciones;
use App\Utils\TransfersData\ModuloNomina\Repositories\NominaCentroTrabajos\INominaCentroTrabajoRepository;
use App\Utils\TransfersData\ModuloNomina\Repositories\NominaCentroTrabajos\NominaCentroTrabajoRepository;
use App\Utils\TransfersData\ModuloNomina\Repositories\NominaConvocatoria\INominaConvocatoriaRepository;
use App\Utils\TransfersData\ModuloNomina\Repositories\NominaConvocatoria\NominaConvocatoriaRepository;
use App\Utils\TransfersData\ModuloNomina\ServiceCargosNomina;
use App\Utils\TransfersData\ModuloNomina\ServiceNominaConvocatorias;
use App\Utils\TransfersData\ModuloNomina\ServicesCentrosTrabajo;
use App\Utils\TransfersData\ModuloNomina\ServicesEntidad;
use App\Utils\TransfersData\ModuloNomina\ServicesNominaSolicitudEmpleo;
use App\Utils\TransfersData\ModuloNomina\ServicesUserCentros;

//MODULO SEGURIDAD Y SALUD EN EL TRABAJO
use App\Utils\TransfersData\ModuloNomina\TalentoHumano\Empleados\EmpleadoServices;
use App\Utils\TransfersData\ModuloNomina\TalentoHumano\Empleados\IEmpleadoServices;
use App\Utils\TransfersData\ModuloNomina\TalentoHumano\Repository\EmpleadosRepository;
use App\Utils\TransfersData\ModuloNomina\TalentoHumano\Repository\IEmpleadosRepository;
use App\Utils\TransfersData\ModuloSeguridadSst\PartesCuerpo\ISeguridadSstPartesCuerpo;
use App\Utils\TransfersData\ModuloSeguridadSst\PartesCuerpo\SSeguridadSstPartesCuerpo;

//ROLES Y CONFIGURACION
use App\Utils\TransfersData\Erp\IServicesConexionesOdbc;
use App\Utils\TransfersData\Erp\Roles\Interfaces\IRoles;
use App\Utils\TransfersData\Erp\Roles\Interfaces\IRolesPermisos;
use App\Utils\TransfersData\Erp\Roles\Services\ServicesPermisosRoles;
use App\Utils\TransfersData\Erp\Roles\Services\ServicesRoles;
use App\Utils\TransfersData\Erp\ServicesConexionesOdbc;
use App\Utils\TransfersData\modulo_administradores\gestionRoles\GestionRoles;
use App\Utils\TransfersData\modulo_administradores\gestionRoles\IGestionRoles;
use App\Utils\TransfersData\ModuloConfiguracion\IvariablesGlobales;
use App\Utils\TransfersData\ModuloConfiguracion\ServicesvariablesGlobales;
use App\Utils\TransfersData\ModuloGestionCompra\IServicioOrdenes;
use App\Utils\TransfersData\ModuloGestionCompra\IServicioPresupuesto;
use App\Utils\TransfersData\ModuloGestionCompra\IServicioRequisiciones;
use App\Utils\TransfersData\ModuloGestionCompra\ServicioOrdenes;
use App\Utils\TransfersData\ModuloGestionCompra\ServicioPresupuesto;
use App\Utils\TransfersData\ModuloGestionCompra\ServicioRequisiciones;
use App\Utils\TransfersData\ModuloSuperAdmin\ISuAdminService;
use App\Utils\TransfersData\ModuloSuperAdmin\SuAdminService;
use App\Utils\TransfersData\ModuloTesoreria\IServicioConceptos;
use App\Utils\TransfersData\ModuloTesoreria\IServicioGruposConceptos;
use App\Utils\TransfersData\ModuloTesoreria\ServicioConceptos;
use App\Utils\TransfersData\ModuloTesoreria\ServicioGruposConceptos;
use App\Utils\TransfersData\ProduccionMinera\IServicioBodega;
use App\Utils\TransfersData\ProduccionMinera\IServicioPatios;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmCalidades;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmCodigos;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmContabilizacion;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmCupos;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmGranulometrias;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmProductos;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmTarifaRegalia;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmTechosCalidades;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmTechosCodigos;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmTipoRegalia;
use App\Utils\TransfersData\ProduccionMinera\IServicioPmZonas;
use App\Utils\TransfersData\ProduccionMinera\IServicioTarifasTraslados;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoCodigo;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoMovimientos;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoPatios;
use App\Utils\TransfersData\ProduccionMinera\IServicioTipoUso;
use App\Utils\TransfersData\ProduccionMinera\ServicioBodega;
use App\Utils\TransfersData\ProduccionMinera\ServicioPatio;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmCalidades;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmCodigos;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmContabilizacion;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmCupos;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmGranulometrias;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmProductos;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmTarifaRegalia;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmTechosCalidad;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmTechosCodigo;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmTipoRegalia;
use App\Utils\TransfersData\ProduccionMinera\ServicioPmZonas;
use App\Utils\TransfersData\ProduccionMinera\ServicioTarifaTraslado;
use App\Utils\TransfersData\ProduccionMinera\ServicioTipoUso;
use App\Utils\TransfersData\ProduccionMinera\TiposCodigos;
use App\Utils\TransfersData\ProduccionMinera\TiposMovimientos;
use App\Utils\TransfersData\ProduccionMinera\TiposPatios;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\ISagrilaftColores;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\ISagrilaftEmpleadoRecursosRepository;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\ISagrilaftEmpleadoUrlRelacionRepository;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\SagrilaftColores;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\SagrilaftEmpleadoRecursosRepository;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\SagrilaftEmpleadoUrlRelacionRepository;
use App\Utils\TransfersData\Sagrilaft\Empleados\Services\ISagrilaftEmpleadoService;
use App\Utils\TransfersData\Sagrilaft\Empleados\Services\ISagrilaftEmpleadoServiceColor;
use App\Utils\TransfersData\Sagrilaft\Empleados\Services\SagrilaftEmpleadoService;
use App\Utils\TransfersData\Sagrilaft\Empleados\Services\SagrilaftEmpleadoServiceColor;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\IRepositoryUrl;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\IRepositoryUrlRelacion;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\RepositoryUrl;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\RepositoryUrlRelacion;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\RelacionUrlTipoValidacionRelacion\ISagrilaftUrlTipoValidacionRelacionRepository;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\RelacionUrlTipoValidacionRelacion\SagrilaftUrlTipoValidacionRelacionRepository;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\TipoValidaciones\ISagrilaftTipoValidacionRepository;
use App\Utils\TransfersData\Sagrilaft\Urls\Repositories\Validaciones\TipoValidaciones\SagrilaftTipoValidacionRepository;
use App\Utils\TransfersData\Sagrilaft\Urls\Services\Urls\IServiceSagrilaftUrl;
use App\Utils\TransfersData\Sagrilaft\Urls\Services\Urls\ServiceSagrilaftUrl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

        public function register(): void
        {
                $this->app->bind(IServiceTrailers::class, ServicesTrailers::class);
                $this->app->bind(IServicesVehiculos::class, ServicesVehiculos::class);
                $this->app->bind(IServicesTiposSolicitudes::class, ServicesTiposSolicitudes::class);
                $this->app->bind(IServicesCentrosTrabajo::class, ServicesCentrosTrabajo::class);
                $this->app->bind(IServicesSolicitudes::class, ServicesSolicitudes::class);
                $this->app->bind(IServicesTiposOrdenes::class, ServicesTiposOrdenes::class);
                $this->app->bind(IServicesTecnicos::class, ServicesTecnicos::class);
                $this->app->bind(ISuAdminService::class, SuAdminService::class);
                $this->app->bind(IGestionRoles::class, GestionRoles::class);
                $this->app->bind(IServiceCargosNomina::class, ServiceCargosNomina::class);
                $this->app->bind(IContabilidadCentros::class, SContabilidadCentros::class);
                $this->app->bind(IDepartamentosInventario::class, SDepartamentosInventario::class);
                $this->app->bind(ILineaInventario::class, SLineaInventario::class);
                $this->app->bind(ITallaInventario::class, STallaInventario::class);
                $this->app->bind(IColorInventario::class, SColorInventario::class);
                $this->app->bind(IContabilidadAreas::class, SContabilidadAreas::class);
                $this->app->bind(IMantenimientoCombustible::class, SMantenimientoCombustible::class);
                $this->app->bind(IMantenimientoHorometros::class, SMantenimientoHorometros::class);
                $this->app->bind(IMantenimientoKilometros::class, SMantenimientoKilometros::class);
                $this->app->bind(IMediciones::class, SMediciones::class);
                $this->app->bind(IEstaciones::class, SEstaciones::class);
                $this->app->bind(IMarcas::class, SMarcas::class);
                $this->app->bind(IEquiposServices::class, EquiposServices::class);
                $this->app->bind(IServiceEntidadesNomina::class, ServicesEntidad::class);
                $this->app->bind(IServicesItemsDiagnostico::class, ServicesItemsDiagnostico::class);
                $this->app->bind(IServicesOrdenes::class, ServicesOrdenes::class);
                $this->app->bind(IServicesActas::class, ServicesActas::class);
                $this->app->bind(IServicesUserCentros::class, ServicesUserCentros::class);
                $this->app->bind(IContabilidadBancos::class, SContabilidadBancos::class);
                $this->app->bind(IServicioHomologaciones::class, ServicioHomologaciones::class);
                $this->app->bind(ISeguridadSstPartesCuerpo::class, SSeguridadSstPartesCuerpo::class);
                $this->app->bind(IServicesConexionesOdbc::class, ServicesConexionesOdbc::class);
                $this->app->bind(IRoles::class, ServicesRoles::class);
                $this->app->bind(IRolesPermisos::class, ServicesPermisosRoles::class);
                $this->app->bind(IServicesEntregaDirectas::class, ServicesEntregaDirecta::class);
                $this->app->bind(IvariablesGlobales::class, ServicesvariablesGlobales::class);
                $this->app->bind(IServiceNominaSolicitudEmpleo::class, ServicesNominaSolicitudEmpleo::class);
                $this->app->bind(IServiceNominaConvocatorias::class, ServiceNominaConvocatorias::class);
                $this->app->bind(IServiceNominaBlacklist::class, ServicesNominaBlacklist::class);
                $this->app->bind(IServicioTipoCodigo::class, TiposCodigos::class);
                $this->app->bind(IServicioTipoPatios::class, TiposPatios::class);
                $this->app->bind(IServicioTipoMovimientos::class, TiposMovimientos::class);
                $this->app->bind(IServicioPatios::class, ServicioPatio::class);
                $this->app->bind(IServicioBodega::class, ServicioBodega::class);
                $this->app->bind(IServicioTipoUso::class, ServicioTipoUso::class);
                $this->app->bind(IServicioTarifasTraslados::class, ServicioTarifaTraslado::class);
                $this->app->bind(IServicioPmProductos::class, ServicioPmProductos::class);
                $this->app->bind(IServicioPmCalidades::class, ServicioPmCalidades::class);
                $this->app->bind(IServicioPmTipoRegalia::class, ServicioPmTipoRegalia::class);
                $this->app->bind(IServicioPmTarifaRegalia::class, ServicioPmTarifaRegalia::class);
                $this->app->bind(IServicioPmGranulometrias::class, ServicioPmGranulometrias::class);
                $this->app->bind(IServicioPmTechosCalidades::class, ServicioPmTechosCalidad::class);
                $this->app->bind(IServicioPmContabilizacion::class, ServicioPmContabilizacion::class);

                $this->app->bind(IServicePostulaciones::class, ServicesPostulaciones::class);
                $this->app->bind(IRepositoryPostulacion::class, RepositoryPostulaciones::class);
                $this->app->bind(IRepositoryBlacklist::class, RepositoryBlacklist::class);

                $this->app->bind(IServicioPmZonas::class, ServicioPmZonas::class);
                $this->app->bind(IServicioPmCodigos::class, ServicioPmCodigos::class);
                $this->app->bind(IServicioPmCupos::class, ServicioPmCupos::class);
                $this->app->bind(IServicioPmTechosCodigos::class, ServicioPmTechosCodigo::class);
                $this->app->bind(IRepositoryVehiculo::class, RepositoryVehiculo::class);



                $this->app->bind(IServiceNominaSolicitudEmpleo::class, ServicesNominaSolicitudEmpleo::class);
                $this->app->bind(IServiceNominaConvocatorias::class, ServiceNominaConvocatorias::class);

                $this->app->bind(IEquiposRepository::class, EquiposRepository::class);
                $this->app->bind(IGruposEquiposRepository::class, GruposEquiposRepository::class);
                $this->app->bind(IMarcasRepository::class, MarcasRepository::class);
                $this->app->bind(INominaCentroTrabajoRepository::class, NominaCentroTrabajoRepository::class);
                $this->app->bind(IUnidadesRepository::class, UnidadesRepository::class);
                $this->app->bind(ICombustibleRepository::class, CombustibleRepository::class);
                $this->app->bind(IGruposEquiposServices::class, GruposEquiposServices::class);

                $this->app->bind(IEmpleadosRepository::class, EmpleadosRepository::class);
                $this->app->bind(ITipoIdentificacionRepository::class, TipoIdentificacionRepository::class);
                $this->app->bind(INominaConvocatoriaRepository::class, NominaConvocatoriaRepository::class);
                $this->app->bind(ISolicitudRepository::class, SolicitudRepository::class);
                $this->app->bind(IServicioPresupuesto::class, ServicioPresupuesto::class);
                $this->app->bind(IServicioRequisiciones::class, ServicioRequisiciones::class);
                $this->app->bind(IServicioOrdenes::class, ServicioOrdenes::class);
                $this->app->bind(IServicioGruposConceptos::class, ServicioGruposConceptos::class);
                $this->app->bind(IServicioConceptos::class, ServicioConceptos::class);
                $this->app->bind(IServicioCuentaAuxiliares::class, ServicioCuentaAuxiliares::class);



            $this->app->bind(IOrdenRepository::class, OrdenRepository::class);

        $this->app->bind(ISagrilaftUrlTipoValidacionRelacionRepository::class, SagrilaftUrlTipoValidacionRelacionRepository::class);
        $this->app->bind(ISagrilaftTipoValidacionRepository::class, SagrilaftTipoValidacionRepository::class);
        $this->app->bind(IRepositoryUrl::class, RepositoryUrl::class);
        $this->app->bind(IServiceSagrilaftUrl::class, ServiceSagrilaftUrl::class);
        $this->app->bind(IRepositoryUrlRelacion::class, RepositoryUrlRelacion::class);
        $this->app->bind(ISagrilaftEmpleadoUrlRelacionRepository::class, SagrilaftEmpleadoUrlRelacionRepository::class);
        $this->app->bind(ISagrilaftEmpleadoRecursosRepository::class, SagrilaftEmpleadoRecursosRepository::class);
        $this->app->bind(ISagrilaftEmpleadoService::class, SagrilaftEmpleadoService::class);
        $this->app->bind(IEmpleadoServices::class, EmpleadoServices::class);
        $this->app->bind(ISagrilaftEmpleadoServiceColor::class, SagrilaftEmpleadoServiceColor::class);

        $this->app->bind(ISagrilaftColores::class, SagrilaftColores::class);
        // $this->app->bind(abstract: IRepositoryUrlRelacion::class, RepositoryUrlRelacion::class);
    }

        public function boot(): void
        {
        }
}