<?php

namespace App\Utils\TransfersData\moduloGestionCalidad;

use App\Utils\AuthUser;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\FileManager;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TypesAdministrators;
use App\Utils\TypesCharges;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioGestionCalidad
{
    protected $repositoryDynamicsCrud, $nombreTabla, $fileManager, $myFunctions, $_fileManager;

    public function __construct(
        RepositoryDynamicsCrud $repositoryDynamicsCrud,
        FileManager $fileManager,
        MyFunctions $myFunctions,
    ) {

        $this->repositoryDynamicsCrud = $repositoryDynamicsCrud;
        $this->fileManager = $fileManager;
        $this->nombreTabla = "gestion_calidad";
        $this->_fileManager = $fileManager;
    }

    public function crearGestionCalidad($request)
    {

        try {

            $user =  Auth::user();
            if (!($user->tipo_cargo == TypesCharges::QUALITY_AUDITOR_POSITION || $user->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR)) {
                throw new Exception("No tiene permisos");
            }
            $campos = $request->all();

            $campos["users_id"] = EncryptionFunction::StaticDesencriptacion($request["users_id"]);
            $campos["estado_id"] = "1";
            $uuid = uuid_create();
            $campos["codigo"] = $uuid;

            $responseImgPdf = $this->returnStringImageAndPdf($request);
            $campos['image'] = $responseImgPdf['image'];
            $campos['pdf'] = $responseImgPdf['pdf'];

            return  $this->repositoryDynamicsCrud->createInfo($this->nombreTabla, $campos);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function actualizarGestionCalidad(int $id, $request)
    {
        try {
            $user =  Auth::user();
            if (!($user->tipo_cargo == TypesCharges::QUALITY_AUDITOR_POSITION || $user->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR)) {
                throw new Exception("No tiene permisos");
            }
            $campos = $request->all();

            $this->validateDirectorOrAuditor();
            $auditoriaEncontrada = $this->buscarPorId($id);

            $this->buscarNominaCentroTrabajo($campos['nomina_centro_trabajo_id']);
            $this->buscarTipoSolicitud($campos['tipo_solicitud_id']);
            $this->buscarEstado($campos['estado_id']);

            $pathImagen = $auditoriaEncontrada[0]->image;

            $responseImgPdf = $this->returnStringImageAndPdf($request, $pathImagen);
            $campos['image'] = $responseImgPdf['image'];
            $campos['pdf'] = $responseImgPdf['pdf'];


            return $this->repositoryDynamicsCrud->updateInfo($this->nombreTabla, $campos, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function eliminarGestion(int $id)
    {

        try {

            $auditoriaEncontrada = $this->buscarPorId($id);

            if (Auth::user()->tipo_administrador == TypesAdministrators::COMPANY_ADMINISTRATOR) {
                return $this->eliminarGestionValidada($id, $auditoriaEncontrada);
            }

            $this->validateCreateOrDelete(TypesCharges::QUALITY_AUDITOR_POSITION);
            $usuarioLoggged = AuthUser::getUsuariosLogin();

            if (($usuarioLoggged->getId() == $auditoriaEncontrada[0]->users_id) ||  Auth::user()->tipo_cargo == 7) {
                return   $this->eliminarGestionValidada($id, $auditoriaEncontrada);
            }
            throw new Exception("No puede eliminar este registro", 1);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function returnStringImageAndPdf(Request $request, $pathImagenDelete = null)
    {
        if ($request->hasFile("image")) {
            if ($pathImagenDelete) {
                $this->fileManager->deleteImage($pathImagenDelete);
            }
            $newImagePath = $this->_fileManager->pushImagen($request, "gestion_auditoria", "image");
            if ($newImagePath === "No se encontro imagen" || $newImagePath === "No es una imagen valida") {
                throw new Exception("Imagen no valida");
            }
            $campos['image'] = $newImagePath;
        } else {
            $campos['image'] = "";
        }

        if ($request->hasFile("pdf")) {
            $newPdfPath = $this->_fileManager->pushPDF($request, "gestion_auditoria", "pdf");
            if ($newPdfPath === "No se encontro el pdf" || $newPdfPath === "el pdf no es valido") {
                throw new Exception("Pdf no valido");
            }
            $campos['pdf'] = $newPdfPath;
        } else {
            $campos['pdf'] = "";
        }
        return ['image' => $campos['image'], 'pdf' => $campos['pdf']];
    }
    public function buscarPorId(int $id)
    {
        $sql = "SELECT * FROM gestion_calidad WHERE id = $id";
        return $this->findRegistro($sql, "Auditoria no encontrada", 404);
    }

    private function buscarTipoSolicitud($id)
    {

        $sql = "SELECT id FROM tipos_solicitud WHERE id = $id";
        return $this->findRegistro($sql, "Tipo de solicitud no encontrada", 404);
    }
    private function buscarEstado($id)
    {

        $sql = "SELECT id FROM estados WHERE id = $id";
        return $this->findRegistro($sql, "Tipo de solicitud no encontrada", 404);
    }
    private function buscarNominaCentroTrabajo($id)
    {

        $sql = "SELECT id FROM nomina_centros_trabajos WHERE id = $id";
        return $this->findRegistro($sql, "Centro de trabajo no encontrado", 404);
    }

    private function findRegistro($sql, $messageError, $status)
    {
        $response = $this->repositoryDynamicsCrud->sqlFunction($sql);
        if (!$response) {
            throw new \Exception($messageError, $status);
        }
        return $response;
    }

    private function validateCreateOrDelete($codigoCargo)
    {

        $response =   $this->getUser();
        if ($response[0]->tipo_cargo != $codigoCargo) {
            throw new \Exception("No tiene permisos asignados", 1);
        }
    }

    private function  validateDirectorOrAuditor()
    {


        $cargoUsuario = $this->getUser();
        if ($cargoUsuario[0]->tipo_cargo != 7 && $cargoUsuario[0]->tipo_cargo != 3) {
            throw new \Exception("No tiene permisos asignados solo el auditor de calidad y el director de UPM pueden actualizar", 1);
        }
    }

    private function getUser()
    {
        $userId = Auth::user()->id;
        $sql2 = "SELECT * FROM users WHERE id = $userId";
        return  $this->findRegistro($sql2, "Usuario no encontrado", 404);
    }

    private function eliminarGestionValidada($id, $auditoriaEncontrada)
    {
        $pathImagen = $auditoriaEncontrada[0]->image;
        if ($pathImagen) {
            $this->fileManager->deleteImage($pathImagen);
        }
        return $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->nombreTabla, $id);
    }
}
