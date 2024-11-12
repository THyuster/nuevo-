<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\ConsultasMigraciones;
use App\Utils\Constantes\constantConsultations;
use App\Utils\MyFunctions;

class erp_migracionesController extends Controller
{

    protected $constanteSql;
    protected $myFunctions;
    protected $Migraciones;
    protected $DynamicsCrud;

    public function __construct()
    {
        $this->myFunctions = new Myfunctions;
        $this->constanteSql = new constantConsultations;
        $this->Migraciones = new consultasMigraciones;
        $this->DynamicsCrud = new RepositoryDynamicsCrud;
    }

    public function index()
    {
        $dataMigraciones = $this->DynamicsCrud->sqlFunction($this->constanteSql->getMigraciones());

        return view('modulo_configuracion.erp_migraciones.index', compact('dataMigraciones'));
    }

    public function create(Request $request)
    {
        return $this->Migraciones->create($request->all());
    }

    public function edit($id, Request $request)
    {
        if ($this->myFunctions->checkAdmin() == false) {
            return 'no tiene permisos';
        }
        return $this->Migraciones->edit($id, $request->all());
    }

    public function destroy($id)
    {
        return  $this->Migraciones->delete($id);
    }

    public function status($id)
    {
        return  $this->Migraciones->status($id);
    }
}
