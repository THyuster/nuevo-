<?php

namespace App\Http\Controllers\modulo_nomina\Gestion;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Http\Controllers\Controller;
use App\Models\NominaModels\Centros\Costo\nomina_centros_costo_view;
use App\Utils\DBServerSide;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class NominaCentroCostos extends Controller
{
    public function store(Request $request)
    {
        $cargoSena = $request->all();


        $request->validate([
            "*" => "prohibited",
            "descripcion" => "required|string",
            "name" => "required|string",
            "centro_cont_id" => "required|int",
        ]);

        $cargoSenaDto = [
            "descripcion" => htmlspecialchars($cargoSena["descripcion"], ENT_QUOTES),
            "name" => htmlspecialchars($cargoSena["name"], ENT_QUOTES),
            "centro_cont_id" => $cargoSena["centro_cont_id"],
            "estado" => 1,
        ];


        $descripcion = $cargoSenaDto["descripcion"];
        $codigo = $cargoSenaDto["name"];
        $estado = $cargoSenaDto["estado"];
        $centroContabilidadId = $cargoSenaDto['centro_cont_id'];

        $sql = "SELECT * FROM contabilidad_centros WHERE id = '$centroContabilidadId'";
        $repositorio = new RepositoryDynamicsCrud();

        $response = $repositorio->sqlFunction($sql);

        if (empty($response)) {
            $response = new ResponseHandler('No existe el centro contable seleccionado', [], 500);
            return $response->responses();
        }

        $sql = "SELECT 1 FROM nomina_centros_costo WHERE name = '$codigo' AND descripcion = '$descripcion'";

        $response = $repositorio->sqlFunction($sql);

        if (!empty($response)) {
            $response = new ResponseHandler("No puede utilizar un nombre o descripcion que ya haya sido registrado", [], 500);
            return $response->responses();
        }

        try {

            $sql = "INSERT INTO nomina_centros_costo 
            (`descripcion`, `name`, `estado`,`centro_cont_id`) 
            values ('$descripcion','$codigo','$estado','$centroContabilidadId')";

            $repositorio->sqlFunction($sql);
        } catch (\Throwable $th) {
            //throw $th;
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
        $nominaCentroCostoView = new nomina_centros_costo_view();
        $nominaCentroCostoViewQuery = nomina_centros_costo_view::on($connection);
 
        $request = Request::capture();
        $datatableDTO = new DatatableResponseDTO();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $nominaCentroCostoViewQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($nominaCentroCostoView->getTable());

        $datatableDTO->recordsTotal = $nominaCentroCostoViewQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $nominaCentroCostoViewQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $nominaCentroCostoViewQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $nominaCentroCostoViewQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $nominaCentroCostoViewQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $nominaCentroCostoViewQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $nominaCentroCostoViewQuery->get();
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
            "name" => "required|string",
            "centro_cont_id" => "required|int",
        ]);
        $cargoSena = $request->all();

        $cargoSenaDto = [
            "descripcion" => htmlspecialchars($cargoSena["descripcion"], ENT_QUOTES),
            "name" => htmlspecialchars($cargoSena["name"], ENT_QUOTES),
            "centro_cont_id" => $cargoSena["centro_cont_id"],
            "estado" => 1,
        ];

        $repositorio = new RepositoryDynamicsCrud();


        $cargoExistente = $repositorio->sqlFunction("SELECT estado FROM nomina_centros_costo WHERE id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler('No existe', [], 404);
            return $response->responses();
        }

        $centroContabilidadId = $cargoSenaDto['centro_cont_id'];
        $descripcion = $cargoSenaDto["descripcion"];
        $codigo = $cargoSenaDto["name"];


        $sql = "SELECT * FROM contabilidad_centros WHERE id = '$centroContabilidadId'";

        $response = $repositorio->sqlFunction($sql);

        if (empty($response)) {
            $response = new ResponseHandler('No existe', [], 404);
            return $response->responses();
        }

        $sql = "SELECT 1 FROM nomina_centros_costo WHERE name = '$codigo' AND descripcion = '$descripcion' AND id <> '$id'";

        $response = $repositorio->sqlFunction($sql);

        if (!empty($response)) {
            $response = new ResponseHandler("No puede utilizar un nombre o descripcion que ya haya sido registrado", [], 500);
            return $response->responses();
        }



        try {

            $sql = "UPDATE nomina_centros_costo SET 
            descripcion = '$descripcion', centro_cont_id = '$centroContabilidadId',
             name = '$codigo' WHERE id = '$id' ";

            $repositorio->sqlFunction($sql);
        } catch (\Throwable $th) {
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
        $cargoExistente = $repositorio->sqlFunction("SELECT estado FROM nomina_centros_costo WHERE id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler('No existe', [], 404);
            return $response->responses();
        }

        try {
            $estado = $cargoExistente[0]->estado == 1 ? 0 : 1;
            $repositorio->sqlFunction("UPDATE nomina_centros_costo SET estado = '$estado' WHERE id = '$id'");
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
        $cargoExistente = $repositorio->sqlFunction("SELECT id FROM nomina_centros_costo WHERE id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler('No existe', [], 404);
            return $response->responses();
        }

        try {
            $repositorio->sqlFunction("DELETE FROM nomina_centros_costo WHERE id = '$id'");
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (\Exception $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        }

        return true;
    }
}
