<?php

namespace App\Http\Controllers\modulo_contabilidad;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\modulo_contabilidad\PeriodValidation;
use App\Utils\Constantes\ModuloContabilidad\SqlPeriod;
use App\Utils\TransfersData\moduloContabilidad\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class contabilidad_periodosController extends Controller
{
    protected Period $_period;
    protected SqlPeriod $_sqlPeriod;
    protected RepositoryDynamicsCrud $_repositoryDynamicsCrud;
    private $nameDataBase = "contabilidad_periodos";
    public function __construct(Period $period, RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        
        $this->_sqlPeriod = new SqlPeriod;
        $this->_period = $period;
        $this->_repositoryDynamicsCrud = $repositoryDynamicsCrud;
    }
    public function index()
    {
        $fiscalYear = $this->_repositoryDynamicsCrud->sqlFunction("SELECT * FROM contabilidad_afiscals");
        $periods = $this->_repositoryDynamicsCrud->sqlFunction("SELECT * FROM $this->nameDataBase");
        return view("modulo_contabilidad.periodos.index", compact('periods', 'fiscalYear'));
    }

    public function create(PeriodValidation $request)
    {
        return $this->_period->create($request->all());
    }


    public function show()
    {
        return $this->_repositoryDynamicsCrud->sqlFunction($this->_sqlPeriod->findPeriodForFiscalYear());
    }

    public function update(Request $request, string $id)
    {
        return $this->_period->update($id, $request->all());
    }


    public function destroy(string $id)
    {
        return $this->_period->delete($id);
    }
    public function updateStatus(string $id)
    {
        return $this->_period->updateStatus($id);
    }

    public function replicateYear (Request $request){
        $rules = [
            'lastYear' => 'required|numeric',
            'yearNew' => 'required|numeric',
        ];

        $messages = [
            'lastYear.required' => 'El campo lastYear es obligatorio.',
            'lastYear.numeric' => 'El campo lastYear debe ser numérico.',
            
            'yearNew.required' => 'El campo año nuevo es obligatorio.',
            'yearNew.numeric' => 'El campo yearNew debe ser numérico.',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->_period->replicateYearByYear($request);
        
    }

    public function filterPeriodsByYear($id){
        return $this->_period->getPeriodsByYear($id);
    }
}