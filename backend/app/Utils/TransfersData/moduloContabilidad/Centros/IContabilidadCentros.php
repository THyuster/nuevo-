<?php
namespace App\Utils\TransfersData\moduloContabilidad\Centros;

interface IContabilidadCentros
{
    public function getContabilidadCentros();
    public function addContabilidadCentros($contabilidadEntidad);
    public function removeContabilidadCentros($id);
    public function updateContabilidadCentros($id,$contabilidad);
    public function updateEstadoContabilidadCentros($id); 
}