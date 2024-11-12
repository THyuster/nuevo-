<?php


namespace App\Http\Controllers\modulo_nomina\Gestion;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Http\Controllers\Controller;
use App\Models\NominaModels\Cargos\nomina_cargos_sena;
use App\Utils\DBServerSide;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class GestionCargosSena extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
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

        $sql = "SELECT 1 FROM nomina_cargos_sena WHERE codigo = '$codigo' AND descripcion = '$descripcion'";

        $response = $repositorio->sqlFunction($sql);

        if (!empty($response)) {           
            $response = new ResponseHandler("No puede utilizar un codigo o descripcion ya registrado", [], 500);
            return $response->responses();
        }


        try {
            $repositorio->sqlFunction("INSERT INTO nomina_cargos_sena (`descripcion`, `codigo`, `estado`) values ('$descripcion','$codigo','$estado')");
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
        $inventarioArticulo = new nomina_cargos_sena();
        $inventarioArticuloQuery = nomina_cargos_sena::on($connection);

        $request = Request::capture();
        $datatableDTO = new DatatableResponseDTO();

        // $query = $this->_equipoRepository->getQueryBuild();
        $columns = $inventarioArticuloQuery->getConnection()->getSchemaBuilder()
            ->getColumnListing($inventarioArticulo->getTable());

        $datatableDTO->recordsTotal = $inventarioArticuloQuery->count();
        $datatableDTO->draw = intval($request->input('draw', 1));

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', null);
        $orders = $request->input('order', null);

        if ($search) {
            $inventarioArticuloQuery->where(function (Builder $q) use ($search, $columns) {
                foreach ($columns ?? [] as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $columnFilters = $request->input('columnFilters', []);
        $columnsFilters = $request->input('columns', []);

        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $inventarioArticuloQuery->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $datatableDTO->recordsFiltered = $inventarioArticuloQuery->count();

        if ($orders) {
            foreach ($orders as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex] ?? null;
                $direction = $order['dir'];
                if ($columnName) {
                    $inventarioArticuloQuery->orderBy($columnName, $direction);
                }
            }
        }

        if ($length != -1) {
            $inventarioArticuloQuery->offset($start)->limit($length);
        }

        $datatableDTO->data = $inventarioArticuloQuery->get();
        return response()->json($datatableDTO);
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "*" => "prohibited",
            "descripcion" => "required|string",
            "codigo" => "required|string",
        ]);

        $repositorio = new RepositoryDynamicsCrud();
        //
        $cargoSena = $request->all();

        $cargoExistente = $repositorio->sqlFunction("SELECT estado FROM nomina_cargos_sena WHERE nomina_cargo_sena_id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler("No existe", [], 404);
            return $response->responses();
        }

        $cargoSenaDto = [
            "descripcion" => htmlspecialchars($cargoSena["descripcion"], ENT_QUOTES),
            "codigo" => htmlspecialchars($cargoSena["codigo"], ENT_QUOTES),
            "estado" => 1,
        ];


        $descripcion = $cargoSenaDto["descripcion"];
        $codigo = $cargoSenaDto["codigo"];

        $sql = "SELECT 1 FROM nomina_cargos_sena WHERE codigo ='$codigo' AND descripcion = '$descripcion' 
        AND nomina_cargo_sena_id <> '$id'";

        $response = $repositorio->sqlFunction($sql);

        if (!empty($response)) {           
            $response = new ResponseHandler("No puede utilizar un codigo o descripcion antes usada", [], 500);
            return $response->responses();
        }

        try {
            $repositorio->sqlFunction("UPDATE nomina_cargos_sena SET descripcion = '$descripcion', codigo = '$codigo' 
            WHERE nomina_cargo_sena_id = '$id' ");
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
        $cargoExistente = $repositorio->sqlFunction("SELECT estado FROM nomina_cargos_sena WHERE nomina_cargo_sena_id = '$id'");


        if (empty($cargoExistente)) {
            $response = new ResponseHandler("No existe", [], 404);
            return $response->responses();
        }

        try {
            $estado = $cargoExistente[0]->estado == 1 ? 0 : 1;
            $repositorio->sqlFunction("UPDATE nomina_cargos_sena SET estado = '$estado' WHERE nomina_cargo_sena_id = '$id'");
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
        $cargoExistente = $repositorio->sqlFunction("SELECT nomina_cargo_sena_id FROM nomina_cargos_sena WHERE nomina_cargo_sena_id = '$id'");

        if (empty($cargoExistente)) {
            $response = new ResponseHandler("No existe", [], 404);
            return $response->responses();
        }

        try {
            $repositorio->sqlFunction("DELETE FROM nomina_cargos_sena WHERE nomina_cargo_sena_id = '$id'");
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (\Exception $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        }

        return true;
    }
    public function getListCargosSena()
    {  
        $data = [];

        $repositorio = new RepositoryDynamicsCrud();

        $sql = "SELECT * FROM nomina_cargos_sena";

        try {
            $data = $repositorio->sqlFunction($sql);
        } catch (\Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        } catch (\Exception $th) {
            $response = new ResponseHandler($th->getMessage(), [], 500);
            return $response->responses();
        }

        return $data;
    }
}
