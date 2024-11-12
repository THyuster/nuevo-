<?php

namespace App\Http\Controllers\modulo_nomina\Gestion;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Http\Controllers\Controller;
use App\Models\NominaModels\Secciones\nomina_seccion;
use App\Utils\DBServerSide;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class NominaSeccion extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "*" => "prohibited",
            "descripcion" => "required|string",
            "codigo" => "required|string",
        ]);

        $cargoSena = $request->all();

        $cargoSenaDto = [
            "descripcion" => htmlspecialchars($cargoSena["descripcion"], ENT_QUOTES),
            "codigo" => htmlspecialchars($cargoSena["codigo"], ENT_QUOTES),
            "estado" => 1,
        ];


        $descripcion = $cargoSenaDto["descripcion"];
        $codigo = $cargoSenaDto["codigo"];
        $estado = $cargoSenaDto["estado"];

        $repositorio = new RepositoryDynamicsCrud();

        $sql = "SELECT 1 FROM nomina_seccion WHERE codigo = '$codigo' AND descripcion = '$descripcion'";

        $response = $repositorio->sqlFunction($sql);

        if (!empty($response)) {
            $response = new ResponseHandler("No puede utilizar un codigo o descripcion antes usada", [], 500);
            return $response->responses();
        }

        try {
            $repositorio->sqlFunction("INSERT INTO nomina_seccion  (`descripcion`, `codigo`, `estado`) values ('$descripcion','$codigo','$estado')");
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (\Exception $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        }

        return true;

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $connection = RepositoryDynamicsCrud::findConectionDB();
        $nominaSeccion = new nomina_seccion();
        $nominaSeccionQuery = nomina_seccion::on($connection);

        $request = Request::capture();
        $datatableDTO = new DatatableResponseDTO();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $nominaSeccionQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($nominaSeccion->getTable());

        $datatableDTO->recordsTotal = $nominaSeccionQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $nominaSeccionQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $nominaSeccionQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $nominaSeccionQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $nominaSeccionQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $nominaSeccionQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $nominaSeccionQuery->get();
        return response()->json($datatableDTO);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            "*" => "prohibited",
            "descripcion" => "required|string",
            "codigo" => "required|string",
        ]);

        $cargoSena = $request->all();

        $cargoSenaDto = [
            "descripcion" => htmlspecialchars($cargoSena["descripcion"], ENT_QUOTES),
            "codigo" => htmlspecialchars($cargoSena["codigo"], ENT_QUOTES),
            "estado" => 1,
        ];

        $repositorio = new RepositoryDynamicsCrud();

        $cargoExistente = $repositorio->sqlFunction("SELECT estado FROM nomina_seccion  WHERE id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler("No existe", [], 404);
            return $response->responses();
        }

        $descripcion = $cargoSenaDto["descripcion"];
        $codigo = $cargoSenaDto["codigo"];

        $sql = "SELECT 1 FROM nomina_seccion WHERE codigo = '$codigo' AND descripcion = '$descripcion' AND id <> '$id'";

        $response = $repositorio->sqlFunction($sql);

        if (!empty($response)) {
            $response = new ResponseHandler("No puede utilizar un codigo o descripcion antes usada", [], 500);
            return $response->responses();
        }

        try {
            $repositorio->sqlFunction("UPDATE  nomina_seccion  SET descripcion = '$descripcion', codigo = '$codigo' WHERE id = '$id' ");
        } catch (\Throwable $th) {
            // throw $false;
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (\Exception $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        }


        return true;

    }

    public function cambiarEstado($id)
    {
        $repositorio = new RepositoryDynamicsCrud();
        $cargoExistente = $repositorio->sqlFunction("SELECT estado FROM nomina_seccion  WHERE id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler("No existe", [], 404);
            return $response->responses();
        }

        try {
            $estado = $cargoExistente[0]->estado == 1 ? 0 : 1;
            $repositorio->sqlFunction("UPDATE  nomina_seccion  SET estado = '$estado' WHERE id = '$id'");
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (\Exception $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        }

        return true;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $repositorio = new RepositoryDynamicsCrud();
        $cargoExistente = $repositorio->sqlFunction("SELECT id FROM nomina_seccion  WHERE id = '$id'");

        if (empty($cargoExistente)) {
            return false;
        }

        try {
            $repositorio->sqlFunction("DELETE FROM nomina_seccion  WHERE id = '$id'");
        } catch (\Throwable $th) {
            return false;
        } catch (\Exception $th) {
            return false;
        }

        return true;
    }
}
