<?php
namespace App\Utils\TransfersData\moduloGestionCalidad;

use App\Utils\Repository\RepositoryDynamicsCrud;

class ListaChequeo
{
    protected $repositoryDynamicsCrud, $nombreBaseDatos = "lista_chekeos";

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;

    }
    public function crearListaChequeo(array $nuevaLista)
    {
        $nuevaLista['estado'] = 1;
        return $this->repositoryDynamicsCrud->createInfo($this->nombreBaseDatos, $nuevaLista);
    }
    public function actualizarListaChequeo(int $id, array $listaActualizar)
    {
        $this->buscarLista($id);
        return $this->repositoryDynamicsCrud->updateInfo($this->nombreBaseDatos, $listaActualizar, $id);
    }

    public function eliminarListaChequeo(int $id)
    {
        $this->buscarLista($id);
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nombreBaseDatos, $id);
    }
    public function actualizarEstadoLista(int $id)
    {
        $reponse = $this->buscarLista($id);
        $nuevoEstado = array("estado" => !$reponse[0]->estado);
        return $this->repositoryDynamicsCrud->updateInfo($this->nombreBaseDatos, $nuevoEstado, $id);
    }
    public function buscarLista(int $id)
    {
        $lista = $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM lista_chekeos WHERE id = $id");
        if (!$lista) {
            throw new \Exception("Registro no entontrado");
        }
        return $lista;
    }
}
