<?php

namespace App\Data\Dtos\Datatable;

class DatatableResponseDTO
{
    public int $draw;
    public $data;
    public int $recordsTotal;
    public int $recordsFiltered;

    public function __construct(array $params = [])
    {
        $this->draw = $params['draw'] ?? 0;
        $this->recordsTotal = $params['recordsTotal'] ?? 0;
        $this->recordsFiltered = $params['recordsFiltered'] ?? 0;
        $this->data = $params['data'] ?? [];
    }
}
