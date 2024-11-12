<?php

namespace App\Utils;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Storage;

class FileManager
{
    /**
     * Genera un nombre de archivo único basado en el nombre original del archivo.
     *
     * @param string $originalName Nombre original del archivo
     * @return string Nombre de archivo único
     */
    protected function generateUniqueFileName($originalName)
    {
        // Obtener la extensión del archivo
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);

        // Generar un nombre único usando un timestamp y un identificador aleatorio
        $uniqueName = uniqid() . '_' . time() . '.' . $extension;

        return $uniqueName;
    }

    /**
     * Maneja la subida de una imagen.
     *
     * @param \Illuminate\Http\Request $request Solicitud que contiene el archivo.
     * @param string $path Ruta del directorio de destino en el servidor.
     * @param string $campo Nombre del campo del formulario que contiene la imagen. Si está vacío, se usa "ruta_imagen" por defecto.
     * @return mixed La respuesta de la API de subida de imágenes.
     * @throws \Exception Si ocurre un error al manejar el archivo o al subirlo.
     */
    public function pushImagen(Request $request, string $path = "imagenes", string $campo = 'ruta_imagen')
    {
        // Verificar si el campo contiene un archivo
        $campo = "ruta_imagen";

        if (!$request->hasFile($campo)) {
            throw new Exception("No se encontró ningún archivo en el campo '{$campo}'.");
        }

        // Obtener el archivo de la solicitud
        $image = $request->file($campo);

        // Validar si el archivo es una imagen
        if (!$image->isValid()) {
            throw new Exception("El archivo proporcionado no es una imagen válida.");
        }

        // Generar un nombre de archivo único
        $imageName = $this->generateUniqueFileName($image->getClientOriginalName());

        // Almacenar la imagen en el almacenamiento público
        $path = $request->storeAs($path, $imageName, 'public');

        // Retornar la URL de la imagen almacenada
        return "storage/$path";
    }


    public function pushImag(UploadedFile $image, string $path, string $campo = 'ruta_imagen')
    {
        // Obtener la ruta y el nombre del archivo
        // Validar si el archivo es una imagen
        if (!$image->isValid()) {
            throw new Exception("El archivo proporcionado no es una imagen válida.");
        }

        // Generar un nombre de archivo único
        $imageName = $this->generateUniqueFileName($image->getClientOriginalName());

        // Almacenar la imagen en el almacenamiento público
        $storedPath = $image->storeAs($path, $imageName, 'public');

        // Retornar la URL de la imagen almacenada
        return "storage/$storedPath";

    }

    public function pushPDF(Request $request, string $path, string $campo)
    {
        if ($campo == "") {
            $campo = "pdf";
        }
        $image = $request->file($campo);
        $imagePath = $image->getPathname();
        $imageName = $image->getClientOriginalName();
        return $this->pushImagenPDF($imagePath, $imageName, $path);
    }

    /**
     * Elimina una imagen a través de una API externa.
     *
     * @param string $path Ruta de la imagen a eliminar.
     * @return mixed La respuesta de la API indicando el resultado de la eliminación.
     * @throws \Exception Si ocurre un error al eliminar la imagen o al procesar la respuesta.
     */
    public function deleteImage(string $path)
    {

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return true; // Indicar que la eliminación fue exitosa
        } else {
            return false;
        }

    }
    /**
     * Sube una imagen a una API externa.
     *
     * @param string $imagePath Ruta del archivo de imagen en el sistema de archivos.
     * @param string $imageName Nombre del archivo de imagen.
     * @param string $storagePath Ruta de almacenamiento en el servidor.
     * @return string Ruta de la imagen almacenada según la respuesta de la API.
     * @throws \Exception Si ocurre un error al subir la imagen o al procesar la respuesta.
     */
    private function pushImagenApi(string $imagePath, string $imageName, string $storagePath): string
    {

        // $ruta = $resource->store($imagePath, 'public');
        // $resourcesDTO = new ResourceDTO(asset("storage/$ruta"), $itemCreateDTO->item_id, null);
        // $pathResource[] = $resourcesDTO->toArray();

        $url = env('API_URL_IMG') . 'api_mla/almacenar/imagen';
        $token = env("SESSION_TOKEN_API");

        // Realizar la solicitud POST a la API
        $response = Http::withToken($token)
            ->attach('archivo', file_get_contents($imagePath), $imageName)
            ->acceptJson()
            ->post($url, ['ruta_almacenado' => $storagePath]);

        // Verificar el estado de la respuesta
        if (!$response->successful()) {
            throw new Exception('Error al subir la imagen: ' . $response->status() . ' ' . $response->body());
        }

        // Obtener los datos de la respuesta
        $data = $response->json();

        // Validar que la respuesta contenga la clave 'ruta'
        if (!isset($data['ruta'])) {
            throw new Exception('Respuesta de la API no contiene la clave "ruta".');
        }

        return $data['ruta'];
    }

    private function pushImagenPDF($imagePath, $imageName, $storagePath)
    {


        $url = env('API_URL_IMG') . 'api_mla/almacenar/pdf';
        $token = env("SESSION_TOKEN_API");

        $response = Http::withToken($token)->attach('archivo', file_get_contents($imagePath), $imageName)->acceptJson()
            ->accept('multipart/form-data')->post($url, ['ruta_almacenado' => $storagePath,]);

        $data = $response->json();

        // return $data;
        return $data['ruta'];
    }

}
