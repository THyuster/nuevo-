<?php

namespace App\Utils\TransfersData\Erp;

use App\Data\Dtos\Datatable\DatatableResponseDTO;
use App\Models\erp\conexiones_odbc;
use App\Utils\CatchToken;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Constantes\Erp\sqlConexionesOdbc;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class ServicesConexionesOdbc extends RepositoryDynamicsCrud implements IServicesConexionesOdbc
{


    private RepositoryDynamicsCrud $_repository;
    private String $_tableDb;
    private $sqlConexionesOdbc, $catchToken;


    public function __construct()
    {
        $this->_repository = new RepositoryDynamicsCrud;

        $this->catchToken = new CatchToken;

        $this->sqlConexionesOdbc = new sqlConexionesOdbc;

        $this->_tableDb = tablas::getTablaAppConexionesOdbc();
        // $this->_tablaConexiones_odbc = tablas::getTablaAppConexionesOdbc();
    }

    public function getConnectionOdbc()
    {

        // $connection = RepositoryDynamicsCrud::findConectionDB();
        $nominaSeccion = new conexiones_odbc();
        $nominaSeccionQuery = conexiones_odbc::on();

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

    public function getConnectionOdbc2()
    {
        $sql = "SELECT * FROM conexiones_odbc";
        return $this->_repository->sqlFunction($sql);
    }

    public function findConnectionConexionOdbc(string $id)
    {

        $sql = $this->sqlConexionesOdbc->sqlGetConnectionsById($id);
        return $this->_repository->sqlFunction($sql);
    }

    public function createConnectionOdbc(array $nuevaConexionOdbc)
    {
        $nuevaConexionOdbc["empresa_id"] = $this->catchToken->Claims();
        return $this->_repository->createInfo($this->_tableDb, $nuevaConexionOdbc);
    }

    public function updateConnectionOdbc(String $id, array $actualizarConexionOdbc)
    {


        $consultaSet = '';
        foreach ($actualizarConexionOdbc as $atributo => $valor) {
            if ($valor != null) {
                $consultaSet .= (is_string($valor)) ? "`$atributo`= '$valor', " : "`$atributo`= ('$valor'), ";
            }
        }
        $consultaSet = rtrim($consultaSet, ', ');

        $sql = "UPDATE $this->_tableDb SET $consultaSet WHERE conexiones_odbc_id = '$id'";

        return $this->_repository->sqlFunction($sql);
    }

    public function deleteConnectionConexionOdbc(string $id)
    {
        $sql = "DELETE FROM conexiones_odbc WHERE conexiones_odbc_id = '$id'";
        $this->_repository->sqlFunction($sql);
        return true;
        // return $this->_repository->deleteInfoAllOrById($this->_tableDb, $id);
    }
    private function searchOdbc()
    {
        $campos = [
            "conexiones_odbc_id",
            "dns",
            "ruta",
            "uid",
            "password",
            "role",
            "empresa_id",
            "codigo",
            "descripcion",
            "aaaa",
            "aplicacion"
        ];
        $query = $this->sqlSSR("conexiones_odbc", $campos);
        return $query;
    }
}
