<?php

namespace App\Utils\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Utils\CatchToken;
use App\Utils\Constantes\ConstantConsultations;
use App\Utils\Constantes\ModuloContabilidad\SqlCompanies;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class RepositoryDynamicsCrud
{
    // Define la opción por defecto como 'LOCAL'
    protected $option = 'LOCAL';
    // Definición de variables privadas de la clase
    private $sqlCompanies, $catchToken, $constantConsultations, $date;
    private $menssagesResponse = [
        "NotDataValid" => 'Campos no válidos: ',
        "NotFoundRecordsRegister" => 'No se encontró el registro asociado',
        "NotCreated" => 'No se pudo crear la información, por favor comunicarse con el administrador'
    ];

    // Constructor para inicializar las variables de la clase
    public function __construct()
    {
        $this->sqlCompanies = new SqlCompanies;
        $this->catchToken = new CatchToken;
        $this->constantConsultations = new ConstantConsultations;
        $this->date = date("Y-m-d H:i:s");
    }

    // Verifica si los campos y la tabla existen en la base de datos
    private function checkFieldsAndTable($table, $fields)
    {
        $existingFields = Schema::getColumnListing($table); // Obtiene los campos de la tabla
        $nonExistingFields = array_diff($fields, $existingFields); // Compara los campos proporcionados con los existentes
        if (!empty($nonExistingFields)) {
            throw new Exception($this->menssagesResponse["NotDataValid"] . implode(', ', $nonExistingFields)); // Lanza una excepción si hay campos no existentes
        }
    }

    // Obtiene información de la tabla, ya sea todos los registros o por ID
    public function getInfoAllOrById(string $table, array $fields = [], $id)
    {
        $conection = $this->findConectionDB(); // Encuentra la conexión a la base de datos
        try {
            switch ($this->option) {
                case 'LOCAL':
                    $this->checkFieldsAndTable($table, $fields); // Verifica los campos y la tabla
                    $query = DB::connection($conection)->table($table);

                    if (!empty($fields))
                        $query->select($fields); // Selecciona los campos especificados

                    if ($id != "*")
                        $query->where('id', $id); // Aplica filtro por ID si no es "*"

                    $result = $query->get();

                    if ($result->isEmpty()) {
                        return response()->json(['descripcion' => $this->menssagesResponse["NotFoundRecordsRegister"]], 404); // Retorna mensaje si no se encuentra el registro
                    }
                    return $result;

                case 'API':
                    return 'API'; // Manejo de la opción API (sin implementar)
            }
        } catch (\Throwable $error) {
            return response()->json(['message' => $error->getMessage()], 500); // Maneja errores y retorna mensaje de error
        }
    }

    // Crea un nuevo registro en la tabla especificada
    public function createInfo(string $table, array $data)
    {
        $connection = $this->findConectionDB(); // Encuentra la conexión a la base de datos

        switch ($this->option) {
            case 'LOCAL':
                try {
                    $query = DB::connection($connection)->table($table)->insert((array) $data); // Inserta los datos en la tabla
                    if (!$query) {
                        return response()->json(['descripcion' => $this->menssagesResponse["NotCreated"]], Response::HTTP_CONFLICT); // Retorna mensaje si no se pudo crear
                    }
                    return response()->json([json_encode("Registro creado exitosamente ")], 200); // Retorna éxito si se creó correctamente
                } catch (QueryException $e) {
                    $firstException = $e;

                    try {
                        $query = DB::connection("app")->table($table)->insert((array) $data); // Intenta insertar en otra conexión si falla

                        if (!$query) {
                            return response()->json(['descripcion' => $this->menssagesResponse["NotCreated"]], Response::HTTP_CONFLICT);
                        }

                        return response()->json([json_encode("Registro creado exitosamente ")], 200);
                    } catch (QueryException $th) {
                        $secondException = $th;
                    }

                    if (isset($firstException)) {
                        throw new Exception($firstException->getMessage(), 500); // Maneja excepciones si ambas fallan
                    }
                    throw new Exception($secondException->getMessage(), 500); // Maneja excepciones si ambas fallan
                }

            case 'API':
                return 'TRABAJANDO POR API'; // Manejo de la opción API (sin implementar)
        }
    }

    // Elimina un registro o todos los registros de la tabla especificada
    public function deleteInfoAllOrById(string $table, $id)
    {
        $connection = $this->findConectionDB(); // Encuentra la conexión a la base de datos

        switch ($this->option) {
            case 'LOCAL':
                try {
                    $query = DB::connection($connection)->table($table);
                    if ($id == "*") {
                        $query->delete(); // Elimina todos los registros si el ID es "*"
                        return response()->json([json_encode("Registros borrado exitosamente")], 200);
                    }

                    $deletedRows = $query->where('id', $id)->delete(); // Elimina el registro por ID
                    if ($deletedRows == 0) {
                        return response()->json(json_encode('Error al borrar el registro'), 400); // Retorna error si no se encuentra el registro
                    }

                    return response()->json(json_encode("Registro borrado exitosamente"), 200); // Retorna éxito si se eliminó correctamente
                } catch (QueryException $error) {
                    $firstException = $error;

                    try {
                        DB::connection("app")->table($table)->where('id', $id)->delete(); // Intenta eliminar en otra conexión si falla
                        return response()->json(json_encode("Registro borrado exitosamente"), 200);
                    } catch (\Throwable $th) {
                        $secondException = $th;
                    }

                    if (isset($firstException)) {
                        throw new Exception($firstException->getMessage(), 500); // Maneja excepciones si ambas fallan
                    }
                    throw new Exception($secondException->getMessage(), 500);
                }
            case 'API':
                return 'TRABAJANDO POR API'; // Manejo de la opción API (sin implementar)
            default:
                return 'opción no válida';
        }
    }

    // Actualiza un registro en la tabla especificada
    public function updateInfo($table, array $data, $id)
    {
        $connection = $this->findConectionDB(); // Encuentra la conexión a la base de datos

        switch ($this->option) {
            case 'LOCAL':
                try {
                    $query = DB::connection($connection)->table($table);
                    if ($id == '*') {
                        $query->update($data); // Actualiza todos los registros si el ID es "*"
                        return response()->json(json_encode("Registro actualizado exitosamente"), Response::HTTP_ACCEPTED);
                    }

                    $updateRows = $query->where('id', $id)->update((array) $data); // Actualiza el registro por ID

                    if ($updateRows == 0) {
                        return response()->json(json_encode("Ningún dato fue actualizado "), Response::HTTP_ACCEPTED); // Retorna mensaje si no se actualizó ningún registro
                    }

                    return response()->json("Registro actualizado exitosamente ", Response::HTTP_CREATED);
                } catch (\Throwable $error) {
                    $firstException = $error;
                    try {
                        $idRecord = DB::connection("app")->table($table)->where('id', $id)->update($data); // Intenta actualizar en otra conexión si falla
                        return $idRecord;
                    } catch (\Throwable $th) {
                        $secondException = $th;
                    }
                    if (isset($firstException) && isset($secondException)) {
                        throw new Exception($firstException->getMessage() . "\n" . $secondException->getMessage(), 500); // Maneja excepciones si ambas fallan
                    }

                    throw new Exception("Error en la consulta en la conexión '$connection': " . $error->getMessage());
                }
            case 'API':
                return 'TRABAJANDO POR API'; // Manejo de la opción API (sin implementar)
        }
    }

    // Ejecuta una consulta SQL
    public function sqlFunction($sql, $option = null)
    {
        $connection = $this->findConectionDB(); // Encuentra la conexión a la base de datos

        switch ($this->option) {
            case "LOCAL":
                $operation = $this->checkSQL(strtoupper($sql)); // Verifica el tipo de operación SQL

                $sql = $this->tranferSql($sql); // Transfiere la consulta SQL a otro formato

                try {
                    if ($operation == "SELECT") {
                        return DB::connection($connection)->select($sql); // Ejecuta una consulta SELECT
                    } else {
                        return DB::connection($connection)->statement($sql); // Ejecuta otra operación SQL
                    }
                } catch (QueryException $e) {
                    $firstException = $e;
                    try {
                        if ($operation == "SELECT") {
                            return DB::connection("app")->select($sql); // Intenta ejecutar en otra conexión si falla
                        } else {
                            return DB::connection("app")->statement($sql);
                        }
                    } catch (QueryException $th) {
                        $secondException = $th;
                    }

                    if (isset($firstException) && isset($secondException)) {
                        throw new Exception($firstException->getMessage() . "\n" . $secondException->getMessage(), 500); // Maneja excepciones si ambas fallan
                    }

                    throw new Exception("Error en la consulta en la conexión '$connection': " . $e->getMessage());
                }

            case "API":
                return "trabajando por ...API"; // Manejo de la opción API (sin implementar)
        }
    }

    // Transfiere la consulta SQL a otro formato si es necesario
    private function tranferSql($sql)
    {
        $query = "SELECT nombre_tabla FROM tabla_control WHERE tipo_tabla = 1";
        $tables = $this->getTableNamesFromSQL($sql); // Obtiene los nombres de las tablas de la consulta SQL
        $response = DB::connection("app")->select($query);

        foreach ($response as $clave => $obj) {
            foreach ($tables as $tableName) {
                if ($obj->nombre_tabla == $tableName) {
                    $escapedTableName = preg_quote($tableName, '/');
                    $pattern = "/(?<=FROM|JOIN|INTO|UPDATE)\s+`?($escapedTableName)`?(?=\s|$)/i";
                    $sql = preg_replace($pattern, " mla_erp_data.$tableName ", $sql); // Reemplaza el nombre de la tabla en la consulta SQL
                }
            }
        }
        return $sql;
    }

    // Obtiene los nombres de las tablas de la consulta SQL
    private function getTableNamesFromSQL($sql)
    {
        $sql = trim($sql);
        $pattern = '/(?:FROM|JOIN|INTO|UPDATE)\s+`?([a-zA-Z0-9_]+)`?/i';
        preg_match_all($pattern, $sql, $matches);
        return isset($matches[1]) ? $matches[1] : []; // Retorna los nombres de las tablas encontrados en la consulta
    }

    // Obtiene el nombre de la base de datos según el usuario autenticado
    public function getNameDataBase()
    {
        if (!Auth::check()) {
            throw new Exception('No logueado'); // Lanza una excepción si el usuario no está autenticado
        }

        $user = Auth::user(); // Obtiene el usuario autenticado
        if ($user->tipo_administrador == 1 || $user->tipo_administrador == 2) {
            return; // No realiza ninguna acción si el usuario es de tipo administrador 1 o 2
        }

        $empresa_id = CatchToken::Claims(); // Obtiene el ID de la empresa desde el token
        $sqlCom = new SqlCompanies();
        $query = $sqlCom->getCompanie($empresa_id); // Obtiene la consulta SQL para la empresa
        $response = $this->sqlFunction($query, 1); // Ejecuta la consulta SQL

        return $response[0]->nombre_db ?? throw new Exception('No hay empresa'); // Retorna el nombre de la base de datos o lanza una excepción si no se encuentra
    }

    // Obtiene el ID de un registro después de insertarlo en la tabla
    public function getRecordId($table, $data)
    {
        $connection = $this->findConectionDB(); // Encuentra la conexión a la base de datos

        switch ($this->option) {
            case "LOCAL":
                try {
                    return DB::connection($connection)->table($table)->insertGetId($data); // Inserta los datos y obtiene el ID del registro insertado
                } catch (QueryException $error) {
                    $firstException = $error;

                    try {
                        return DB::connection("app")->table($table)->insertGetId($data);
                    } catch (QueryException $th) {
                        $secondException = $th;
                    }

                    if (isset($firstException) && isset($secondException)) {
                        throw new Exception("Error: " . $firstException->getMessage()
                            . PHP_EOL . "Error: 2 " . $secondException->getMessage(), 500);
                    }
                    throw new Exception("Error en la consulta en la conexión '$connection': " . $error->getMessage());
                }

            case "API":
                return "API"; // Manejo de la opción API (sin implementar)
            default:
                break;
        }
    }

    // Verifica el tipo de operación SQL
    private function checkSQL($sql)
    {
        $palabrasClave = array("SELECT", "INSERT", "UPDATE", "DELETE");
        $sql = trim($sql);

        foreach ($palabrasClave as $palabra) {
            if (str_starts_with($sql, $palabra)) {
                return $palabra; // Retorna la palabra clave si la consulta SQL comienza con ella
            }
        }
        return false;
    }

    // Obtiene el usuario autenticado de la sesión
    public static function getSessionUser()
    {
        return Auth::user();
    }

    // Encuentra la conexión a la base de datos según el ID de la empresa
    public static function findConectionDB()
    {
        try {
            $connectionDefault = "app";
            $contabilidad_empresa_id = CatchToken::Claims(); // Obtiene el ID de la empresa desde el token

            if ($contabilidad_empresa_id) {
                $response = DB::connection($connectionDefault)->table('conexiones_database_empresas')
                    ->where('contabilidad_empresa_id', $contabilidad_empresa_id)->first();
                return $response->nombre;
            }
            return $connectionDefault; // Retorna la conexión por defecto si no se encuentra el ID de la empresa
        } catch (\Throwable $error) {
            throw new Exception($error->getMessage(), 500);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode());
        }
    }
    public static function findNameCompanie(): string
    {
        try {
            $connectionDefault = "app";
            $contabilidad_empresa_id = CatchToken::Claims(); // Obtiene el ID de la empresa desde el token

            // if ($contabilidad_empresa_id) {
            $response = DB::connection($connectionDefault)->table('contabilidad_empresas')
                ->where('id', $contabilidad_empresa_id)->first();

            return $response->razon_social; // Retorna la conexión por defecto si no se encuentra el ID de la empresa
        } catch (\Throwable $error) {
            throw new Exception($error->getMessage(), 500);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode());
        }
    }

    // Encuentra el nombre de la base de datos según el ID de la empresa
    public function findNombreDatabase()
    {
        try {
            $connectionDefault = "app";
            $connectionDbDefault = "mla_erp_data";
            $contabilidad_empresa_id = CatchToken::Claims(); // Obtiene el ID de la empresa desde el token

            if ($contabilidad_empresa_id) {
                $response = DB::connection($connectionDefault)->table('conexiones_database_empresas')
                    ->where('contabilidad_empresa_id', $contabilidad_empresa_id)->first(); // Busca la base de datos de la empresa en la conexión

                return $response->nombre_database; // Retorna el nombre de la base de datos
            }
            return $connectionDbDefault; // Retorna la base de datos por defecto si no se encuentra el ID de la empresa
        } catch (\Throwable $error) {
            throw new Exception($error->getMessage(), 500);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode());
        }
    }

    // Ejecuta una consulta SQL simple en la tabla especificada
    public function sqlSSR($tabla, $campos)
    {
        $connection = $this->findConectionDB(); // Encuentra la conexión a la base de datos
        return DB::connection($connection)->table($tabla)->select($campos); // Selecciona los campos de la tabla
    }

    // Ejecuta una consulta SQL compleja con joins en la tabla especificada
    public function sqlSSRCompleja($tabla, $campos = [], $joins = [], $condicion = null)
    {
        $connection = $this->findConectionDB(); // Encuentra la conexión a la base de datos

        $query = DB::connection($connection)->table($tabla . " AS s")->select(); // Inicia la consulta en la tabla con alias 's'

        foreach ($joins as $join) {
            $joinType = $join['type']; // Tipo de join (inner, left, etc.)
            $joinTable = $join['table']; // Tabla a unir
            $joinCondition = $join['condition']; // Condición de la unión
            $query->{$joinType}($joinTable, $joinCondition); // Aplica la unión a la consulta
        }

        return $query; // Retorna la consulta con los joins aplicados
    }

    // Crea un log en la base de datos con la acción realizada
    private function createLog($conectionName, string $table, string $accion, array $data, int $idRecord = null)
    {
        if (Auth::user()->tipo_administrador == 2) {
            return; // No crea log si el usuario es de tipo administrador 2
        }
        $inserLog = array(
            'user_id' => Auth::user()->id,
            'user' => Auth::user()->name,
            'tabla' => $table,
            'id_registro' => $idRecord,
            'accion' => $accion,
            'fecha' => $this->date,
            'datos' => json_encode($data)
        );

        try {
            return DB::connection($conectionName)->table("log")->insert($inserLog); // Inserta el log en la tabla 'log' de la base de datos
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500); // Maneja errores y lanza una excepción con el mensaje de error
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), 500); // Maneja excepciones generales y lanza una excepción con el mensaje de error
        }
    }
    public static function getConnectioByIdEmpresa($contabilidadEmpresaId): string|null
    {
        $response = DB::connection('app')->table('conexiones_database_empresas')
            ->where('contabilidad_empresa_id', $contabilidadEmpresaId)->first();
        if ($response == null) {
            return null;
        }
        return $response->nombre;
    }
}
