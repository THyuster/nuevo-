<?php
namespace App\Utils\TransfersData\moduloContabilidad\Areas;

interface IContabilidadAreas
{
    public function getContabilidadAreas();
    public function addContabilidadAreas($contabilidadEntidad);
    public function removeContabilidadAreas($id);
    public function updateContabilidadAreas($id,$contabilidad);
    public function updateEstadoContabilidadAreas($id); 
}