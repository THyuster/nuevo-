<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Erp\UserValidation;
use App\Utils\CatchToken;
use App\Utils\Constantes\Erp\SqlUsers;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\AdminUser;
use App\Utils\TransfersData\Erp\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class erp_tipoEntidadController extends Controller
{

    private RepositoryDynamicsCrud $repositoryDynamicsCrud;



    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;

    }



    public function show()
    {

        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM erp_tipos_entidades");
    }


}