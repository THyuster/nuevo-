<?php

namespace App\Http\Controllers\modulo_contabilidad;

use App\Utils\TransfersData\moduloContabilidad\Third;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Http\Requests\modulo_contabilidad\ThirdValidation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Utils\FileManager;
use App\Utils\MyFunctions;
use App\Utils\Constantes\ModuloContabilidad\SqlThird;
use Illuminate\Support\Facades\Validator;

class contabilidad_tercerosController extends Controller
{
    protected $repositoryDinamyCrud;
    protected $nameDataBase;
    protected $third;
    protected $sqlThird;
    protected $fileManager;
    protected $myFunctions;

    public function __construct()
    {
        $this->repositoryDinamyCrud = new RepositoryDynamicsCrud;
        $this->nameDataBase = "contabilidad_terceros";
        $this->third = new Third;
        $this->sqlThird = new SqlThird;
        $this->fileManager = new FileManager;
        $this->myFunctions = new MyFunctions;
    }

    public function index()
    {
        $typesThirds = $this->repositoryDinamyCrud->sqlFunction("SELECT * FROM contabilidad_tipos_terceros");
        $municipalitys = $this->repositoryDinamyCrud->sqlFunction("SELECT * FROM contabilidad_municipios");
        $typesIdentifications = $this->repositoryDinamyCrud->sqlFunction("SELECT * FROM contabilidad_tipos_identificaciones");
        return view("modulo_contabilidad.terceros.indexw", compact('typesThirds', 'typesIdentifications', 'municipalitys'));
    }


    public function create(Request $request)
    {
        $rules = $this->rulesValidation($request);

        $validator = Validator::make($rules, [
            'required' => 'el campo :attribute es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->third->create($request);
    }

    public function GetTerceroByFilter(Request $request)
    {
        $filter = $request->input('filter');
        if (strlen($filter) < 4) {
            return [];
        }
        $sql = $this->sqlThird->getTercerosFilter($filter);
        $datos = $this->repositoryDinamyCrud->sqlFunction($sql);

        return json_encode($datos);
    }

    public function show()
    {

        $thirds =  $this->repositoryDinamyCrud->sqlFunction($this->sqlThird->getSqlThird());

        return $this->third->getThirds($thirds);
    }

    public function update(Request $request, $id)
    {
        return $this->third->update($id, $request);
    }


    public function destroy($id)
    {

        return $this->third->delete($id);
    }

    public function updateStatus($id)
    {

        return $this->third->updateStatus($id);
    }

    public function rulesValidation(Request $request)

    {
        $option = $request->input('naturaleza_juridica');
        if (strtoupper($option) == 'natural') {
            return [
                'apellido1' => 'required|string|max:20',
                'direccion' => 'nullable|string|max:300',
                'DV' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:320',
                'empresa' => 'nullable|string|max:250',
                'estado' => 'nullable|boolean',
                'fecha_nacimiento' => 'required|date',
                'grupo_sanguineo_id' => 'nullable|string|max:200',
                'identificacion' => 'required|string|max:20',
                'movil' => 'required|numeric|digits_between:1,10',
                'municipio' => 'required|numeric',
                'naturaleza_juridica' => 'required|string|max:30',
                'nombre_completo' => 'nullable|string|max:120',
                'nombre1' => 'required|string|max:20',
                'observacion' => 'nullable|string|max:300',
                'ruta_imagen' => 'nullable|string|max:300',
                'telefono_fijo' => 'nullable|numeric',
                'tipo_identificacion' => 'required|numeric',
            ];
        }
        return [
            'direccion' => 'required|string|max:300',
            'DV' => 'required|string|max:20',
            'email' => 'required|email|max:320',
            'empresa' => 'required|string|max:250',
            'estado' => 'nullable|boolean',
            'grupo_sanguineo_id' => 'nullable|string|max:200',
            'identificacion' => 'required|string|max:20',
            'movil' => 'nullable|numeric|digits_between:1,10',
            'municipio' => 'required|numeric',
            'naturaleza_juridica' => 'required|string|max:30',
            'nombre_completo' => 'nullable|string|max:120',
            'nombre1' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'observacion' => 'nullable|string|max:300',
            'ruta_imagen' => 'nullable|string|max:300',
            'telefono_fijo' => 'required|numeric',
            'tipo_identificacion' => 'required|numeric',
        ];
    }
}
