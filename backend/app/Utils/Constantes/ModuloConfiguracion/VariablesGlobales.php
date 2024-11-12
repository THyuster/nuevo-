<?php

namespace App\Utils\Constantes\ModuloConfiguracion;

class VariablesGlobales
{


    public function sqlGetVariablesConRespuesta()
    {
        return "SELECT cvg.*, em.descripcion Modulo, 
         cvg.respuesta_sistema valor, 
        emr.tipo_respuesta tipoRespuesta
        FROM configuracion_variables_globales cvg 
        LEFT JOIN erp_modulos em ON cvg.modulo_id = em.id 
        -- LEFT JOIN respuesta_variables_glb rvg ON rvg.id_variable_global = cvg.id 
        LEFT JOIN erp_mant_respuestas emr ON emr.id = cvg.tipo_respuesta 
        WHERE   cvg.tipo = 'sistemaGlobal' OR cvg.tipo = 'sistemaEmpresa'
        ";
    }

    public function sqlGetVariablesConRespuestaConEmpresaLogueado( $empresaLogueado)
    {
        return "
        SELECT cvg.*, em.descripcion Modulo, 
         rvg.valor, 
        emr.tipo_respuesta tipoRespuesta
        FROM configuracion_variables_globales cvg 
        LEFT JOIN erp_modulos em ON cvg.modulo_id = em.id 
         LEFT JOIN respuesta_variables_glb rvg ON rvg.id_variable_global = cvg.id 
        LEFT JOIN erp_mant_respuestas emr ON emr.id = cvg.tipo_respuesta 
        WHERE cvg.tipo = 'usuario' AND  cvg.empresa_id = $empresaLogueado OR ( cvg.tipo ='sistemaEmpresa')";
    }
}
