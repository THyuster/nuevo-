<?php

namespace App\Utils\Constantes\Erp;

use App\Utils\Constantes\DB\tablas;

class sqlConexionesOdbc
{
    private String $_tableDb;

    public function __construct()
    {
        $this->_tableDb = tablas::getTablaAppConexionesOdbc();
    }

    public function sqlGetConnections()
    {
        return "SELECT * FROM $this->_tableDb";
    }
    public function sqlGetConnectionsById($id)
    {
        return "SELECT *, dns as dsn FROM $this->_tableDb WHERE conexiones_odbc_id = $id";
    }
}