<?php

namespace App\Http\Controllers\modulo_gestion_calidad;

use App\Http\Controllers\Controller;
use App\Http\Requests\qualityManagement\ValidarListaChequeo;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\moduloGestionCalidad\ListaChequeo;
use Illuminate\Http\Request;

class ListaChequeoController extends Controller
{
    protected $repositoryDynamicsCrud, $listaChequeo;
    public function __construct(
        RepositoryDynamicsCrud $repositoryDynamicsCrud,
        ListaChequeo $listaChequeo
    ) {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->listaChequeo = $listaChequeo;
    }

    public function create(ValidarListaChequeo $request)
    {
        return $this->listaChequeo->crearListaChequeo($request->all());
    }
    public function update(int $id, ValidarListaChequeo $request)
    {
        return $this->listaChequeo->actualizarListaChequeo($id, $request->all());
    }
    public function destroy(int $id)
    {
        return $this->listaChequeo->eliminarListaChequeo($id);
    }
    public function show()
    {
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM lista_chekeos");
    }
    public function actualizarEstado(int $id)
    {
        return $this->listaChequeo->actualizarEstadoLista($id);
    }
}
