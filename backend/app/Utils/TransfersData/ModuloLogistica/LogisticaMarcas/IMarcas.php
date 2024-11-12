<?php

namespace App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas;

use App\Data\Dtos\Logistica\Marcas\Request\MarcasRequestCreateDTO;

interface IMarcas
{
    
    public function crearMarcas(MarcasRequestCreateDTO $marcasRequestCreateDTO);
    public function actualizarMarcas(MarcasRequestCreateDTO $marcasRequestCreateDTO);
    // public function eliminarMarcas($id);
    public function getMarcas($option = null);
    public function delete($id);
}
