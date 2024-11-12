<?php

namespace App\Utils\TransfersData\ModuloActivosFijos;

use App\Data\Dtos\ActivosFijos\GruposEquipos\Request\GrupoEquipoRequestCreateDTO;
use App\Utils\TransfersData\ModuloActivosFijos\Repositories\GruposEquipos\IGruposEquiposRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class GruposEquiposServices implements IGruposEquiposServices
{
    protected IGruposEquiposRepository $_grupoEquipoRepository;

    public function __construct(IGruposEquiposRepository $iGruposEquiposRepository)
    {
        $this->_grupoEquipoRepository = $iGruposEquiposRepository;
    }
    
    public function create(GrupoEquipoRequestCreateDTO $grupoEquipoRequestCreateDTO)
    {
        if ($this->_grupoEquipoRepository->verificarCodigoExistente($grupoEquipoRequestCreateDTO->codigo)) {
            throw new Exception(__('messages.alreadyExistsMessageCode'), Response::HTTP_CONFLICT);
        }

        $grupoEquipo = $this->_grupoEquipoRepository->create($grupoEquipoRequestCreateDTO->toArray());

        return $grupoEquipo;
    }
    
    public function update($id, GrupoEquipoRequestCreateDTO $grupoEquipoRequestCreateDTO)
    {

        $grupoEquipo = $this->_grupoEquipoRepository->findById($id);

        if (!$grupoEquipo) {
            throw new Exception(__('messages.notFoundMessages'), Response::HTTP_NOT_FOUND);
        }

        if ($this->_grupoEquipoRepository->checkCodigoUniquenessIgnoringId($grupoEquipoRequestCreateDTO->codigo, $id)) {
            throw new Exception(__('messages.alreadyExistsMessageCode'), Response::HTTP_CONFLICT);
        }

        $response = $this->_grupoEquipoRepository->update($id, $grupoEquipoRequestCreateDTO->toArray());

        return $response;
    }

    public function getGrupoEquiposFilter($filter)
    {
        $campos = ["id", "descripcion", "codigo"];

        $gruposEquipos = $this->_grupoEquipoRepository->findGrupoEquipoByLikeQuery($campos, $filter);

        return $gruposEquipos;
    }
    
    public function delete($id)
    {
        $grupoEquipo = $this->_grupoEquipoRepository->findById($id);

        if (!$grupoEquipo) {
            throw new Exception(__('messages.notFoundMessages'), Response::HTTP_NOT_FOUND);
        }

        $response = $this->_grupoEquipoRepository->delete($id);

        return $response;
    }
}
