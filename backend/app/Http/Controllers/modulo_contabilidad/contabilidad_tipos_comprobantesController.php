<?php

namespace App\Http\Controllers\modulo_contabilidad;
use  App\Http\Requests\modulo_contabilidad\ReceiptValidation;

use App\Utils\TransfersData\moduloContabilidad\Receipt;
use App\Http\Controllers\Controller;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Illuminate\Http\Request;

class contabilidad_tipos_comprobantesController extends Controller
{
    protected $receipt;
    protected $repositoryDynamicsCrud;
    protected $nameDataBase;

    public function __construct()
    {
        $this->receipt = new Receipt;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_tipos_comprobantes";
    }

    public function index()
    {
        return view("modulo_contabilidad.tipos_comprobantes.index");
    }

    public function create(ReceiptValidation $request)
    {
        return $this->receipt->create($request->all());
    }


    public function show()
    {
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->nameDataBase ");
    }


    public function update(Request $request, string $id)
    {
        
        return $this->receipt->update($id, $request->all());
    }


    public function destroy(string $id)
    {
    
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nameDataBase, $id);
    }

    public function updateStatus( string $id){
        return $this->receipt->updateStatus($id);
    }
    public function updateSign( string $id){
        return $this->receipt->updateSign($id);
    }
}
