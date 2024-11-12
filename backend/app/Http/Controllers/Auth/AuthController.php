<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\registeruser;
use App\Models\User as userModel;
use App\Models\usuario_confirmacion_empresa;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\ResponseHandler;
use App\Utils\ValidarLogin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\Encryption\EncryptionFunction;
use Exception;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private EncryptionFunction $_encryptionFunction;
    private RepositoryDynamicsCrud $_respository;

    public function __construct(EncryptionFunction $encryptionFunction, RepositoryDynamicsCrud $repositoryDynamicsCrud)
    {
        $this->_encryptionFunction = $encryptionFunction;
        $this->_respository = $repositoryDynamicsCrud;
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ], __('messages.validation'));

        try {
            
        if (Auth::attempt($credentials)) {

            $usuario = Auth::user();

            if ($usuario->estado == "INACTIVO") {
                return response(["message" => __('messages.inactiveUserMessage')], Response::HTTP_UNAUTHORIZED);
            }

            // if ($usuario->tipo_administrador == 2) {
            //     return response(["message" => __('messages.unacceptedUserMessage')], Response::HTTP_UNAUTHORIZED);
            // }

            $customClaims = [
                'id_usuario' => $this->_encryptionFunction->Encriptacion($usuario->id),
                'tipo_usuario' => $usuario->tipo_administrador,
                'nombre_usuario' => $usuario->name,
                'correo' => $usuario->email,
                'tipo_cargo' => $usuario->tipo_cargo

            ];

            if ($usuario->tipo_administrador == 1) {
                $id = $this->_encryptionFunction->Desencriptacion($customClaims['id_usuario']);

                $data = $this->_respository->sqlFunction("SELECT * FROM erp_relacion_user_cliente WHERE user_id = '$id'");
                if (empty($data)) {
                    return response(["message" => __('messages.unacceptedUserMessage')], Response::HTTP_UNAUTHORIZED);
                }
                $customClaims['id_cliente'] = $data[0]->cliente_id;
            }

            $token = JWTAuth::claims($customClaims)->fromUser($usuario);

            switch (ValidarLogin::verificarSesion($usuario->id)) {
                case 0:
                    ValidarLogin::actualizarSesion($usuario->id, $token, 1);
                    break;
                case 1:
                    ValidarLogin::actualizarSesion($usuario->id, $token, 1);
                    break;
                case "NS":
                    ValidarLogin::registrarSesion($usuario->id, $token);
                    break;
            }

            return response(["token" => $token], Response::HTTP_OK);
        }

        return response(["message" => __('messages.invalidCredentialsMessage')], Response::HTTP_UNAUTHORIZED);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function logout()
    {
        $usuario = Auth::user();
        auth("api")->logout();
        ValidarLogin::actualizarSesion($usuario->id, null, 0);
        return true;
    }

    public function SessionActive(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $user = Auth::user();
            return (ValidarLogin::verificarToken($token, $user->id)) ? 1 : 0;
        }
        return 0;
    }

    public function LoginEmpresa($id)
    {
        $usuario = Auth::user();

        $idUsuario = $usuario->id;

        $sql = "SELECT * FROM erp_relacion_user_empresas WHERE user_id = '$idUsuario' AND empresa_id = '$id'";
        $data = $this->_respository->sqlFunction($sql, 2);

        if (empty($data)) {
            throw new Exception(__('messages.unacceptedUserMessage'), Response::HTTP_UNAUTHORIZED);
        }

        $sql = "SELECT ruta_imagen FROM contabilidad_empresas WHERE id = '$id'";
        $imagen = $this->_respository->sqlFunction($sql, 2);

        $imagen = !empty($imagen) ? $imagen[0]->ruta_imagen : null;

        $customClaims = [
            'id_usuario' => $this->_encryptionFunction->Encriptacion($idUsuario),
            'tipo_usuario' => $usuario->tipo_administrador,
            'nombre_usuario' => $usuario->name,
            'id_empresa' => $this->_encryptionFunction->Encriptacion($id),
            'correo' => $usuario->email,
        ];

        $token = JWTAuth::claims($customClaims)->fromUser($usuario);
        $imagen_con_token = $this->obtener_imagen_con_token($imagen, $token);

        ValidarLogin::actualizarSesion($usuario->id, $token, 1);

        return response($imagen_con_token, Response::HTTP_OK);
    }

    public function register(registeruser $request)
    {
        $responseHandler = new ResponseHandler();

        $password_confirmation = $request->input('password_confirmation');
        $password = $request->input('password');

        if ($password_confirmation != $password) {
            $responseHandler->setMessage("Contraseña no coincide");
            $responseHandler->setData($request->all());
            $responseHandler->setStatus(Response::HTTP_BAD_REQUEST);
            return $responseHandler->responses();
        }

        $user = new userModel();
        $user = $user->setConnection('app')->where("email", $request->input("email"))->first();

        if ($user) {
            $responseHandler->setMessage("Correo ya Registrado");
            $responseHandler->setStatus(Response::HTTP_CONFLICT);
            $responseHandler->setData($user);
            return $responseHandler->responses();
        }

        $nuevoUsuario = new userModel();


        $nuevoUsuario->name = $request->input("name");
        $nuevoUsuario->email = $request->input("email");
        $nuevoUsuario->password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $nuevoUsuario->setConnection('app')->save();
        } catch (Throwable $error) {
            $responseHandler->setMessage('Problema al crear Usuario');
            $responseHandler->setData($error->getMessage());
            $responseHandler->setStatus(Response::HTTP_BAD_REQUEST);
            return $responseHandler->responses();
        }

        $responseHandler->setMessage(["Usuario Creado Exitosamente"]);
        $responseHandler->setData($nuevoUsuario);
        $responseHandler->setStatus(Response::HTTP_OK);

        $usuarioConfirmacion = new usuario_confirmacion_empresa();

        $usuarioConfirmacion->grupo_empresarial_id = $request->input("grupoEmpresarialId");
        $usuarioConfirmacion->user_id = $nuevoUsuario->id;

        $usuarioConfirmacion->save();

        return $responseHandler->responses();

    }

    public function getRolesUser()
    {
        try {
            //code...
            $usuario = Auth::user();
            $user_id = $usuario->id;
            $response = $this->_respository->sqlFunction("SELECT * FROM erp_roles_view WHERE user_id ='$user_id' ");
            $response = new ResponseHandler("Datos Traidos", $response, Response::HTTP_OK);
            return $response->responses();
        } catch (Throwable $th) {
            $response = new ResponseHandler($th->getMessage(), $response, Response::HTTP_INTERNAL_SERVER_ERROR);
            return $response->responses();
        } catch (QueryException $e) {
            $response = new ResponseHandler($e->getMessage(), $response, Response::HTTP_INTERNAL_SERVER_ERROR);
            return $response->responses();
        } catch (Exception $exception) {
            $response = new ResponseHandler($exception->getMessage(), $response, Response::HTTP_BAD_REQUEST);
            return $response->responses();
        }
    }

    private function obtener_imagen_con_token($url, $token)
    {
       try {
        $url_imagen = $url;
        
        try {
            $imagen_contenido = file_get_contents($url_imagen);
            $imagen_base64 = base64_encode($imagen_contenido);
        } catch (Throwable $th) {
            $imagen_base64 = null;
        }

        return [
            'token' => $token,
            'imagen_base64' => $imagen_base64,
        ];
       } catch (\Throwable $th) {
        return [
            'token' => $token,
            'imagen_base64' => "",
        ];
       }
    }
}
