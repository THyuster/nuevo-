<?php

namespace App\Http\Controllers\modulo_inventarios;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\inventory\ArticleValidation;
use App\Models\modulo_inventarios\inventarios_articulos;
use App\Utils\FileManager;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Utils\Constantes\ModuloInventario\ConstantesGruposContables;
use App\Utils\Constantes\ModuloInventario\ConstantesUnidades;
use App\Utils\Constantes\ModuloInventario\ConstantesTipoArticulos;
use App\Utils\Constantes\ModuloInventario\ConstantesMarcas;
use App\Utils\Constantes\ModuloInventario\ConstantesGrupoArticulos;
use App\Utils\Constantes\ModuloInventario\ConstantesArticulos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\ModuloInventario\ServiceArticulos;
use App\Utils\MyFunctions;

class inventarios_articulosController extends Controller
{
    protected $constantesGruposContables, $constantesGrupoArticulo, $constantesArticulos;
    protected $constantesMarca, $constantesUnidad, $constantesTipoArticulo, $serviceArticulo;
    protected $repository, $fileManager, $funciones;

    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->constantesGruposContables = new ConstantesGruposContables;
        $this->constantesGrupoArticulo = new ConstantesGrupoArticulos;
        $this->constantesMarca = new ConstantesMarcas;
        $this->constantesUnidad = new ConstantesUnidades;
        $this->constantesTipoArticulo = new ConstantesTipoArticulos;
        $this->constantesArticulos = new ConstantesArticulos;
        $this->serviceArticulo = new ServiceArticulos;
        $this->fileManager = new FileManager;
        $this->funciones = new MyFunctions;
    }


    public function create(Request $request)
    {
        return $this->serviceArticulo->createArticulo($request->all(), $request);
    }

    public function show()
    {
        $connection = RepositoryDynamicsCrud::findConectionDB();
        $inventarioArticulo = new inventarios_articulos();
        $inventarioArticuloQuery = inventarios_articulos::on($connection);

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

        // return $this->repository->sqlFunction($this->constantesArticulos->sqlSelectAll());
    }

    public function update(Request $request, $id)
    {
        return $this->serviceArticulo->updateArticulo($id, $request->all(), $request);
    }

    public function destroy($id)
    {
        return $this->serviceArticulo->deleteArticulo($id);
    }
    public function articulosConHomologacion()
    {
        return $this->repository->sqlFunction($this->constantesArticulos->sqlArticleByHomologation());
    }
    public function obtenerArticulosPrincipalesHomologacion()
    {

        return $this->serviceArticulo->articlesApprovals();
    }
}
