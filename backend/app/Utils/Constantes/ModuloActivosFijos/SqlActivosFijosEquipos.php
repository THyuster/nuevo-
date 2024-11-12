<?php

namespace App\Utils\Constantes\ModuloActivosFijos;


class SqlActivosFijosEquipos
{

   public function sqlGetFixedAsset($id)
   {
      return "SELECT * FROM activos_fijos_equipos WHERE id = '$id' ";
   }

   public function sqlGetIdentification($id)
   {
      return "SELECT * FROM activos_fijos_equipos WHERE codigo = '$id'";
   }
   public function getFixedAssetsByIdDiferent($id, $codigo)
   {
      return "SELECT * FROM activos_fijos_equipos WHERE codigo= '$codigo' AND id != '$id'";
   }
   public function getCheckThird($id)
   {
      return "SELECT * FROM contabilidad_terceros WHERE identificacion = '$id'";
   }
   public function getFixedAssets()
   {
      return "SELECT * FROM activos_fijos_equipos";
   }
}
