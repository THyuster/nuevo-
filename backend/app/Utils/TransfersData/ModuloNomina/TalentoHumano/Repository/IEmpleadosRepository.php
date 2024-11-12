<?php

namespace App\Utils\TransfersData\ModuloNomina\TalentoHumano\Repository;
/**
 * Interfaz para la gestión de registros de empleados en la base de datos.
 */
interface IEmpleadosRepository
{
  /**
   * Crea un nuevo registro de empleado en la base de datos.
   *
   * Este método intentará crear un registro de `Empleado` utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $empleado Un array asociativo que contiene los datos del empleado a ser guardado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
   *         Retorna la instancia del modelo de empleado creado.
   */
  public function createEmpleado(array $empleado, $connection = null);
  /**
   * Crea nuevos registros de relaciones familiares del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de relaciones familiares del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $REmpleadoFamiliar Un array de arrays, donde cada array contiene los datos de un familiar del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createREmpleadoFamiliar(array $REmpleadoFamiliar, $connection = null);

  /**
   * Crea nuevos registros de relaciones personales del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de relaciones personales del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $REmpleadoPersonal Un array de arrays, donde cada array contiene los datos de una relación personal del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createREmpleadoPersonal(array $REmpleadoPersonal, $connection = null);
  /**
   * Crea nuevos registros de información complementaria del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de información complementaria del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $REmpleadoComplementario Un array de arrays, donde cada array contiene los datos de una relación complementaria del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createREmpleadoComplementario(array $REmpleadoComplementario, $connection = null);

  /**
   * Crea nuevos registros de experiencia laboral del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de experiencia laboral del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $REmpleadoExperienciaLaboral Un array de arrays, donde cada array contiene los datos de la experiencia laboral del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createREmpleadoExperienciaLaboral(array $REmpleadoExperienciaLaboral, $connection = null);
  /**
   * Crea nuevos registros de formación académica del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de formación académica del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $REmpleadoAcademia Un array de arrays, donde cada array contiene los datos de la formación académica del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createREmpleadoAcademia(array $REmpleadoAcademia, $connection = null);
  /**
   * Crea nuevos registros de formación académica del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de formación académica del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $empleadoAcademia Un array de arrays, donde cada array contiene los datos de la formación académica del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createEmpleadoAcademia(array $empleadoAcademia, $connection = null);
  /**
   * Crea nuevos registros de información complementaria del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de información complementaria del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $empleadoComplementario Un array de arrays, donde cada array contiene los datos de la información complementaria del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createEmpleadoComplementarios(array $empleadoComplementario, $connection = null);
  /**
   * Crea nuevos registros de experiencia laboral del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de experiencia laboral del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $empleadoExperienciaLaboral Un array de arrays, donde cada array contiene los datos de la experiencia laboral del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createEmpleadoExperienciaLaboral(array $empleadoExperienciaLaboral, $connection = null);
  /**
   * Crea nuevos registros de relaciones familiares del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de relaciones familiares del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $empleadoFamiliares Un array de arrays, donde cada array contiene los datos de un familiar del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createEmpleadoFamiliares(array $empleadoFamiliares, $connection = null);
  /**
   * Crea nuevos registros de relaciones personales del empleado en la base de datos.
   *
   * Este método inserta múltiples registros de relaciones personales del empleado utilizando el array de datos proporcionado.
   * Permite especificar una conexión a la base de datos, usando una conexión predeterminada si no se proporciona ninguna.
   *
   * @param array $empleadoPersonal Un array de arrays, donde cada array contiene los datos de una relación personal del empleado.
   * @param mixed $connection (Opcional) La conexión a la base de datos a usar. Si no se especifica, se utilizará la conexión predeterminada.
   * @return bool Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
   */
  public function createEmpleadoPersonales(array $empleadoPersonal, $connection = null);
  /**
   * Verifica si un empleado existe en la base de datos a partir de su ID.
   *
   * Este método utiliza Eloquent para consultar la tabla de empleados y determinar
   * si existe un registro con el ID proporcionado. Si ocurre un error durante la
   * consulta, se lanzará una excepción con un mensaje descriptivo.
   *
   * @param int $id El ID del empleado a verificar.
   * @param string|null $connection La conexión a la base de datos a utilizar.
   *                                Si no se proporciona, se utiliza la conexión por defecto.
   * 
   * @return bool Devuelve true si el empleado existe, de lo contrario false.
   *
   * @throws \Exception Si ocurre un error durante la consulta.
   */
  public function existByIdEmpleado($id, $connection = null);
  /**
   * Obtiene los detalles de un empleado por su ID.
   *
   * @param mixed $id El ID del empleado a buscar.
   * @param mixed|null $connection La conexión a la base de datos (opcional).
   * @throws \Exception Si ocurre un error al buscar el empleado.
   * @return \App\Data\Dtos\Empleados\Responses\Empleado\EmpleadoDTO Un objeto que contiene los detalles del empleado.
   */
  public function getEmpleadoByID($id, $connection = null);
  /**
   * Obtiene una paginación de todos los empleados.
   *
   * @param mixed|null $connection La conexión a la base de datos (opcional).
   * @throws \Exception Si ocurre un error al crear la paginación.
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator La paginación de empleados.
   */
  public function getAllEmpleadoPagination(int $perPage = 15, $page = null, $connection = null);
  /**
   * Obtiene la identificación de un empleado a partir de su ID.
   *
   * @param int $id El ID del empleado.
   * @param string|null $connection La conexión a la base de datos (opcional).
   * @return string La identificación del empleado.
   * @throws \Exception Si no se encuentra al empleado o si ocurre un error en la consulta.
   */
  public function getIdentificacionEmpleadoById($id, $connection = null): string;

}
