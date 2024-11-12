<?php

namespace App\Utils;

use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;

class DBServerSide
{

    protected $tabla;
    protected array $campos;
    protected Request $request;
    protected $columns;
    protected $totalRecords;
    protected $filterRecords;
    protected $respository;
    protected $draw;

    public function __construct(string $tabla = '', Request $request, $campos = [])
    {
        $this->tabla = $tabla;
        $this->request = HttpRequest::capture();
        $this->campos = $campos;
        $this->respository = new RepositoryDynamicsCrud();
    }

    public function setTable()
    {
        // $request = ;
        $query = $this->respository->sqlSSR($this->tabla, $this->campos);

        $this->setTotalRecords($query->count());

        $this->setDraw(intval($this->request->input('draw', 1)));

        if ($this->request->has('search') && $this->request->input('search.value')) {
            $searchValue = $this->request->input('search.value');
            $campos = $this->campos;
            $query->where(function ($q) use ($searchValue, $campos) {
                $q->orWhere($campos, 'LIKE', "%$searchValue%");
            });
        }

        $columnFilters = $this->request->input('columnFilters', []);
        $columnsFilters = $this->request->input('columns', []);
      
        foreach ($columnFilters as $index => $filter) {
            if (!empty($filter) && isset($columns[$index])) {
                $query->where($columnsFilters[$index]["data"], 'like', "%$filter%");
            }
        }

        $this->setFilterRecords($query->count());

        $this->columms($this->campos);

        if ($this->request->has('order')) {
            # code...
            foreach ($this->request->input('order') as $order) {
                $columnIndex = $order['column'];
                $columnName = $this->columns[$columnIndex]['db'];
                $direction = $order['dir'];
                $query->orderBy($columnName, $direction);
            }
        }

        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);

        if ($length != -1) {
            $query->offset($start)->limit($length);
        }

        return $query;
    }

    public function getTabla($query)
    {
        return [
            "draw" => $this->getDraw(),
            "recordsTotal" => $this->getTotalRecords(),
            "recordsFiltered" => $this->getFilterRecords(),
            "data" => $query->toArray(),
        ];
    }

    protected function columms($campos)
    {
        $columns = [];

        for ($i = 0; $i < sizeof($campos); $i++) {
            $columns[] = ['db' => $campos[$i], 'dt' => $i];
        }

        $this->setColumns($columns);
    }

    protected function setColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    protected function setFilterRecords($filterRecords)
    {
        $this->filterRecords = $filterRecords;

        return $this;
    }

    protected function setTotalRecords($totalRecords)
    {
        $this->totalRecords = $totalRecords;

        return $this;
    }

    protected function getTotalRecords()
    {
        return $this->totalRecords;
    }

    protected function getFilterRecords()
    {
        return $this->filterRecords;
    }

    protected function getDraw()
    {
        return $this->draw;
    }

    protected function setDraw($draw)
    {
        $this->draw = $draw;

        return $this;
    }
}
