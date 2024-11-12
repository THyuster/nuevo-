<?php

namespace App\Http\Controllers\erp;

use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Http\Requests\Erp\ClientValidation;

use App\Utils\Constantes\Erp\SqlClient;
use App\Utils\TransfersData\Erp\Client;
use App\Http\Controllers\Controller;

class erp_clientesController extends Controller
{
    private $repositoryDynamicsCrud;
    private $sqlClient;
    private $client;

    public function __construct()
    {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->sqlClient = new SqlClient;
        $this->client = new Client;
    }

    public function index()
    {
        return view("superAdmin.grupo_empresarial.index");
    }


    public function create(ClientValidation $request)
    {
        return $this->client->create($request);
    }

    public function show()
    {
        return $this->repositoryDynamicsCrud->sqlFunction($this->sqlClient->getClientWithCompanie());
    }


    public function update(ClientValidation $request, string $id)
    {
        return $this->client->update($id, $request);
    }

    public function updateStatus(string $id)
    {
        return $this->client->statusUpdate($id);
    }
    public function destroy(string $id)
    {
        return $this->client->delete($id);
    }

    public function getGruposEmpresarialAndEmpresas()
    {
        $sql = "SELECT ere.cliente_id as grupo_empresarial_id, ere.empresa_id as empresa_id, ce.razon_social as name, ege.descripcion as grupo_empresarial, ce.ruta_imagen as logo FROM erp_relacion_empresas ere INNER JOIN contabilidad_empresas ce ON ce.id = ere.empresa_id 
INNER JOIN erp_grupo_empresarial ege ON ege.id = ere.cliente_id";
        $datos = $this->repositoryDynamicsCrud->sqlFunction($sql);
        $empresas = array();
        $datos = json_decode(json_encode($datos), true);

        foreach ($datos as $fila) {
            $grupo_empresarial_id = $fila['grupo_empresarial_id'];
            $grupo_empresarial = $fila['grupo_empresarial'];
            $empresa_id = $fila['empresa_id'];
            $name = $fila['name'];
            $logo = $fila['logo'];

            // Si es la primera vez que encontramos este grupo empresarial, lo inicializamos en el arreglo
            if (!isset($empresas[$grupo_empresarial_id])) {
                $empresas[$grupo_empresarial_id] = [
                    'grupo_empresarial_id' => $grupo_empresarial_id,
                    'grupo_empresarial' => $grupo_empresarial,
                    'empresas' => [],
                ];
            }

            // Agregamos la información de la empresa al grupo empresarial correspondiente
            $empresas[$grupo_empresarial_id]['empresas'][] = [
                'empresa_id' => $empresa_id,
                'name' => $name,
                'logo' => $logo
            ];
        }

        // Convertimos a JSON para el retorno de información
        $json_resultado = array_values($empresas);

        return response()->json($json_resultado,200,['Content-Type','application/json','Accept','application/json']);
    }

}