<?php

namespace App\Data\Dtos\ModuloTesoreria;

use App\Data\Dtos\ModuloTesoreria\enum\EnumTipoConcepto;

class TesoreriaConceptosDto {

    private String | null $id;
    private string  $nombre;
    private string   $grupoId ;
    private string   $cuentaAuxiliarId;
    private string  $descripcion;
    private EnumTipoConcepto  $tipo;

    public function __construct( $id, $nombre, $grupoId , $cuentaAuxiliarId, $descripcion, $tipo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->grupoId = $grupoId;
        $this->cuentaAuxiliarId = $cuentaAuxiliarId;
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
    }

    

    public function toArray(){
        return [
            'id'=> $this->id,
            'nombre'=> $this->nombre,
            'grupo_id'=> $this->grupoId,
            'cuenta_auxiliar_id'=> $this->cuentaAuxiliarId,
            'descripcion'=> $this->descripcion,
            'tipo'=> $this->tipo

        ];
    }
    
    public static function fromArray(array $request){
        return new self(
            $request['id']??null,
            $request['nombre']??null,
            $request['grupoId']??null,
            $request['cuentaAuxiliarId']??null,
            $request['descripcion']??null,
            isset($request['tipo']) ? EnumTipoConcepto::from($request['tipo']) : null
        );
    }
      public function getId(): ?string {
        return $this->id;
    }

    public function setId(?string $id): void {
        $this->id = $id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getGrupoId(): string {
        return $this->grupoId;
    }

    public function setGrupoId(string $grupoId): void {
        $this->grupoId = $grupoId;
    }

    public function getCuentaAuxiliarId(): string {
        return $this->cuentaAuxiliarId;
    }

    public function setCuentaAuxiliarId(string $cuentaAuxiliarId): void {
        $this->cuentaAuxiliarId = $cuentaAuxiliarId;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getTipo(): EnumTipoConcepto {
        return $this->tipo;
    }

    public function setTipo(EnumTipoConcepto $tipo): void {
        $this->tipo = $tipo;
    }
}