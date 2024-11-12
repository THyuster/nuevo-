<?php

namespace App\Utils\Constantes\ModuloMantenimiento;

final class CEntregasDirectas
{

    public function sqlObtenerEntregas()
    {
        return "SELECT 1 codigo, med.fecha, nct.descripcion centro_trabajo, U.name, med.usuario_recibe, 
        med.observaciones, ia.descripcion descripcion_articulo
        FROM mantenimiento_entregas_directas med 
        LEFT JOIN nomina_centros_trabajos nct ON nct.id = med.centro_trabajo_id 
        LEFT JOIN mla_erp_data.users u ON med.usuario_entrega = u.id
        LEFT JOIN mantenimiento_relacion_articulos_entregas_directas mraed ON 
        mraed.entrega_directa_id = med.id
        LEFT JOIN inventarios_articulos2 ia ON ia.id  = mraed.articulo_id";
    }
}
