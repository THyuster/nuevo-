<?php

namespace App\Http\Controllers\modulo_contabilidad;
use App\Http\Requests\modulo_contabilidad\FiscalYearValidation;
use App\Utils\TransfersData\moduloContabilidad\FiscalYear;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Http\Controllers\Controller;
use App\Utils\Constantes\ModuloContabilidad\SqlFiscalYear;
use Illuminate\Http\Request;
 
class contabilidad_afiscalController extends Controller
{   
    protected $fiscalYear;
    protected $repositoryDynamicsCrud;
    protected $nameDataBase;
    protected $sqlFiscalYear;

    public function __construct() {
        $this->fiscalYear = new FiscalYear;
        $this->sqlFiscalYear = new SqlFiscalYear;
        $this->repositoryDynamicsCrud= new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_afiscals";
        
    }
    public function index()
    {
        $companies = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM contabilidad_empresas");
        return view("modulo_contabilidad.afiscal.index", compact('companies'));
    }

    
    public function create(FiscalYearValidation $request)
    {
        return $this->fiscalYear->create($request->all());
    }
 
    public function show()
    {
        return $this->repositoryDynamicsCrud->sqlFunction($this->sqlFiscalYear->findFiscalYearRelationsCompanie());
    }

   
    public function update(Request $request, string $id)
    {
      
        return $this->fiscalYear->update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return $this->fiscalYear->delete($id);
    }

    public function updateStatus(string $id){
        return $this->fiscalYear->updateStatus($id);
    }
}
