<?php

namespace App\Utils;

use DateTime;

class FilterValidation
{
    public static function FilterCampos($valor, $option = null)
    {
        if ($option == null) {
            $option = gettype($valor);
        }

        switch ($option) {
            case 'string':
                return filter_var($valor, FILTER_SANITIZE_STRING);
            case 'integer':
                return filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
            case 'double':
                return filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT);
            case 'boolean':
                return filter_var($valor, FILTER_VALIDATE_BOOLEAN);
            default:
                break;
        }
    }

    public static function getCamposDt($valor, $option = null)
    {
        if ($option == null) {
            $option = gettype($valor);
        }

        if (FilterValidation::esFechaValida($valor)) {
            $option = "date";
        }

        switch ($option) {
            case 'string':
                return "UPPER('$valor'),";
            case 'integer':
                return "'$valor',";
            case 'double':
                return "'$valor',";
            case 'date':
                return "'$valor',";
            case "boolean":
                return "'$valor',";
            default:
                break;
        }
    }

    public static function esFechaValida($fecha, $formato = 'Y-m-d')
    {
        $dateTime = DateTime::createFromFormat($formato, $fecha);
        return $dateTime && $dateTime->format($formato) === $fecha;
    }

}