<?php

namespace App\Data\Dtos\ModuloTesoreria\enum;   
enum EnumTipoConcepto: string
{
    case Ingreso = 'I';
    case Egreso = 'E';
    case  IngresoEgreso = 'IE';
}