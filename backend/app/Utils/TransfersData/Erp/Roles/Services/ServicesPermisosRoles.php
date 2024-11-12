<?php

namespace App\Utils\TransfersData\Erp\Roles\Services;

use App\Models\RolesAsignar;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\Erp\Roles\Interfaces\IRolesPermisos;

class ServicesPermisosRoles extends RepositoryDynamicsCrud  implements IRolesPermisos
{

    /**
     *
     * @param array $roles
     */
    public function createServicesRoles(string $id, array $roles)
    {
        $roleId = $id;
        $vistas = $roles["vistas"];

        // Obtener vistas asignadas antes del proceso
        $vistasAntesAsignadas = RolesAsignar::where('roles_id', $roleId)
            ->pluck('vista_id')
            ->toArray();

        foreach ($vistas as $vistaId) {
            $permisos = $roles["permisos_vista_" . $vistaId];

            if ($permisos) {
                $permisosAsignados = [];

                foreach ($permisos as $permisoId) {
                    $existingRole = RolesAsignar::where('permisos_crud_id', $permisoId)
                        ->where('roles_id', $roleId)
                        ->where('vista_id', $vistaId)
                        ->first();

                    if (!$existingRole) {
                        $permiso = [
                            "vista_id" => $vistaId,
                            "permisos_crud_id" => $permisoId,
                            "roles_id" => $roleId
                        ];

                        $permisosAsignados[] = $permisoId;

                        $roleEntity = new RolesAsignar($permiso);
                        $roleEntity->save();
                    } else {
                        $permisosAsignados[] = $permisoId;
                    }
                }

                // Eliminar permisos que ya no están asignados
                $permisosActuales = RolesAsignar::where('roles_id', $roleId)
                    ->where('vista_id', $vistaId)
                    ->pluck('permisos_crud_id')
                    ->toArray();

                $permisosEliminar = array_diff($permisosActuales, $permisosAsignados);

                RolesAsignar::where('roles_id', $roleId)
                    ->where('vista_id', $vistaId)
                    ->whereIn('permisos_crud_id', $permisosEliminar)
                    ->delete();
            }
        }

        // Eliminar vistas que ya no están asignadas
        $vistasEliminar = array_diff($vistasAntesAsignadas, $vistas);

        RolesAsignar::where('roles_id', $roleId)
            ->whereIn('vista_id', $vistasEliminar)
            ->delete();

        return true;
    }


    private function findMissingElements($array1, $array2)
    {
        $missingElements = array_diff($array1, $array2);
        sort($missingElements);
        return $missingElements;
    }
    /**
     * @return array
     */
    public function getServicesPermisosRoles(string $id): array
    {
        $roles = RolesAsignar::with(['role', 'permisos'])->where('roles_id', $id)->get();        // return $roles->toArray();

        $transformedData = [];

        foreach ($roles as $item) {
            $key = $item['role']['descripcion'];

            if (!array_key_exists($key, $transformedData)) {
                $transformedData[$key] = [
                    'role' => $item['role']['descripcion'],
                    'vistas' => [
                        $item['vista_id'] => [$item['permisos']['id']]
                    ]
                ];
            } else {
                if (!array_key_exists($item['vista_id'], $transformedData[$key]['vistas'])) {
                    $transformedData[$key]['vistas'][$item['vista_id']] = [$item['permisos']['nombre']];
                } else {
                    $transformedData[$key]['vistas'][$item['vista_id']][] = $item['permisos']['nombre'];
                }
            }
        }

        // return $transformedData;

        $flatData = [];
        foreach ($transformedData as $entry) {
            $vistas = array_keys($entry['vistas']);
            $vistas_permisos = [];
            foreach ($vistas as $vista_id) {
                $vistas_permisos['permisos_vista_' . $vista_id] = $entry['vistas'][$vista_id];
            }
            $entry['vista_id'] = $vistas;
            $flatData[] = $entry + $vistas_permisos;
        }
        $roles = $roles->toArray();
        
        if (!empty($roles)) {
            $roles[0]["vista_id"] = $flatData[0]["vista_id"];
        }
        // $roles[0]
        return $roles;
    }
}
