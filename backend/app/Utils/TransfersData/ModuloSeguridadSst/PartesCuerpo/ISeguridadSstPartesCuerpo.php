<?php
namespace App\Utils\TransfersData\ModuloSeguridadSst\PartesCuerpo;


interface ISeguridadSstPartesCuerpo
{
    public function getseguridadsstPartesCuerpo();
    public function addseguridadsstPartesCuerpo($dataInsert);
    public function removeseguridadsstPartesCuerpo($id);
    public function updateseguridadsstPartesCuerpo($id,$dataUpdate);
    public function updateEstadoseguridadsstPartesCuerpo($id); 
}
