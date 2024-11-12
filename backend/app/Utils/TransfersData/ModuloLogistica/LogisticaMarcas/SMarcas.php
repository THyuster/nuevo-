<?php

namespace App\Utils\TransfersData\ModuloLogistica\LogisticaMarcas;

use App\Data\Dtos\Logistica\Marcas\Request\MarcasRequestCreateDTO;
use App\Data\Dtos\Logistica\Marcas\Responses\MarcasResponseDTO;
use App\Models\modulo_logistica\logistica_marcas;
use App\Utils\Constantes\ModuloLogistica\CMarcas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class SMarcas extends RepositoryDynamicsCrud implements IMarcas
{

    private CMarcas $_cMarcass;

    public function __construct(CMarcas $cMarcass)
    {
        $this->_cMarcass = $cMarcass;
    }

    public function crearMarcas(MarcasRequestCreateDTO $marcasRequestCreateDTO)
    {
        $connection = $this->findConectionDB();
        if (
            logistica_marcas::on($connection)
                ->where('descripcion', $marcasRequestCreateDTO->descripcion)->exists()
        ) {
            throw new Exception("Ya existe {$marcasRequestCreateDTO->descripcion}", Response::HTTP_CONFLICT);
        }

        $logisticaMarca = logistica_marcas::on($connection)->create($marcasRequestCreateDTO->toArray());
        $logisticaMarcaResponseDTO = new MarcasResponseDTO($logisticaMarca);
        return response()->json($logisticaMarcaResponseDTO);
    }
    public function actualizarMarcas(MarcasRequestCreateDTO $marcasRequestCreateDTO)
    {
        $connection = $this->findConectionDB();

        if (!logistica_marcas::on($connection)->find($marcasRequestCreateDTO->id)) {
            throw new Exception("marca no encontrada", Response::HTTP_NOT_FOUND);
        }

        if (
            logistica_marcas::on($connection)
                ->where('id', '<>', $marcasRequestCreateDTO->id)
                ->where('descripcion', $marcasRequestCreateDTO->descripcion)->exists()
        ) {
            throw new Exception("Este codigo {$marcasRequestCreateDTO->descripcion} ya esta asignado", Response::HTTP_CONFLICT);
        }

        return logistica_marcas::on($connection)->find($marcasRequestCreateDTO->id)
            ->update($marcasRequestCreateDTO->toArray());

    }
    public function delete($id)
    {
        $connection = $this->findConectionDB();
        if (!logistica_marcas::on($connection)->find($id)) {
            throw new Exception("marca no encontrada", Response::HTTP_NOT_FOUND);
        }
        return logistica_marcas::on($connection)->find($id)->delete();
    }

    public function getMarcas($option = null)
    {
        $connection = $this->findConectionDB();

        $logisticaMarcas = logistica_marcas::on($connection)->get();
        $logisticasMarcasDTOs = [];

        $logisticasMarcasDTOs = $logisticaMarcas->map(function ($logisticaMarca) use ($option) {
            $marcasResponseDTO = new MarcasResponseDTO($logisticaMarca);
        
            if (!$option) {
                $marcasResponseDTO->id = base64_encode(EncryptionFunction::StaticEncriptacion($marcasResponseDTO->id));
            }
        
            return $marcasResponseDTO;
        });

        return response()->json($logisticasMarcasDTOs);
    }

}
