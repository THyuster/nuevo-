<?php

namespace App\Http\Controllers\modulo_nomina\Gestion;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Http\Controllers\Controller;
use App\Models\NominaModels\Areas\nomina_areas_view;
use App\Utils\DBServerSide;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class NominaArea extends Controller
{




    public function store(Request $request)
    {
        $request->validate([
            "*" => "prohibited",
            "descripcion" => "required|string",
            "codigo" => "required|string",
            "area_cont_id" => "required|int",
        ]);

        $cargoSena = $request->all();
        // return $cargoSena["area_cont_id"];
        $cargoSenaDto = [
            "descripcion" => htmlspecialchars($cargoSena["descripcion"], ENT_QUOTES),
            "codigo" => htmlspecialchars($cargoSena["codigo"], ENT_QUOTES),
            "area_cont_id" => $cargoSena["area_cont_id"],
            "estado" => 1,
        ];



        $descripcion = $cargoSenaDto["descripcion"];
        $codigo = $cargoSenaDto["codigo"];
        $estado = $cargoSenaDto["estado"];
        $areaContabilidadId = $cargoSenaDto['area_cont_id'];

        $repositorio = new RepositoryDynamicsCrud();

        $sql = "SELECT * FROM contabilidad_areas WHERE id = '$areaContabilidadId'";

        $result = $repositorio->sqlFunction($sql);

        if (empty($result)) {
            # code...
            $response = new ResponseHandler('No existe el area contable seleccionada', [], 500);
            return $response->responses();
        }


        $sql = "SELECT 1 FROM nomina_areas WHERE codigo = '$codigo' AND descripcion = '$descripcion'";

        $response = $repositorio->sqlFunction($sql);

        if (!empty($response)) {
            $response = new ResponseHandler("No puede utilizar un nombre o descripcion que ya haya sido registrado", [], 500);
            return $response->responses();
        }

        try {
            $repositorio->sqlFunction("INSERT INTO nomina_areas  (`descripcion`, `codigo`, `estado`,`area_cont_id`) 
            values ('$descripcion','$codigo','$estado','$areaContabilidadId')");
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (Exception $th) {
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
        // $datos = [];
        $connection = RepositoryDynamicsCrud::findConectionDB();
        $nominaAreaView = new nomina_areas_view();
        $nominaAreaViewQuery = nomina_areas_view::on($connection);
 
        $request = Request::capture();
        $datatableDTO = new DatatableResponseDTO();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $nominaAreaViewQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($nominaAreaView->getTable());

        $datatableDTO->recordsTotal = $nominaAreaViewQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $nominaAreaViewQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $nominaAreaViewQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $nominaAreaViewQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $nominaAreaViewQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $nominaAreaViewQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $nominaAreaViewQuery->get();
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
            "area_cont_id" => "required|int",
        ]);

        $cargoSena = $request->all();

        $cargoSenaDto = [
            "descripcion" => htmlspecialchars($cargoSena["descripcion"], ENT_QUOTES),
            "codigo" => htmlspecialchars($cargoSena["codigo"], ENT_QUOTES),
            "estado" => 1,
            "area_cont_id" => $cargoSena["area_cont_id"]
        ];

        $repositorio = new RepositoryDynamicsCrud();
        $cargoExistente = $repositorio->sqlFunction("SELECT estado FROM nomina_areas  WHERE id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler("No existe", [], 404);
            return $response->responses();
        }
        $descripcion = $cargoSenaDto["descripcion"];
        $codigo = $cargoSenaDto["codigo"];
        $areaContableId = $cargoSena["area_cont_id"];

        $sql = "SELECT 1 FROM nomina_areas WHERE codigo = '$codigo' AND descripcion = '$descripcion' 
        AND id <> '$id'";

        $response = $repositorio->sqlFunction($sql);

        if (!empty($response)) {
            $response = new ResponseHandler("No puede utilizar un nombre o descripcion que ya haya sido registrado", [], 500);
            return $response->responses();
        }


        try {
            // UPDATE `nomina_areas` SET `codigo` = '009ss', `descripcion` = 'Holissss :3x' WHERE `nomina_areas`.`id` = 3
            $repositorio->sqlFunction("UPDATE nomina_areas SET descripcion = '$descripcion',
             codigo = '$codigo',
             area_cont_id = '$areaContableId' 
             WHERE id = '$id'");
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (Exception $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        }


        return true;
    }

    public function cambiarEstado($id)
    {
        $repositorio = new RepositoryDynamicsCrud();
        $cargoExistente = $repositorio->sqlFunction("SELECT estado FROM nomina_areas  WHERE id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler("No existe", [], 404);
            return $response->responses();
        }

        try {
            $estado = $cargoExistente[0]->estado == 1 ? 0 : 1;
            $repositorio->sqlFunction("UPDATE nomina_areas  SET estado = '$estado' WHERE id = '$id'");
        } catch (\Throwable $th) {

            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (Exception $th) {
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
        $cargoExistente = $repositorio->sqlFunction("SELECT id FROM nomina_areas  WHERE id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler('No existe', [], 404);
            return $response->responses();
        }

        try {
            $repositorio->sqlFunction("DELETE FROM nomina_areas  WHERE id = '$id'");
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (Exception $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        }

        return true;
    }
}
