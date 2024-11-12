<?php
namespace App\Utils\TransfersData\ModuloNomina\Postulaciones\Repository\Postulantes;

use App\Data\Dtos\Convocatorias\Postulantes\Responses\PostulanteResponseDTO;
use App\Models\NominaModels\Convocatorias\ConvocatoriaRelacionPostulante;
use App\Models\NominaModels\NominaConvocatorias;
use App\Models\NominaModels\Postulantes\ExperienciaLaboral;
use App\Models\NominaModels\Postulantes\PostulacionFamiliares;
use App\Models\NominaModels\Postulantes\PostulacionPersonales;
use App\Models\NominaModels\Postulantes\PostulanteAcademia;
use App\Models\NominaModels\Postulantes\PostulanteComplementarios;
use App\Models\NominaModels\Postulantes\Postulantes;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionesRelacionComplementarios;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionAcademia;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionesExperienciaLaborales;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionFamiliares;
use App\Models\NominaModels\Postulantes\Relaciones\PostulacionRelacionPersonales;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Support\Carbon;

class RepositoryPostulaciones implements IRepositoryPostulacion
{

    public function create(array $postulacion, $connection = null)
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        return Postulantes::on($connection)->create($postulacion);
    }

    public function userInConvocatoria(string $identificacion, string $nominaConvocatoriaId, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        return Postulantes::on($connection)->where('identificacion', $identificacion)
            ->where('nomina_convocatoria_id', $nominaConvocatoriaId)->exists();
    }

    public function closedCall(string $convocatoriaId, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        return NominaConvocatorias::on($connection)->where('nomina_convocatoria_id', $convocatoriaId)
            ->where('fecha_cierre', '<=', Carbon::now())->exists();
    }

    public function createPostulacionFamiliares(array $datos, $connection = null): bool
    {

        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulacionFamiliares::on($connection)->insert($datos);
    }

    public function createPostulacionPersonales(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulacionPersonales::on($connection)->insert($datos);
    }

    public function createPostulanteComplementarios(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulanteComplementarios::on($connection)->insert($datos);
    }

    public function createPostulanteAcademia(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulanteAcademia::on($connection)->insert($datos);
    }

    public function createExperienciaLaboral(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return ExperienciaLaboral::on($connection)->insert($datos);
    }

    public function createPostulacionRelacionAcademia(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulacionRelacionAcademia::on($connection)->insert($datos);
    }

    public function createPostulacionesRelacionComplementarios(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulacionesRelacionComplementarios::on($connection)->insert($datos);
    }

    public function createPostulacionRelacionFamiliares(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulacionRelacionFamiliares::on($connection)->insert($datos);
    }

    public function createPostulacionRelacionPersonales(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulacionRelacionPersonales::on($connection)->insert($datos);
    }

    public function createPostulacionRelacionesExperienciaLaborales(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return PostulacionRelacionesExperienciaLaborales::on($connection)->insert($datos);
    }

    public function createConvocatoriaRelacionPostulante(array $datos, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        $datos = array_map(function ($registro) use ($now) {
            if (is_array($registro)) {
                $registro['created_at'] = $now;
                $registro['updated_at'] = $now;
            }
            return $registro;
        }, $datos);
        return ConvocatoriaRelacionPostulante::on($connection)->insert($datos);
    }

    public function statuChangePostulante(string $convocatoriaRelacionPostulanteId, bool $estado, $connection = null): bool
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        return ConvocatoriaRelacionPostulante::on($connection)->where('id', $convocatoriaRelacionPostulanteId)
            ->update(["estado" => $estado]);
    }

    public function getConvocatoriaRelacionPostulanteById(string $convocatoriaRelacionPostulanteId, $connection = null)
    {
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        return ConvocatoriaRelacionPostulante::on($connection)->find($convocatoriaRelacionPostulanteId);
    }
    public function getPostulante(string $postulanteId, $connection = null): PostulanteResponseDTO
    {
        // return 
        $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
        return new PostulanteResponseDTO(Postulantes::on($connection)->find($postulanteId));
    }

    // public function insertPostulanteInBlacklist(array $data, $connection = null)
    // {
    //     // return 
    //     $connection = ($connection != null) ? $connection : RepositoryDynamicsCrud::findConectionDB();
    //     return NominaBlacklist::on($connection)->create($data);
    // }

    public function getPostulantesByIdConvocatoriaPaginate(string $idConvocatoria, $estadoPostulante = null, int $perPage = 15, $connection = null)
    {
        // Determina la conexión a la base de datos
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();

        if ($estadoPostulante === "all") {
            return ConvocatoriaRelacionPostulante::on($connection)
                ->where('convocatorias_id', $idConvocatoria)
                ->with([
                    'convocatoria',
                    'postulante',
                    'academia',
                    'experiencia_laboral',
                    'familiares',
                    'personales'
                ])
                ->paginate(); 
        }else{
            return ConvocatoriaRelacionPostulante::on($connection)
                ->where('convocatorias_id', $idConvocatoria)
                ->where('estado', $estadoPostulante)
                ->with([
                    'convocatoria',
                    'postulante',
                    'academia',
                    'experiencia_laboral',
                    'familiares',
                    'personales'
                ])
                ->paginate(); // Pasa el tamaño de página a paginate()
        }
        // Obtiene los resultados paginados
    }

    public function getPostulanteByID(string $idPostulante, $connection = null)
    {
        // Determina la conexión a la base de datos
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();

        // Obtiene los resultados paginados
        return Postulantes::on($connection)
            ->where('nomina_convocatoria_postulante_id', $idPostulante)
            ->with([
                'academia',
                'experiencia_laboral',
                'familiares',
                'personales',
                'tipo_identificaciones',
                'municipios',
                'departamentos',
            ])->get(); // Pasa el tamaño de página a paginate()
    }
}
