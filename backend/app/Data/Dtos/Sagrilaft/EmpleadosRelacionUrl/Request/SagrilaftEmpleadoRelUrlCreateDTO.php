<?php

namespace App\Data\Dtos\Sagrilaft\EmpleadosRelacionUrl\Request;

/**
 * Clase Data Transfer Object (DTO) para la creación de relaciones de URL de empleados.
 *
 * Esta clase se utiliza para encapsular los datos necesarios para crear una nueva
 * relación entre un empleado y una URL en el sistema Sagrilaft. Proporciona
 * un método para convertir estos datos en un arreglo, adecuado para su uso en
 * operaciones de base de datos.
 */
class SagrilaftEmpleadoRelUrlCreateDTO
{
    public $empleadoId;  // ID del empleado
    public $sagrilaftUrlId;  // ID de la URL en Sagrilaft
    public $descripcion;  // Descripción de la relación
    public $color;  // Color asociado a la relación
    public $estado;  // Estado de la relación
    /**
     * @var array<\Illuminate\Http\UploadedFile>
     */
    public $resources = [];  // Estado de la relación

    /**
     * Constructor de la clase.
     *
     * @param object $SagrilaftRequestEmpleadoRelUrlCreateDTO Objeto que contiene los datos de entrada.
     */
    public function __construct($SagrilaftRequestEmpleadoRelUrlCreateDTO)
    {
        $this->empleadoId = $SagrilaftRequestEmpleadoRelUrlCreateDTO->empleadoId ?? null;
        $this->sagrilaftUrlId = $SagrilaftRequestEmpleadoRelUrlCreateDTO->sagrilaftUrlId ?? null;
        $this->descripcion = $SagrilaftRequestEmpleadoRelUrlCreateDTO->descripcion ?? null;
        $this->color = $SagrilaftRequestEmpleadoRelUrlCreateDTO->color ?? null;
        $this->estado = isset($SagrilaftRequestEmpleadoRelUrlCreateDTO->estado) ? (bool)$SagrilaftRequestEmpleadoRelUrlCreateDTO->estado : null;
        $this->resources = $SagrilaftRequestEmpleadoRelUrlCreateDTO->resources ?? [];
    }

    /**
     * Convierte los datos del DTO a un arreglo asociativo.
     *
     * Este método es útil para preparar los datos antes de ser utilizados en
     * operaciones de base de datos o para ser enviados a otros componentes del sistema.
     *
     * @return array Datos del DTO como arreglo asociativo.
     */
    public function toArray()
    {
        return [
            "empleado_id" => $this->empleadoId,
            "url_id" => $this->sagrilaftUrlId,
            "descripcion" => $this->descripcion,
            "color" => $this->color,
            "estado" => $this->estado,
        ];
    }
}
