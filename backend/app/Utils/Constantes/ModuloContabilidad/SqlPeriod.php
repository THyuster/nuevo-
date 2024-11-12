<?php
namespace App\Utils\Constantes\ModuloContabilidad;

class SqlPeriod {


    public function findPeriod($id) {
        return "SELECT * FROM contabilidad_periodos WHERE contabilidad_periodos.id = '$id'";
    }
    public function findPeriodForFiscalYear() {
        return "
        SELECT contabilidad_afiscals.afiscal as 'afiscal',
        contabilidad_periodos.* FROM contabilidad_periodos 
        LEFT JOIN contabilidad_afiscals ON contabilidad_afiscals.id = contabilidad_periodos.afiscal_id 
        WHERE contabilidad_afiscals.estado =1
        ORDER BY contabilidad_periodos.fecha_inicio
        ";
    }
    //


    public function checkId($lastyear, $yearNew) {
        return "
        SELECT COUNT(*) AS num_rows
        FROM contabilidad_afiscals
        WHERE contabilidad_afiscals.id IN ('$lastyear' , '$yearNew')";
    }

    public function getplicateYear($idYearNew, $lastyear, $newYear) {

        return " INSERT INTO contabilidad_periodos (afiscal_id, codigo, descripcion, fecha_inicio, fecha_final, estado)
        SELECT
         '$idYearNew',
        contabilidad_periodos.codigo,
        contabilidad_periodos.descripcion,
        DATE(CONCAT('$newYear', '-', MONTH(contabilidad_periodos.fecha_inicio), '-', DAY(contabilidad_periodos.fecha_inicio))),
        DATE(CONCAT('$newYear', '-', MONTH(contabilidad_periodos.fecha_final), '-', DAY(contabilidad_periodos.fecha_final))),
        contabilidad_periodos.estado
        
        FROM contabilidad_periodos
        INNER JOIN contabilidad_afiscals
        ON contabilidad_afiscals.id = contabilidad_periodos.afiscal_id
        WHERE contabilidad_afiscals.id =  '$lastyear'";
    }
    public function filterPeriodsByYear($id) {
        return
            " SELECT contabilidad_periodos.*,
        contabilidad_afiscals.afiscal as 'Año fiscal'
        FROM contabilidad_periodos
        LEFT JOIN contabilidad_afiscals
        ON contabilidad_periodos.afiscal_id = contabilidad_afiscals.id
        WHERE contabilidad_afiscals.id = '$id'
        
        ";

    }

    public function Datecheck($startDate, $endDate) {
        return

            "SELECT contabilidad_periodos.id
        FROM contabilidad_periodos 
        WHERE 
        contabilidad_periodos.fecha_final >='$startDate' AND
        contabilidad_periodos.fecha_inicio <='$endDate'";
    }
    public function DatecheckWithId($id, $startDate, $endDate) {
        return

            "SELECT contabilidad_periodos.id
        FROM contabilidad_periodos 
        WHERE 
        contabilidad_periodos.fecha_final >=$startDate AND
        contabilidad_periodos.fecha_inicio <=$endDate AND id != $id";
    }
}
// return         
// "
//     INSERT INTO contabilidad_periodos (afiscal_id, codigo, descripcion, fecha_inicio, fecha_final, estado)
//     SELECT
//     '$yearNew',
//     contabilidad_periodos.codigo,
//     contabilidad_periodos.descripcion,
//     contabilidad_periodos.fecha_inicio,
//     contabilidad_periodos.fecha_final,
//     contabilidad_periodos.estado
//     FROM contabilidad_periodos
//     INNER JOIN contabilidad_afiscals
//     ON contabilidad_afiscals.id = contabilidad_periodos.afiscal_id
//     WHERE contabilidad_afiscals.id = '$lastyear'
// ";