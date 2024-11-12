<?php
namespace App\Utils\TransfersData\Sagrilaft\Empleados\Services;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Sagrilaft\Empleados\Repository\ISagrilaftColores;

class SagrilaftEmpleadoServiceColor implements ISagrilaftEmpleadoServiceColor
{

    protected ISagrilaftColores $sagrilaftColorRepository;
    public function __construct(ISagrilaftColores $iSagrilaftColores)
    {
        $this->sagrilaftColorRepository = $iSagrilaftColores;
    }
    public function createColor()
    {

        return $this->sagrilaftColorRepository->create(["descripcion" => "descripcion", "color" => "Color Gay"]);
    }

    public function getAllColors()
    {

        return $this->sagrilaftColorRepository->getAll();
        // $sqlColors = "SELECT * FROM sagrilaft_colores";
        // $response = $this->repositoryDynamicsCrud->sqlFunction($sqlColors);
        // return $response;
    }
    public function getByIdColors()
    {

        $this->sagrilaftColorRepository->getById(3);
        // $sqlColorsId = "SELECT * FROM `sagrilaft_colores` WHERE id";
        // $response = $this->repositoryDynamicsCrud->sqlFunction(sql: $sqlColorsId);
        // return $response;
    }
    public function UpdateColors()
    {
    }
    public function deleteColors()
    {
    }

}