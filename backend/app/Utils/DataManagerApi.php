<?php

namespace App\Utils;

use App\Utils\Connection\endpointsconnection;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class DataManagerApi
{

    public function ObtenerDatos(string $dns, string $sqlQuery)
    {
        $datos = "";
        $url = endpointsconnection::GET_POST_OBTENER_DATOS_API();
        $json = [
            "dns" => $dns,
            "sqlQuery" => $sqlQuery,
        ];
        try {
            $datos =  $this->loadDataApi($url, $json);
        } catch (Exception $e) {
            echo 'Error al cargar los datos: ' . $e->getMessage();
        }
        return $datos;
    }
    public function ejecutarAccionSql(string $dns, string $sqlQuery, array $sqlParameter)
    {
        $datos = "";
        $url = endpointsconnection::GET_POST_EJECUTAR_ACCIONES_API();
        $json = [
            "dns" => $dns,
            "sqlQuery" => $sqlQuery,
            "sqlParameter" => $sqlParameter
        ];
        try {
            $datos =  $this->loadDataApi($url, $json);
        } catch (Exception $e) {
            echo 'Error al cargar los datos: ' . $e->getMessage();
        }
        return $datos;
    }



    private function loadDataApi(string $url, $json)
    {
        try {
            $token = env("API_ODBC_TOKEN");
            $response = Http::withToken($token)->withoutVerifying()->acceptJson()->accept('multipart/form-data')->post($url, $json);
            $response->throw();

            $data = $response->json();

            $compressedData = base64_decode($data);
            $uncompressedData = zlib_decode($compressedData);
            return $uncompressedData;
        } catch (RequestException $e) {
            throw new Exception("Revisar la conexion ".$e->response);
        }
    }

    private function SendDataApi(string $url, $json)
    {
        $token = env("API_ODBC_TOKEN");

        $response = Http::withToken($token)->withoutVerifying()->acceptJson()->accept('multipart/form-data')->post($url, $json);
        $data = $response->json();
        $compressedData = base64_decode($data);
        $uncompressedData = zlib_decode($compressedData);
        return $uncompressedData;
    }
}