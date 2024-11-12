<?php

namespace App\Utils\TransfersData\Erp\Roles\Services;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Models\modulo_contabilidad\contabilidad_empresas;
use App\Models\Roles;
use App\Utils\CatchToken;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use App\Utils\TransfersData\Erp\Roles\Interfaces\IRoles;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicesRoles extends RepositoryDynamicsCrud implements IRoles
{

    private $_empresa_id;
    public function __construct(CatchToken $catchToken)
    {
        $this->_empresa_id = $catchToken::Claims();
    }

    /**
     *
     * @param \App\Models\Roles $roles
     */
    public function createRole(Roles $roles): JsonResponse
    {
        $responseHandler = new ResponseHandler();

        // Busca la empresa por ID
        $empresa = contabilidad_empresas::find($this->_empresa_id);

        // Verifica si la empresa no existe
        if (!$empresa) {
            $responseHandler->setMessage('Empresa no existente');
            $responseHandler->setStatus(Response::HTTP_BAD_REQUEST);
            return $responseHandler->responses();
        }

        // Establece el ID de la empresa y el estado del rol
        $roles->empresa_id = $this->_empresa_id;
        $roles->estado = 1;

        // Genera el código del rol a partir de la razón social de la empresa
        $razonSocial = str_replace([' ', "'"], '', $empresa->razon_social);
        $roles->codigo = strtoupper($razonSocial);

        // Verifica si el rol ya existe para esta empresa
        $roleExist = Roles::where("descripcion", $roles->descripcion)->where('empresa_id', $this->_empresa_id)->first();

        // Si el rol ya existe, devuelve una respuesta de conflicto
        if ($roleExist) {
            $responseHandler->setStatus(Response::HTTP_CONFLICT);
            $responseHandler->setData($roleExist);
            $responseHandler->setMessage('Rol ya existe');
            return $responseHandler->responses();
        }

        // Intenta guardar el nuevo rol
        try {
            // Guarda el rol en la base de datos
            $roles->save();

            // Actualiza el código del rol con el ID generado
            $roles->codigo .= $roles->id;
            $roles->save();

            // Prepara la respuesta exitosa
            $responseHandler->setData($roles);
            $responseHandler->setMessage("Rol Creado Correctamente");
            $responseHandler->setStatus(Response::HTTP_OK);
        } catch (\Throwable $th) {
            // Si hay un error, prepara una respuesta de error interno del servidor
            $responseHandler->setMessage("Error al crear el rol");
            $responseHandler->setData($th->getMessage());
            $responseHandler->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Devuelve la respuesta
        return $responseHandler->responses();
    }


    public function deleteRole(int $id): JsonResponse
    {
        $responseHandler = new ResponseHandler();

        // Busca el rol por ID
        $role = Roles::find($id);

        // Verifica si el rol no existe
        if (!$role) {
            $responseHandler->setData(false);
            $responseHandler->setStatus(Response::HTTP_NOT_FOUND);
            $responseHandler->setMessage("Rol no encontrado");
            return $responseHandler->responses();
        }

        // Verifica si el rol pertenece a la empresa del usuario
        if ($role->empresa_id != $this->_empresa_id) {
            $responseHandler->setStatus(Response::HTTP_CONFLICT);
            $responseHandler->setData(false);
            $responseHandler->setMessage("El rol no corresponde a su empresa");
        } else {
            // Intenta eliminar el rol
            try {
                $respuesta = $role->delete();
                $responseHandler->setData($respuesta);
                $responseHandler->setMessage("Rol Eliminado");
                $responseHandler->setStatus(Response::HTTP_OK);
            } catch (\Throwable $th) {
                // Si hay un error, prepara una respuesta de error interno del servidor
                $responseHandler->setMessage($th->getMessage());
                $responseHandler->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        // Devuelve la respuesta
        return $responseHandler->responses();
    }


    public function getRoles(Request $request)
    {
        // Inicializa la consulta para obtener los roles de la empresa actual

        $roles = new Roles();
        $rolesQuery = Roles::on();
        $rolesQuery = Roles::where("empresa_id", $this->_empresa_id);

        $request = Request::capture();
        $datatableDTO = new DatatableResponseDTO();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $rolesQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($roles->getTable());

        $datatableDTO->recordsTotal = $rolesQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $rolesQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $rolesQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $rolesQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $rolesQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $rolesQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $rolesQuery->get();
        return response()->json($datatableDTO);
    }

    /**
     *
     * @param int $id
     * @param Roles $roles
     * @return JsonResponse
     */
    public function updateRole(int $id, Roles $roles): JsonResponse
    {
        $responseHandler = new ResponseHandler();

        // Encuentra el rol por su ID
        $role = Roles::find($id);

        // Verifica si el rol existe
        if ($role) {
            // Verifica si el rol pertenece a la empresa del usuario
            if ($role->empresa_id != $this->_empresa_id) {
                $responseHandler->setMessage("El rol no existe");
                $responseHandler->setStatus(Response::HTTP_NOT_FOUND);
                $responseHandler->setData($roles);
                return $responseHandler->responses();
            }

            // Verifica si ya existe otro rol con la misma descripción en la misma empresa
            $roleInDescripcion = Roles::where("descripcion", $roles->descripcion)
                ->where("empresa_id", $this->_empresa_id)
                ->where("id", "!=", $id)
                ->first();

            if ($roleInDescripcion) {
                $responseHandler->setMessage("Esta descripción ya existe");
                $responseHandler->setStatus(Response::HTTP_CONFLICT);
                return $responseHandler->responses();
            }

            // Intenta actualizar el rol
            $response = $role->update($roles->toArray());

            // Prepara la respuesta
            $mensaje = $response ? "Rol Actualizado" : "Error al actualizar";
            $status = $response ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST;

            $responseHandler->setMessage($mensaje);
            $responseHandler->setStatus($status);
            $responseHandler->setData($role);

            return $responseHandler->responses();
        }

        // Si el rol no se encuentra, devuelve un mensaje de error
        $responseHandler->setMessage("Rol no encontrado");
        $responseHandler->setStatus(Response::HTTP_NOT_FOUND);
        $responseHandler->setData([]);
        return $responseHandler->responses();
    }

}
