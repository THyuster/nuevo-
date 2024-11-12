<?php

namespace App\Utils\TransfersData\ModuloSuperAdmin;

use App\Data\Dtos\UsuariosDto;
use App\Data\Models\UsuarioModel;
use App\Utils\AuthUser;
use App\Utils\Constantes\ModulosSuAdmin\CSuAdmin;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\MyFunctions;
use App\Utils\Repository\RepositoryDynamicsCrud;
use Exception;

class SuAdminService extends RepositoryDynamicsCrud implements ISuAdminService
{
    private CSuAdmin $_csuadmin;
    private AuthUser $_authUser;
    private MyFunctions $_myfunction;
    private EncryptionFunction $_encriptacion;

    public function __construct(CSuAdmin $cSuAdmin, AuthUser $authUser, MyFunctions $myFunction, EncryptionFunction $encryptionFunction)
    {
        $this->_csuadmin = $cSuAdmin;
        $this->_authUser = $authUser;
        $this->_myfunction = $myFunction;
        $this->_encriptacion = $encryptionFunction;
    }

    public function crearAdmin(UsuarioModel $SuperAdmin)
    {
        if (!MyFunctions::validar_superadmin()) {
            throw new Exception("No tienen permisos", 1);
        }

        $email = $SuperAdmin->getEmail();
        $userExists = $this->sqlFunction($this->_csuadmin->getUserEmail($email));

        if (!empty($userExists)) {
            throw new Exception("Correo ya registrado", 1);
        }

        $password = password_hash($SuperAdmin->getPassword(), PASSWORD_DEFAULT);

        $this->sqlFunction(
            $this->_csuadmin->crearSuAdmin(
                $SuperAdmin->getName(),
                $email,
                $password
            )
        );

        $usuario = $this->sqlFunction($this->_csuadmin->getUserEmail($email));

        $SuperAdmin->setId($usuario[0]->id);

        $this->sqlFunction($this->_csuadmin->createClaves($SuperAdmin->getId()));
        $this->sqlFunction($this->_csuadmin->activarModuloSu($SuperAdmin->getId()));

        return "Creo";
    }

    public function eliminarSuAdmin($id)
    {
        if (!MyFunctions::validar_superadmin()) {
            throw new Exception("No está autorizado", 1);
        }

        $id = $this->_encriptacion->Desencriptacion($id);
        $userLogged = $this->_authUser->getUsuariosLogin();

        if ($userLogged->getId() === intval($id)) {
            throw new Exception("No puede realizar esta acción", 1);
        }

        if (!MyFunctions::validar_superadminByID($id)) {
            throw new Exception("Este usuario no es super administrador", 1);
        }

        $this->eliminarDatosUsuarioSuperAdmin($id);

        return "elimino";
    }

    private function eliminarDatosUsuarioSuperAdmin($id)
    {
        $this->sqlFunction($this->_csuadmin->eliminarKey($id));
        $this->sqlFunction($this->_csuadmin->eliminarPermisos($id));
        $this->sqlFunction($this->_csuadmin->eliminarUserSu($id));
    }
    private function ModelResponse($status, $mensaje)
    {
        return json_decode(
            json_encode(
                [
                    "status" => $status,
                    "mensaje" => (is_string($mensaje)) ? strtoupper($mensaje) : $mensaje
                ]
            )
        );
    }
}
