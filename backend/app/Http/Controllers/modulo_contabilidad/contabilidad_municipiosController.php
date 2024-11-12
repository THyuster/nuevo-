<?php

namespace App\Http\Controllers\modulo_contabilidad;
use App\Models\modulo_contabilidad\contabilidad_municipios;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\modulo_contabilidad\MunicipalityValidation;
use Illuminate\Http\Request;
use App\Utils\TransfersData\moduloContabilidad\MunicipalityData;
use  App\Utils\Constantes\ModuloContabilidad\SqlMunicipality;

class contabilidad_municipiosController extends Controller
{
    protected $repositoryDynamicsCrud;
    protected $nameDataBase;
    protected $municipalityData;
    protected $sqlMunicipality;
    public function __construct() {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase= "contabilidad_municipios";
        $this->municipalityData= new MunicipalityData;
        $this->sqlMunicipality= new SqlMunicipality;

    }   
    public function index()
    {
        $departaments = $this->repositoryDynamicsCrud->getInfoAllOrById('contabilidad_departamentos', [], '*');
        $municipalities = $this->repositoryDynamicsCrud->sqlFunction($this->sqlMunicipality->getSqlMunicipalityByDepartment());
            return view("modulo_contabilidad.municipios.index", compact('departaments','municipalities') );
    
    }

    
    public function show(Request $request){
        if (!auth()->user()) {
            $empresaId = $request->input('empId', null);

            if (!$empresaId) {
                return [];
            }

            $connection = $this->repositoryDynamicsCrud->getConnectioByIdEmpresa($empresaId);

            if (!$connection) {
                return [];
            }

            $contabilidadMunicipios = contabilidad_municipios::on($connection)->get()->toArray();

            return $contabilidadMunicipios;
        }
        return $this->repositoryDynamicsCrud->sqlFunction($this->sqlMunicipality->getSqlMunicipalityByDepartment());
    }
    
    public function create(MunicipalityValidation $request)
    {
        return $this->municipalityData->create($request->all());
    }



    public function update(Request $request, $id)
    {
        return $this->municipalityData->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->municipalityData->delete($id);
    }

   public function municipality() {
        $sql = "SELECT * FROM contabilidad_municipios";
        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
}

    //     $departaments = $this->repositoryDynamicsCrud->getInfoAllOrById('contabilidad_departamentos', [], '*');
         
    //     return view("modulo_contabilidad.municipios.index", compact('municipalitys', 'departaments'));
    