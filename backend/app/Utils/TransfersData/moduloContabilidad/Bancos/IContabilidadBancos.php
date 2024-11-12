<?php

namespace App\Utils\TransfersData\moduloContabilidad\Bancos;

interface IContabilidadBancos
{
    public function getContabilidadBancos();
    public function addContabilidadBancos($contabilidadEntidad);
    public function removeContabilidadBancos($id);
    public function updateContabilidadBancos($id, $contabilidad);
    public function updateEstadoContabilidadBancos($id);
    public function conversionBancosTnsAErp();
}