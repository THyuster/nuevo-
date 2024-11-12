<?php

namespace App\Http\Controllers\modulo_configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\AsignacionUsuarioRoleRequest;
use App\Models\erp_roles_asignado_usuario;
use App\Models\modulo_configuracion\erp_roles;
use App\Models\Roles;
use App\Models\User;
use App\Utils\CatchToken;
use App\Utils\Encryption\EncryptionFunction;
use Illuminate\Http\Request;

class AsignarRolesController extends Controller
{
    public function store(AsignacionUsuarioRoleRequest $request)
    {
        // Instantiate a new erp_roles_asignado_usuario object with request data
        $asignacionRol = new erp_roles_asignado_usuario($request->all());

        // Check if the role exists
        $findRol = Roles::find($asignacionRol->role_id);
        if (!$findRol) {
            return "El rol no existe";
        }

        // Check if the user exists
        $findUser = User::find($asignacionRol->user_id);
        if (!$findUser) {
            return "Usuario no existe";
        }

        // Check if the user already has this role assigned
        $asignacionFind = erp_roles_asignado_usuario::where("user_id", $asignacionRol->user_id)
            ->where("role_id", $asignacionRol->role_id)
            ->exists();
        if ($asignacionFind) {
            return "Este usuario ya tiene este rol asignado";
        }

        try {
            // Save the assignment
            $asignacionRol->save();
            return "Asignación de rol guardada correctamente";
        } catch (\Throwable $th) {
            return $th->getMessage(); // Return the error message if saving fails
        }
    }


    public function show(Request $request)
    {
        $empresaId = CatchToken::Claims();

        $campos = [
            "id",
            "nombre_usuario",
            "rol",
            "codigo_rol",
            // "id_empresa"
        ];

        try {
            $roles = \DB::table("asignacion_roles_usuario_view")
                ->where("id_empresa", $empresaId)->select($campos);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        $columns = [];

        for ($i = 0; $i < sizeof($campos); $i++) {
            $columns[] = ['db' => $campos[$i], 'dt' => $i];
        }

        $totalRecords = $roles->count();

        if ($request->has('search') && $request->input('search.value')) {
            $searchValue = $request->input('search.value');
            $roles = $roles->where(function ($query) use ($searchValue, $campos) {
                foreach ($campos as $campo) {
                    $query->orWhere($campo, 'like', '%' . $searchValue . '%');
                }
            });
        }

        $filteredRecords = $roles->count();

        if ($request->has('order') && $request->input('order')) {
            foreach ($request->input('order') as $order) {
                $columnIndex = $order['column'];
                $columnName = $columns[$columnIndex]['db'];
                $direction = $order['dir'];
                $roles->orderBy($columnName, $direction);
            }
        }


        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        if ($length != -1) {
            $roles->offset($start)->limit($length);
        }

        $data = $roles->get();

        $response = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data->toArray(),
        ];

        return json_encode($response);

    }

    public function destroy(int $id)
    {
        try {
            $empresaId = CatchToken::Claims();

            $rolFind = Roles::where("id", $id)->where('empresa_id', $empresaId)->exists();

            if ($rolFind) {
                Roles::where('id', $id)->delete();
            }

            return "El rol no existe en esta empresa";

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
