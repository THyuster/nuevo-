<?php

namespace App\Utils\Repository;

use App\Utils\Constantes\DB\tablas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use function Psy\debug;

class RepositoryValidationBaseDatos
{
    private String $tablaConexionEmpresa, $tablaControlMigraciones, $tablaControlErpMigraciones;
    private bool $falloConexion;
    public function __construct()
    {
        $this->tablaConexionEmpresa = tablas::getTablaConexionEmpresa();
        $this->tablaControlMigraciones = tablas::getTablaControlMigraciones();
        $this->tablaControlErpMigraciones = tablas::getTablErpMigraciones();
        $this->falloConexion = true;
    }

    protected $option = 'LOCAL';
    public function checkDataBase()
    {
        switch ($this->option) {
            case "LOCAL":
                return $this->ejecutarMigracion();
            case "API":
                return "API";
            default:
                break;
        }
    }

    private function ejecutarMigracion()
    {

        $companies = DB::table($this->tablaConexionEmpresa)->get();
        DB::table($this->tablaControlErpMigraciones)->update(['conexion_empresa_no_realizada' => " "]);

        $migrations = DB::table($this->tablaControlErpMigraciones)->whereNotNull('script_db')->where('estado', '<>', 'OK')->get();
        foreach ($companies as $company) {
            $this->falloConexion = true;
            $connectionName = $company->nombre;
            if (!Schema::connection($connectionName)->hasTable($this->tablaControlMigraciones)) {
                $this->createTable($connectionName);
            }

            if (!$migrations->count()) {
                return "No hay migraciones pendientes";
            }
            $migracionId = 0;
            foreach ($migrations as $migration) {
                $migracionId = $migration->id;
                $alreadyApplied = DB::connection($connectionName)->table($this->tablaControlMigraciones)
                    ->where('ID_MIGRACION', $migration->id)
                    ->exists();

                if (!$alreadyApplied) {
                    $this->applyMigration($company, $migration);
                }
            }
            if ($this->falloConexion) {
                DB::table('erp_migraciones')->where('id', $migracionId)->update(['estado' => 'OK']);
            }
        }
        return $this->falloConexion ? "Migracion realizada con exito" : "Proceso terminado pero no se aplicaron en todas las empresas";
    }

    private function createTable($connectionName)
    {
        Schema::connection($connectionName)->create($this->tablaControlMigraciones, function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_MIGRACION');
            $table->timestamp('FECHA_APLICACION');
        });
    }

    private function applyMigration($connection, $migration)
    {

        $sql = $migration->script_db;

        $connectionName = $connection->nombre;
        $empresa = $connection->nombre_database;
        try {
            DB::connection($connectionName)->statement($sql);

            DB::connection($connectionName)->table($this->tablaControlMigraciones)->insert([
                'ID_MIGRACION' => $migration->id,
                'FECHA_APLICACION' => now()
            ]);
            DB::table('erp_migraciones')->where('id', $migration->id)->update(['estado' => 'OK']);
        } catch (\Throwable $th) {
            DB::table('erp_migraciones')->where('id', $migration->id)->update([
                'estado' => $th->getMessage(),
                'conexion_empresa_no_realizada' => DB::raw("CONCAT(conexion_empresa_no_realizada , ' - $empresa')"),
            ]);

            $this->falloConexion = false;
        }
    }
}
