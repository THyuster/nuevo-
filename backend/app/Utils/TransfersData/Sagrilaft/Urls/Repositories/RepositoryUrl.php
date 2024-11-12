<?php
namespace App\Utils\TransfersData\Sagrilaft\Urls\Repositories;
use App\Data\Dtos\Sagrilaft\Validacion\Url\Response\SagrilaftUrl;
use App\Models\Sagrilaft\SagrilaftUrls;
use App\Utils\Repository\RepositoryDynamicsCrud;

class RepositoryUrl implements IRepositoryUrl
{
    public function create(array $datos, $connection = null)
    {
        // Obtiene la conexión a la base de datos. Si no se proporciona, usa la conexión por defecto.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta crear la URL en la base de datos y devuelve una nueva instancia de SagrilaftUrl.
        try {
            $url = SagrilaftUrls::on($connection)->create($datos);
            return new SagrilaftUrl($url);
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir y lanza una excepción personalizada si es necesario.
            throw new \Exception('Error al crear la URL: ' . $e->getMessage());
        }
        // $connection ??= RepositoryDynamicsCrud::findConectionDB();
        // return new SagrilaftUrl(SagrilaftUrls::on($connection)->create($datos));
    }
    public function update($id, array $datos)
    {

    }

    public function getById($id, $connection = null)
    {
        // Obtiene la conexión a la base de datos. Si no se proporciona, usa la conexión por defecto.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta buscar la URL en la base de datos.
        try {
            $url = SagrilaftUrls::on($connection)->with(['urls'])->find($id);

            if (!$url) {
                throw new \Exception('URL no encontrada.');
            }

            return new SagrilaftUrl($url);
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir y lanza una excepción personalizada.
            throw new \Exception('Error al buscar la URL: ' . $e->getMessage());
        }
    }

    public function deleteById($id, $connection = null)
    {
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta eliminar el registro por ID
        try {
            $deleted = SagrilaftUrls::on($connection)->find($id);

            if ($deleted) {
                return $deleted->delete();
            }

            return false; // No se encontró el registro
        } catch (\Exception $e) {
            // Lanza una excepción personalizada si ocurre un error
            throw new \Exception('Error al eliminar el registro: ' . $e->getMessage());
        }
    }
    public function existById($id, $connection = null)
    {
        // Obtiene la conexión a la base de datos si no se proporciona.
        $connection ??= RepositoryDynamicsCrud::findConectionDB();

        // Intenta verificar si el registro existe.
        try {
            return SagrilaftUrls::on($connection)->where('id', $id)->exists();
        } catch (\Exception $e) {
            // Lanza una excepción personalizada si ocurre un error.
            throw new \Exception('Error al buscar el empleado url: ' . $e->getMessage());
        }
    }
}
