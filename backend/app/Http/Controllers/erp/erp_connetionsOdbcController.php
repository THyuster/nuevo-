<?php

namespace App\Http\Controllers\erp;

use App\Http\Controllers\Controller;
use App\Utils\TransfersData\Erp\IServicesConexionesOdbc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class erp_connetionsOdbcController extends Controller
{


    private IServicesConexionesOdbc $_iServicesConexionesOdbc;


    public function __construct(IServicesConexionesOdbc $_iServicesConexionesOdbc)
    {
        $this->_iServicesConexionesOdbc = $_iServicesConexionesOdbc;
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [
            'required' => 'el campo :attribute es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $this->_iServicesConexionesOdbc->createConnectionOdbc($request->all());
    }



    public function show()
    {
        return $this->_iServicesConexionesOdbc->getConnectionOdbc();
    }

    public function show2()
    {
        return $this->_iServicesConexionesOdbc->getConnectionOdbc2();
    }
    public function showById(String $id)
    {
        return $this->_iServicesConexionesOdbc->findConnectionConexionOdbc($id);
    }


    public function update(Request $request, string $id)
    {
        return $this->_iServicesConexionesOdbc->updateConnectionOdbc($id, $request->all());
    }


    public function destroy(string $id)
    {
        return $this->_iServicesConexionesOdbc->deleteConnectionConexionOdbc($id);
    }
    private function getValidationRules()
    {
        return [
            '*' => 'prohibited',
            'dns' => 'required|string',
            'role' => 'required|string',
            'ruta' => 'required|string',
            'uid' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string',
            'codigo' => 'required|string',
            'descripcion' => 'required|string',
            'aaaa' => 'required|numeric',
            'aplicacion' => 'required|string',
        ];
    }
}
