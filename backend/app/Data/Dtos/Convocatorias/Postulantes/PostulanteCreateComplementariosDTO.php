<?php

namespace App\Data\Dtos\Convocatorias\Postulantes;

class PostulanteCreateComplementariosDTO
{
    public $id;
    public $aspiracionIngresos;
    public $licenciasConduccion;
    public $nivelIngles;
    public $habilidadesInformaticas;
    public $inmediatezInicial;
    public $paisesVisitados;
    public $estatura;
    public $peso;
    public $deporte;
    public $fuma;
    public $alcohol;
    public $tipoVehiculo;
    public $vehiculoPropio;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? uuid_create();
        $this->aspiracionIngresos = $data['aspiracion_ingresos'] ?? null;
        $this->licenciasConduccion = $data['licencias_conduccion'] ?? null;
        $this->nivelIngles = $data['nivel_ingles'] ?? null;
        $this->habilidadesInformaticas = $data['habilidades_informaticas'] ?? null;
        $this->inmediatezInicial = $data['inmediatez_inicial'] ?? null;
        $this->paisesVisitados = $data['paises_visitados'] ?? null;
        $this->estatura = $data['estatura'] ?? null;
        $this->peso = $data['peso'] ?? null;
        $this->deporte = $data['deporte'] ?? null;
        $this->fuma = $data['fuma'] ?? null;
        $this->alcohol = $data['alcohol'] ?? null;
        $this->tipoVehiculo = $data['tipo_vehiculo'] ?? null;
        $this->vehiculoPropio = $data['vehiculo_propio'] ?? null;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'aspiracion_ingresos' => $this->aspiracionIngresos,
            'licencias_conduccion' => $this->licenciasConduccion,
            'nivel_ingles' => $this->nivelIngles,
            'habilidades_informaticas' => $this->habilidadesInformaticas,
            'inmediatez_inicial' => $this->inmediatezInicial,
            'paises_visitados' => $this->paisesVisitados,
            'estatura' => $this->estatura,
            'peso' => $this->peso,
            'deporte' => $this->deporte,
            'fuma' => $this->fuma,
            'alcohol' => $this->alcohol,
            'tipo_vehiculo' => $this->tipoVehiculo,
            'vehiculo_propio' => $this->vehiculoPropio
        ];
    }

}
