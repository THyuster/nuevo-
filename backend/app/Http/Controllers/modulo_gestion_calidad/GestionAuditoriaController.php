<?php

namespace App\Http\Controllers\modulo_gestion_calidad;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Utils\FileManager;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\moduloGestionCalidad\ServicioGestionCalidad;
use App\Utils\TypesAdministrators;
use App\Utils\TypesCharges;

class GestionAuditoriaController extends Controller
{
    protected $repositoryDynamicsCrud, $servicioGestionCalidad, $_fileManager;
    public function __construct(
        RepositoryDynamicsCrud $repositoryDynamicsCrud,
        ServicioGestionCalidad $servicioGestionCalidad,
        FileManager $fileManager
    ) {
        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->servicioGestionCalidad = $servicioGestionCalidad;
        $this->_fileManager = $fileManager;
    }
    public function show()
    {


        $userId = Auth::user()->id;
        $sql2 = "SELECT * FROM users WHERE id = $userId";
        $userTipoCargo = $this->repositoryDynamicsCrud->sqlFunction($sql2);

        if (
            $userTipoCargo[0]->tipo_administrador ==
            TypesAdministrators::COMPANY_ADMINISTRATOR
            || $userTipoCargo[0]->tipo_cargo == TypesCharges::QUALITY_AUDITOR_POSITION
        ) {
            $sql = "SELECT vgc.* FROM vgc";
        } else {
            $sql = "SELECT vgc.* from vgc WHERE vgc.nomina_centro_trabajo_id IN 
            (SELECT nomina_user_centros.centro_id FROM nomina_user_centros WHERE nomina_user_centros.user_id=$userId);
            ";
        }

        return $this->repositoryDynamicsCrud->sqlFunction($sql);
    }
    public function crear(Request $request)
    {
        return $this->servicioGestionCalidad->crearGestionCalidad($request);
    }
    public function update(Request $request, string $id)
    {
        return $this->servicioGestionCalidad->actualizarGestionCalidad($id, $request);
    }
    public function destroy(string $id)
    {
        return $this->servicioGestionCalidad->eliminarGestion($id);
    }
}
