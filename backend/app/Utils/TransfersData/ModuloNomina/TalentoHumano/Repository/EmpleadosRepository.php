<?php

namespace App\Utils\TransfersData\ModuloNomina\TalentoHumano\Repository;
use App\Data\Dtos\Empleados\Responses\Empleado\EmpleadoDTO;
use App\Models\NominaModels\TalentoHumano\Empleados\Empleado;
use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoAcademia;
use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoComplementarios;
use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoExperienciaLaboral;
use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoFamiliares;
use App\Models\NominaModels\TalentoHumano\Empleados\EmpleadoPersonales;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionAcademia;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionComplementarios;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionExperienciaLaborales;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionFamiliares;
use App\Models\NominaModels\TalentoHumano\Empleados\Relaciones\EmpleadoRelacionPersonales;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EmpleadosRepository implements IEmpleadosRepository
{
    public function createEmpleado(array $empleado, $connection = null)
    {
        try {
            $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
            return Empleado::on($connection)->create($empleado);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear el empleado: ' . $e->getMessage());
        }
    }
    public function createREmpleadoFamiliar(array $REmpleadoFamiliar, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            //code...
            $now = now(); // Obtén la fecha y hora actual
            $REmpleadoFamiliar = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $REmpleadoFamiliar);
            return EmpleadoRelacionFamiliares::on($connection)->insert($REmpleadoFamiliar);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la relación familiar del empleado: ' . $e->getMessage());
        }

    }
    public function createREmpleadoPersonal(array $REmpleadoPersonal, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            $now = now(); // Obtén la fecha y hora actual
            $REmpleadoPersonal = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $REmpleadoPersonal);
            return EmpleadoRelacionPersonales::on($connection)->insert($REmpleadoPersonal);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la relación personal del empleado: ' . $e->getMessage());
        }
    }
    public function createREmpleadoComplementario(array $REmpleadoComplementario, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            $now = now(); // Obtén la fecha y hora actual
            $REmpleadoComplementario = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $REmpleadoComplementario);
            return EmpleadoRelacionComplementarios::on($connection)->insert($REmpleadoComplementario);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la relación complementaria del empleado: ' . $e->getMessage());
        }
    }
    public function createREmpleadoExperienciaLaboral(array $REmpleadoExperienciaLaboral, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            $now = now(); // Obtén la fecha y hora actual
            $REmpleadoExperienciaLaboral = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $REmpleadoExperienciaLaboral);
            return EmpleadoRelacionExperienciaLaborales::on($connection)->insert($REmpleadoExperienciaLaboral);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la experiencia laboral del empleado: ' . $e->getMessage());
        }
    }
    public function createREmpleadoAcademia(array $REmpleadoAcademia, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            $now = now(); // Obtén la fecha y hora actual
            $REmpleadoAcademia = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $REmpleadoAcademia);
            return EmpleadoRelacionAcademia::on($connection)->insert($REmpleadoAcademia);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la relación académica del empleado: ' . $e->getMessage());
        }

    }
    public function createEmpleadoAcademia(array $empleadoAcademia, $connection = null)
    {

        try {
            $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
            $now = now(); // Obtén la fecha y hora actual
            $empleadoAcademia = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $empleadoAcademia);
            // return $empleadoAcademia;
            return EmpleadoAcademia::on($connection)->insert($empleadoAcademia);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la academia del empleado: ' . $e->getMessage());
        }

    }
    public function createEmpleadoComplementarios(array $empleadoComplementario, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            $now = now(); // Obtén la fecha y hora actual
            $empleadoComplementario = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $empleadoComplementario);
            return EmpleadoComplementarios::on($connection)->insert($empleadoComplementario);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear los complementarios del empleado: ' . $e->getMessage());
        }
    }
    public function createEmpleadoExperienciaLaboral(array $empleadoExperienciaLaboral, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            $now = now(); // Obtén la fecha y hora actual
            $empleadoExperienciaLaboral = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $empleadoExperienciaLaboral);
            return EmpleadoExperienciaLaboral::on($connection)->insert($empleadoExperienciaLaboral);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la experiencia laboral del empleado: ' . $e->getMessage());
        }
    }
    public function createEmpleadoFamiliares(array $empleadoFamiliares, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            $now = now(); // Obtén la fecha y hora actual
            $empleadoFamiliares = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $empleadoFamiliares);
            return EmpleadoFamiliares::on($connection)->insert($empleadoFamiliares);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear los familiares del empleado: ' . $e->getMessage());
        }


    }
    public function createEmpleadoPersonales(array $empleadoPersonal, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        $now = now(); // Obtén la fecha y hora actual
        try {
            $empleadoPersonal = array_map(function ($registro) use ($now) {
                if (is_array($registro)) {
                    $registro['created_at'] = $now;
                    $registro['updated_at'] = $now;
                }
                return $registro;
            }, $empleadoPersonal);
            return EmpleadoPersonales::on($connection)->insert($empleadoPersonal);
        } catch (\Exception $e) {
            throw new \Exception('Error al crear los datos personales del empleado: ' . $e->getMessage());
        }
    }

    public function existByIdEmpleado($id, $connection = null)
    {
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        try {
            return Empleado::on($connection)->where('empleado_id', $id)->exists();
        } catch (\Exception $e) {
            throw new \Exception('Error al verificar la existencia del empleado con ID ' . $id . ': ' . $e->getMessage());
        }
    }

    public function getEmpleadoByID($id, $connection = null)
    {
        // Determina la conexión a utilizar, o usa la conexión por defecto.
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();

        try {
            // Realiza la consulta para obtener el empleado con sus relaciones.
            $datos = Empleado::on($connection)->with([
                'academia',
                'experienciaLaboral',
                'familiares',
                'personales',
                'complementarios'
            ])->findOrFail($id); // Usa findOrFail para lanzar excepción si no se encuentra.

            return new EmpleadoDTO($datos); // Devuelve los detalles del empleado.
        } catch (\Exception $e) {
            throw new \Exception('Error al verificar la existencia del empleado con ID ' . $id . ': ' . $e->getMessage());
        }
    }


    public function getAllEmpleadoPagination(int $perPage = 15, $page = null, $connection = null)
    {
        // Determina la conexión a utilizar, o usa la conexión por defecto.
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();

        try {
            // $this->invalidateCache($connection);
            // Genera una clave única para el caché basado en los parámetros.
            // $cacheKey = "{$connection}.empleados.paginate.perPage.{$perPage}.page." . ($page ?? 1);

            // Intenta obtener los datos del caché.
            $datos = Empleado::on($connection)->with([
                'academia',
                'experienciaLaboral',
                'familiares',
                'personales',
                'complementarios',
                'validaciones'
            ])->paginate(perPage: $perPage, page: $page);


            // Transforma la colección paginada a un DTO.
            $datos->transform(function ($empleado) {
                return new EmpleadoDTO($empleado);
            });

            return $datos; // Devuelve la paginación de empleados transformada.
        } catch (\Exception $e) {
            throw new \Exception('Error al crear la paginación de los empleados: ' . $e->getMessage());
        }
    }

    public function getIdentificacionEmpleadoById($id, $connection = null): string
    {
        // Si no se proporciona una conexión, se obtiene la conexión por defecto.
        $connection = $connection ?: RepositoryDynamicsCrud::findConectionDB();
        $cacheKey = "{$connection}_empleado_identificacion.{$id}";

        try {
            // Se busca la identificación del empleado en la base de datos.
            $identificacion = Empleado::on($connection)->where('empleado_id', $id)->first(['identificacion']);

            // Si se encuentra la identificación, se retorna.
            if ($identificacion) {
                return $identificacion->identificacion;
            }
            // Si no se encuentra el empleado, se lanza una excepción.
            throw new \Exception("Empleado No Encontrado", Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            // Se lanza una nueva excepción con un mensaje de error más descriptivo.
            throw new \Exception('Error al buscar la identificacion del empleado: ' . $e->getMessage());
        }

    }

    protected function invalidateCache($connection)
    {
        $cacheKeys = [
            "{$connection}_empleados.paginate.perPage.*", // Invalida todos los caches relacionados con la paginación
            "{$connection}_empleado_identificacion.*"
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }

}
