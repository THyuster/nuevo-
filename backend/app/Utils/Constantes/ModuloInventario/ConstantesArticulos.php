<?php

namespace App\Utils\Constantes\ModuloInventario;

final class ConstantesArticulos
{
    protected $date;

    public function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
    }

    public function sqlSelectByCode($codigo)
    {
        return "SELECT * FROM inventarios_articulos2 WHERE codigo = '$codigo'";
    }
    public function sqlSelectAll()
    {
        return "SELECT * FROM inventario_articulos_view";
    }

    public function sqlSelectEntidadById($id)
    {
        return "SELECT * FROM inventarios_articulos2 WHERE id = '$id'";
    }
    public function sqlSelectById($id)
    {
        return "SELECT id, codigo, descripcion, estado FROM `inventarios_articulos2` WHERE id = '$id'";
    }
    public function sqlInsert($EntidadArticulo)
    {
        $consultaCampos = '';
        $consultaValues = '';
        foreach ($EntidadArticulo as $atributo => $valor) {
            $consultaCampos .= "`$atributo`, ";
            $consultaValues .= "'$valor', ";
        }
        $consultaCampos = rtrim($consultaCampos, ', ');
        $consultaValues = rtrim($consultaValues, ', ');

        return "INSERT INTO `inventarios_articulos2` (`created_at`, `updated_at`,$consultaCampos,`estado`)
        VALUES ('$this->date', '$this->date',$consultaValues, 1)";
    }

    public function sqlUpdate($id, $EntidadArticulo)
    {
        $consultaSet = '';
        foreach ($EntidadArticulo as $atributo => $valor) {
            $consultaSet .= "`$atributo`='$valor', ";
        }
        $consultaSet = rtrim($consultaSet, ', ');
        return "UPDATE `inventarios_articulos2` SET `updated_at`='$this->date',$consultaSet WHERE `id`='$id'";
    }

    public function sqlDelete($id)
    {
        return "DELETE FROM inventarios_articulos2 WHERE id = '$id'";
    }

    public function sqlUpdateEstado($id, $estado)
    {
        return "UPDATE `inventarios_articulos2` 
        SET `updated_at`='$this->date',`estado`='$estado'
        WHERE `id` = '$id'";
    }

    public function sqlArticleByHomologation()
    {
        return "SELECT 
        IA.id idArticulo, 
        IA.descripcion,
        IA.id_homologacion idRelacion,
        MH.id idHomologacion, 
        MH.descripcion  descripcionHomologacion
        FROM inventarios_articulos2 IA 
        LEFT JOIN mantenimiento_homologaciones MH on IA.id_homologacion= MH.id";
    }
    public function  sqlArticleImportacion($codigos)
    {
        return "SELECT
                MT.CODIGO codigo,
                MT.CODBARRA codigo_barras,
                MT.DESCRIP descripcion,
                MT.REFERENCIA referencia,
                MT.TIPMAT tipo_material,
                MT.TIPSERIAL tipo_serial,
                
                MT.TIPOBIENID TIPO_BIEN,
                MT.FACTOR  FACTOR,
                MT.FACTORGLB  FACTOR_GLOBAL,
                MT.IVAMAYOR  IVA_MAYOR_COSTO,
                MT.MODELOART  MODELO,
                BS.CODIGO codigo_bien_servicio_id , 
                UN.CODIGO codigo_unidades_id ,
                GPM.CODIGO codigo_grupo_articulo,
                GCM.CODIGO codigo_grupo_contable,
                DP.CODIGO codigo_departamento,
                LM.CODIGO codigo_linea, 
                MM.CODIGO codigo_marca,
                CM.CODCOLOR CODIGO_COLOR
                FROM MATERIAL MT
                LEFT JOIN CODIGOBIENSERVICIO BS ON MT.CODIGOBIENSERVICIOID = BS.CODIGOBIENSERVICIOID
                LEFT JOIN CODIGOSUNIDADES UN ON MT.CODUNIDADID = UN.CODUNIDADID
                LEFT JOIN GRUPMAT GPM ON MT.GRUPMATID = GPM.GRUPMATID
                LEFT JOIN GCMAT GCM ON MT.GCMATID = GCM.GCMATID
                LEFT JOIN DEPTOART DP ON MT.DEPTOARTID = DP.DEPTOARTID
                LEFT JOIN LINEAMAT LM ON MT.LINEAMATID = LM.LINEAMATID
                LEFT JOIN MARCAART MM ON MT.MARCAARTID = MM.MARCAARTID
                LEFT JOIN COLOR CM ON MT.COLORID = CM.COLORID
                WHERE MT.CODIGO NOT IN ($codigos)
                ";
    }
}