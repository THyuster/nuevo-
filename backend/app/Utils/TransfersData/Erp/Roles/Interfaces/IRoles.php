<?php

namespace App\Utils\TransfersData\Erp\Roles\Interfaces;

use App\Models\Roles;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IRoles
{
    function createRole(Roles $roles): JsonResponse;
    function deleteRole(int $id): JsonResponse;
    function getRoles(Request $request);
    function updateRole(int $id, Roles $roles): JsonResponse;  

}
