<?php
namespace App\Utils\TransfersData\ModuloMantenimiento\Mediciones;

interface IMediciones
{
    public function getMediciones();
    public function addMediciones($mediciones);
    public function removeMediciones($id);
    public function updateMediciones($id,$mediciones);
    public function getMedicionById($id);
}