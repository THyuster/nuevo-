<?php

namespace App\Utils;

use App\Utils\Constantes\Constantes;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use App\Utils\Repository\RepositoryDynamicsCrud;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MyFunctions extends RepositoryDynamicsCrud
{
    protected $repository, $repositoryDynamicsCrud, $_constantes, $sqlCompanies, $catchToken;
    public function __construct()
    {
        $this->repository = new RepositoryDynamicsCrud;
        $this->_constantes = new Constantes;
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->sqlCompanies = new SqlCompanies;
        $this->catchToken = new CatchToken;
    }


    public function obtenerEstados()
    {
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM estados");
    }
    public function obtenerPrioridades()
    {
        return $this->repositoryDynamicsCrud->sqlFunction("SELECT * FROM prioridades");
    }
    /**
     * Normaliza una cadena de texto para usarla como nombre de carpeta.
     *
     * @param string $text La cadena de texto a normalizar.
     * @return string La cadena normalizada.
     */
    public static function normalizeFolderName($text)
    {
        // Convertir a minúsculas
        $text = strtolower($text);
        // Reemplazar caracteres especiales por guion bajo
        $text = preg_replace('/[^a-z0-9]+/', '_', $text);
        // Eliminar guiones bajos al principio o final
        $text = trim($text, '_');
        return $text;
    }
    /**
     *
     * Este método establece el estado del objeto actual en función del valor de la propiedad `estado` del objeto `postulante`.
     * Se utilizan los siguientes valores para determinar el estado:
     * - `null` se asigna como 'Nuevo'
     * - `1` se asigna como 'Aprobado'
     * - Cualquier otro valor se asigna como 'Rechazado'
     *
     * @param object $postulante El objeto postulante que contiene la propiedad `estado`.
     */
    public static function obtenerEstado($estado)
    {
        $estados = [
            null => 'Nuevo',
            1 => 'Aprobado',
        ];

        return $estados[$estado] ?? 'Rechazado';
    }
    /**
     * Concatenar y limpiar una lista de strings, manejando valores nulos.
     *
     * @param array<string> $componentes Lista de datos en string.
     * @return string retorna el string concatenado y limpio.
     */
    public static function concatenarYLimpiar(array $componentes): string
    {
        return trim(implode(' ', array_filter($componentes, function ($valor) {
            return !is_null($valor) && $valor !== '';
        })));
    }


    public static function calcularEdad($fechaNacimiento)
    {
        if (!$fechaNacimiento) {
            return null;
        }

        // Crear un objeto DateTime con la fecha de nacimiento
        $fechaNacimiento = new DateTime($fechaNacimiento);

        // Obtener la fecha actual
        $fechaActual = new DateTime();

        // Calcular la diferencia de años
        $edad = $fechaNacimiento->diff($fechaActual)->y;

        return $edad;
    }

    public static function toStringSexo($sexo)
    {
        if (!$sexo) {
            return null;
        }
        return $sexo ? "Masculino" : "Femenino";
    }

    public static function validar_activo()
    {
        $user = Auth::user();

        if (Auth::check()) {
            return ($user->estado !== "ACTIVO") ? "NO" : "SI";
        }
        throw new Exception("Usuario no autenticado", 1);
    }
    public static function validar_administrador()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return ($user->tipo_administrador == 1 && $user->administrador == 'SI' && $user->estado == "ACTIVO") ? "SI" : "NO";
        }
        throw new Exception("Usuario no autenticado", 1);
    }

    public static function validar_superadmin()
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        $key = DB::connection("app")->table('key_su_administrador')->where('id_user', $user->id)->value('key_su_admin');
        // echo $key;
        if (Auth::check() && password_verify(Constantes::getSecretKeyEncrypt(), $key)) {
            if ($user->tipo_administrador === 2 && $user->estado === "ACTIVO") {
                // echo "aqui";
                return true;
            }
        }
        return false;
    }

    public static function validar_superadminByID($id)
    {
        $tipo_administrador = DB::connection("app")->table('users')->where('id', $id)->value('tipo_administrador');

        $estado = DB::connection("app")->table('users')->where('id', $id)->value('estado');

        $key = DB::connection("app")->table('key_su_administrador')->where('id_user', $id)->value('key_su_admin');

        if (Auth::check() && password_verify(Constantes::getSecretKeyEncrypt(), $key)) {
            if ($tipo_administrador === 2 && $estado === "ACTIVO") {
                return true;
            }
        }
        return false;
    }

    public function checkAdmin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return ($user->administrador == "SI" && $user->estado == "ACTIVO") ? true : false;
        }
        return null;
    }

    public static function validar_modulo($modulo)
    {

        if (!(Auth::check())) {
            return "USUARIO NO AUTENTICADO";
        }
        $user = Auth::user();

        $sql =
            "SELECT
        erp_modulos.descripcion AS 'modulo',
          erp_permisos_modulos.*
        FROM
          erp_permisos_modulos
         
         LEFT JOIN erp_modulos ON
         erp_modulos.id = erp_permisos_modulos.modulo_id

        WHERE (erp_modulos.descripcion = 'Todos' OR erp_modulos.descripcion = '$modulo') AND erp_permisos_modulos.user_id =  $user->id";

        $permiso = DB::connection("app")->select($sql);
        return (empty($permiso) || $user->estado !== "ACTIVO") ? "NO" : "SI";
    }

    public static function validar_permiso_modulo($usuario, $modulo)
    {
        if (!Auth::check()) {
            return null;
        }
        $permiso = DB::connection("app")->table('ERP_PERMISOS_MODULOS')->where('MODULO', $modulo)
            ->where('USER_ID', $usuario)->get();
        $user = Auth::user();
        return $permiso->isEmpty() && $user->estado == "ACTIVO";
    }

    public function extraerNumero($String): int
    {
        if (is_string($String)) {
            preg_match_all('!\d+!', $String, $matches);
            return intval($matches[0][0]);
        }

        if (is_int($String)) {
            return intval($String);
        }

        return response()->json([
            "mensaje" => "no es valido",
        ]);
    }

    public function isNumber($number): bool
    {
        $pattern = '/^(?!-)\d+$/';
        return preg_match($pattern, $number) === 1;
    }
    public function isDecimal($number): bool
    {
        $pattern = '/^(?!-)\d+(\.\d+)?$/';
        return preg_match($pattern, $number) === 1;
    }

    public function cleanText($inputText): string
    {
        $trimmedText = trim($inputText);
        $cleanedText = str_replace(['/', '*'], '', $trimmedText);
        return $cleanedText;
    }

    public function validarFechas($fechaInicial, $fechaFinal)
    {
        // Convertir las fechas de texto a objetos DateTime
        $fechaInicialObj = DateTime::createFromFormat('Y-m-d', $fechaInicial);
        $fechaFinalObj = DateTime::createFromFormat('Y-m-d', $fechaFinal);

        // Verificar si la fecha inicial es menor o igual a la fecha final
        return ($fechaInicialObj > $fechaFinalObj) ? true : false;
    }
    public function getNameDataBase()
    {
        if (!Auth::check()) {
            throw new Exception('No logueado');
        }

        $query = $this->sqlCompanies->getCompanie($this->catchToken->Claims());
        $response = $this->repositoryDynamicsCrud->sqlFunction($query);

        return $response[0]->nombre_db;
    }

    public function getDataOdbc(string $sqlQuery, string $dsn): array
    {

        $dataManager = new DataManagerApi();
        $datos = $dataManager->ObtenerDatos($dsn, $sqlQuery);
        $dataDecodificada = json_decode($datos, true);

        return $dataDecodificada;
    }
    /**
     * Determina si la primera fecha es mayor que la segunda.
     *
     * @param string $fecha1 La primera fecha en formato 'Y-m-d H:i:s'.
     * @param string $fecha2 La segunda fecha en formato 'Y-m-d H:i:s'.
     * @return bool True si la primera fecha es mayor que la segunda, de lo contrario, false.
     */
    public static function esFechaMayor($fecha1, $fecha2)
    {
        $fecha1 = new DateTime($fecha1, new DateTimeZone('America/Bogota'));
        $fecha2 = new DateTime($fecha2, new DateTimeZone('America/Bogota'));

        return $fecha2 <= $fecha1;
    }
}