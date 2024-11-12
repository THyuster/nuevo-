<?php

namespace App\Utils\TransfersData\ModuloNomina;

use App\Custom\Http\Request;
use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Models\NominaModels\nomina_cargos;
use App\Utils\Constantes\ModuloNomina\CCargos;
use App\Utils\DBServerSide;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use App\Utils\TransfersData\Erp\TypeCharge;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\QueryException;
// use Illuminate\Http\Client\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceCargosNomina implements IServiceCargosNomina
{

    private CCargos $_cCargos;
    private RepositoryDynamicsCrud $_repository;
    private $_typeCharge;

    public function __construct(RepositoryDynamicsCrud $repository, CCargos $cCargos)
    {
        $this->_cCargos = $cCargos;
        $this->_repository = $repository;
        $this->_typeCharge = new TypeCharge;
    }

    public function crearCargo(array $entidadCargos): ResponseHandler
    {
        try {

            $sqlCargosNomina = new CCargos();
            $nominaCargo = new nomina_cargos($entidadCargos);

            $nombre = $nominaCargo->nombre;
            $codigo_cargo = $nominaCargo->codigo_cargo;

            $sql = $sqlCargosNomina->sqlCodigoCargoOrNombreCargo($nombre, $codigo_cargo);
            $codigoCargoOrNombreCargoExist = $this->_repository->sqlFunction($sql);

            if (!empty($codigoCargoOrNombreCargoExist)) {
                $mensaje = "";

                $recorrido = 0;

                foreach ($codigoCargoOrNombreCargoExist[0] as $status) {
                    if (!is_null($status)) {
                        $recorrido++;
                        if ($recorrido > 1) {
                            $mensaje .= "y ";
                        }
                        $mensaje .= $status . " ";
                    }
                }

                throw new Exception(trim($mensaje), Response::HTTP_CONFLICT);
            }

            $connection = $this->_repository->findConectionDB();

            $nominaCargo = $nominaCargo->setConnection($connection)->save();

            return new ResponseHandler("Cargo Creado Correctamente", $nominaCargo, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], 500);
        } catch (Exception $th) {
            return new ResponseHandler($th->getMessage(), [], $th->getCode());
        }
    }
    public function actualizarCargo(string $id, $entidadCargos): ResponseHandler
    {
        try {

            $sqlCargosNomina = new CCargos();
            $connection = $this->_repository->findConectionDB();

            $nominaCargoModel = nomina_cargos::on($connection)->find($id);


            $nombre = $entidadCargos["nombre"];
            $codigo_cargo = $entidadCargos["codigo_cargo"];

            $sql = $sqlCargosNomina->sqlCodigoCargoOrNombreCargoDiferent($nombre, $codigo_cargo, $id);
            $codigoCargoOrNombreCargoExist = $this->_repository->sqlFunction($sql);

            if (!empty($codigoCargoOrNombreCargoExist)) {
                $mensaje = "";

                $recorrido = 0;

                foreach ($codigoCargoOrNombreCargoExist[0] as $status) {
                    if (!is_null($status)) {
                        $recorrido++;
                        if ($recorrido > 0) {
                            $mensaje .= "y ";
                        }
                        $mensaje .= $status . " ";
                    }
                }

                throw new Exception(trim($mensaje), Response::HTTP_CONFLICT);
            }


            // $nominaCargoModel = $nominaCargoModel->on($connection);
            $nominaCargoModel->update($entidadCargos);

            return new ResponseHandler("Cargo Actualizado Correctamente", $nominaCargoModel, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], 500);
        } catch (Exception $th) {
            return new ResponseHandler($th->getMessage(), [], $th->getCode());
        }

    }
    public function eliminarCargo(string $id): ResponseHandler
    {
        try {
            $connection = $this->_repository->findConectionDB();

            $nominaCargoModel = nomina_cargos::on($connection)->find($id);

            if (!$nominaCargoModel) {
                throw new Exception("El cargo no existe", Response::HTTP_CONFLICT);
            }

            $nominaCargoModel = $nominaCargoModel->delete();

            return new ResponseHandler("Cargo Creado Correctamente", $nominaCargoModel, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return new ResponseHandler($th->getMessage(), [], 500);
        } catch (Exception $th) {
            return new ResponseHandler($th->getMessage(), [], $th->getCode());
        }
    }

    public function getCargo()
    {
        $connection = RepositoryDynamicsCrud::findConectionDB();
        $nominaCargo = new nomina_cargos();
        $nominaCargoQuery = nomina_cargos::on($connection);
 
        $request = Request::capture();
        $datatableDTO = new DatatableResponseDTO();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $nominaCargoQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($nominaCargo->getTable());

        $datatableDTO->recordsTotal = $nominaCargoQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $nominaCargoQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $nominaCargoQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $nominaCargoQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $nominaCargoQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $nominaCargoQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $nominaCargoQuery->get();
        return response()->json($datatableDTO);
        
    }
    private function validateType($id)
    {
        return $this->_typeCharge->findTypeCharge($id);
    }


    /**
     *
     * @param mixed $nombre
     * @param mixed $codigo
     * @return mixed
     */
    public function filterCargo($nombre, $codigo)
    {
        try {
            $connection = $this->_repository->findConectionDB();

            $datos = nomina_cargos::on($connection)->where('nombre', 'LIKE', "%$nombre%")
                ->orWhere('codigo_cargo', 'LIKE', "%$codigo%")->get(['nombre', 'requisitos_minimos_puesto', 'nomina_cargo_id']);

            return $datos;
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
            return $response->responses();
        } catch (Exception $e) {
            $response = new ResponseHandler($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
            return $response->responses();

        } catch (QueryException $queryException) {
            $response = new ResponseHandler($queryException->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
            return $response->responses();

        }

    }
}
