<?php

namespace App\Utils\TransfersData\ModuloMantenimiento;

use App\Utils\Constantes\ModuloMantenimiento\CTecnicos;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\Admin;
use Exception;
use Illuminate\Http\Request;

class ServicesTecnicos implements IServicesTecnicos
{
    private CTecnicos $_cTecnicos;

    private RepositoryDynamicsCrud $_repository;
    private Admin $admin;

    private $nombreTabla = "mantenimiento_tecnicos", $date;

    public function __construct(RepositoryDynamicsCrud $repositoryDynamicsCrud, CTecnicos $cTecnicos, Admin $admin)
    {
        $this->_repository = $repositoryDynamicsCrud;
        $this->_cTecnicos = $cTecnicos;
        $this->admin = $admin;

        $this->date = date("Y-m-d H:i:s");
    }

    public function crearTecnicos(Request $request)
    {
        $data = $request->all();
        $usuario = $this->admin->findAdmin($request->input("userId"));

        $data['user_id'] = $usuario[0]->id;
        $sql = $this->_cTecnicos->sqlSelectByuserId($data['user_id']);

        $registro = $this->_repository->sqlFunction($sql);
        if ($registro) {
            throw new Exception("Tecnico ya registrado ", 400);
        }

        $data['created_at'] = $this->date;
        unset($data['userId']);
        return $this->_repository->createInfo($this->nombreTabla, $data);
    }

    public function eliminarTecnicos(string $id)
    {
        $entidadTecnicos = $this->_repository->sqlFunction($this->_cTecnicos->sqlSelectById($id));

        if (empty($entidadTecnicos)) {
            throw new Exception("id del cargo no encontrado", 400);
        }

        return $this->_repository->deleteInfoAllOrById($this->nombreTabla, $id);
    }
    public function getTecnicosAll()
    {
        return $this->_repository->sqlFunction($this->_cTecnicos->sqlSelectAll());
    }

    public function estadoTecnicos(int $id)
    {
        $entidadTecnicos = $this->_repository->sqlFunction($this->_cTecnicos->sqlSelectById($id));
        if (empty($entidadTecnicos)) {
            throw new \Exception("No se encontro encontrado", 400);
        }
        $estado = ($entidadTecnicos[0]->estado == 1) ? 0 : 1;
        $this->_repository->sqlFunction($this->_cTecnicos->sqlEstadoUpdate($id, $estado));
        return "Actualizado";
    }

    public function GetTecnicosSSR($filter)
    {
        $datos = $this->_repository->sqlFunction("SELECT * FROM users u INNER JOIN $this->nombreTabla mt ON mt.user_id = u.id WHERE email LIKE '$filter%' OR name LIKE '$filter%' ");

        $datos = json_decode(json_encode($datos), true);

        $data = array_map(function ($relacion) {
            return [
                'name' => $relacion["name"],
                'email' => $relacion["email"]
            ];
        }, $datos);

        return $data;
    }

    public function GetTecnicosSSRByIdOrden($id)
    {
        $datos = $this->_repository->sqlFunction($this->_cTecnicos->getTecnicosByOrdenId($id));
        //return $datos;
        $datos = json_decode(json_encode($datos),true);

        $data = array_map(function ($relacion) {
            return [
                'tecnico_id' => $relacion["email"],
                'tipo_orden_id' =>$relacion["tipo_orden_id"],
            ];
        }, $datos);

        return $datos;
    }
}
