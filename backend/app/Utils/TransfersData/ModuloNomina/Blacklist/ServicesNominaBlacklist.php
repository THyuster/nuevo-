<?php

namespace App\Utils\TransfersData\ModuloNomina\Blacklist;

use App\Data\Dtos\Convocatorias\BlanckListDTOs\BlacklistRequestCreateDTO;
use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Models\NominaModels\Blacklist\NominaBlacklist;
use App\Utils\DBServerSide;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use App\Utils\TransfersData\ModuloNomina\Blacklist\Repository\IRepositoryBlacklist;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request as HttpRequest;

class ServicesNominaBlacklist implements IServiceNominaBlacklist
{
    protected IRepositoryBlacklist $_repositoryBlacklist;
    public function __construct(IRepositoryBlacklist $iRepositoryBlacklist)
    {
        $this->_repositoryBlacklist = $iRepositoryBlacklist;
    }

    public function create(BlacklistRequestCreateDTO $blacklistRequestCreateDTO): JsonResponse
    {
        $responseHandler = new ResponseHandler();

        try {
            // Verifica si el usuario ya está registrado en la lista negra
            if ($this->_repositoryBlacklist->userInBlacklistByIdentificacion($blacklistRequestCreateDTO->identificacion)) {
                return $responseHandler->setMessage('Usuario ya registrado en la blacklist')
                    ->setStatus(Response::HTTP_CONFLICT)
                    ->responses();
            }

            // Crea un nuevo registro en la lista negra
            $blacklist = $this->_repositoryBlacklist->create($blacklistRequestCreateDTO->toArray());

            // Retorna la respuesta con los datos del nuevo registro
            return $responseHandler->setData($blacklist)
                ->setMessage('Usuario registrado en la blacklist con éxito')
                ->setStatus(Response::HTTP_CREATED)
                ->responses();

        } catch (QueryException $qe) {
            // Maneja errores específicos de la consulta
            return $responseHandler->handleException($qe, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            // Maneja errores generales
            return $responseHandler->handleException($e, $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(string $idBlacklist, BlacklistRequestCreateDTO $blacklistRequestUpdateDTO)
    {

        $responseHandler = new ResponseHandler();

        try {
            // Busca el registro en la lista negra por ID
            $blackList = $this->_repositoryBlacklist->findById($idBlacklist);

            // Verifica si el registro existe
            if (!$blackList) {
                return $responseHandler
                    ->setMessage('Registro de la blacklist no encontrado')
                    ->setStatus(Response::HTTP_NOT_FOUND)
                    ->responses();
            }

            // Verifica si la identificación ya está registrada con un ID diferente
            if ($this->_repositoryBlacklist->isUserInBlacklistWithDifferentId($idBlacklist, $blacklistRequestUpdateDTO->identificacion)) {
                return $responseHandler
                    ->setMessage('La identificación ya fue registrada en la blacklist')
                    ->setStatus(Response::HTTP_CONFLICT)
                    ->responses();
            }

            // Actualiza el registro con los nuevos datos
            $updatedRecord = $this->_repositoryBlacklist->update($idBlacklist, $blacklistRequestUpdateDTO->toArray());

            // Retorna la respuesta con los datos actualizados
            return $responseHandler
                ->setData($updatedRecord)
                ->setMessage('Usuario actualizado en la blacklist con éxito')
                ->setStatus(Response::HTTP_OK)
                ->responses();

        } catch (QueryException $qe) {
            // Maneja errores específicos de la consulta
            return $responseHandler->handleException($qe, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            // Maneja errores generales
            return $responseHandler->handleException($e, $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(string $idBlacklist): JsonResponse
    {
        $responseHandler = new ResponseHandler();

        try {
            // Busca el registro en la lista negra por ID
            $blackList = $this->_repositoryBlacklist->findById($idBlacklist);

            // Verifica si el registro existe
            if (!$blackList) {
                return $responseHandler
                    ->setMessage('Registro de la blacklist no encontrado')
                    ->setStatus(Response::HTTP_NOT_FOUND)
                    ->responses();
            }

            // Elimina el registro
            $this->_repositoryBlacklist->delete($idBlacklist);

            // Retorna una respuesta de éxito
            return $responseHandler
                ->setMessage('Usuario eliminado de la blacklist con éxito')
                ->setStatus(Response::HTTP_OK)
                ->responses();

        } catch (QueryException $qe) {
            // Maneja errores específicos de la consulta
            return $responseHandler->handleException($qe, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            // Maneja errores generales
            return $responseHandler->handleException($e, $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get()
    {
        $connection = RepositoryDynamicsCrud::findConectionDB();
        $request = HttpRequest::capture();

        $datatableDTO = new DatatableResponseDTO();
        $nominaBlacklist = new NominaBlacklist(); 
        $nominaBlacklistQuery = NominaBlacklist::on($connection);

        $columns = $nominaBlacklistQuery->getConnection()->getSchemaBuilder()->getColumnListing($nominaBlacklist->getTable());

        $datatableDTO->recordsTotal = $nominaBlacklistQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $nominaBlacklistQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);
      
        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $nominaBlacklistQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $nominaBlacklistQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $nominaBlacklistQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $nominaBlacklistQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $nominaBlacklistQuery->get();
        return $datatableDTO;

    }

}
