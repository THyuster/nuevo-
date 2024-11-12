<?php


namespace App\Utils\TransfersData\ModuloTesoreria;

use App\Data\Dtos\ModuloTesoreria\TesoreriaConceptosDto;
use App\Utils\Constantes\DB\tablas;
use App\Utils\Encryption\EncryptionFunction;
use App\Utils\Repository\RepositoryDynamicsCrud;
use App\Utils\TransfersData\moduloContabilidad\PlanUnicoCuentas\IServicioCuentaAuxiliares;
use Symfony\Component\HttpFoundation\Response;

class ServicioConceptos implements IServicioConceptos
{
    private String $tablaconceptos;
    private RepositoryDynamicsCrud $repositoryDynamicsCrud;

    private IServicioGruposConceptos $iServicioConceptos;
    private IServicioCuentaAuxiliares $iServicioCuentaAuxiliares;

    public function __construct(
        IServicioGruposConceptos $iServicioConceptos,
        IServicioCuentaAuxiliares $iServicioCuentaAuxiliares
        ) {
        $this->repositoryDynamicsCrud = new RepositoryDynamicsCrud;
        $this->tablaconceptos = tablas::getTablaClienteTesoreriaConcepto();
        $this->iServicioConceptos = $iServicioConceptos;
        $this->iServicioCuentaAuxiliares = $iServicioCuentaAuxiliares;

        
        
    }

    public function obtenerConceptos($encriptarDato){
        $sql = "
        SELECT 
            tc.id,
            tc.grupo_id,
            tc.nombre,
            tc.descripcion,
            tc.tipo,
            tgc.id idGrupoConcepto,
            CONCAT(tgc.nombre,' - ', tgc.descripcion) grupoConcepto,
            cpa.id idCuentaAuxiliar,
            CONCAT(cpa.codigo, ' - ', cpa.nombre, ' - ', cpa.descripcion) descripcionCuentaAuxiliar
        FROM tesoreria_conceptos tc 
        INNER JOIN tesoreria_grupo_conceptos tgc ON  tc.grupo_id = tgc.id
        INNER JOIN contabilidad_puc5_auxiliares cpa ON  tc.cuenta_auxiliar_id  = cpa.id
        ";
        $response = $this->repositoryDynamicsCrud->sqlFunction( $sql );

        return $this->obtenerConceptosSinEncriptar($response, $encriptarDato);
        // $nuevoGrupoConcepto=[];
        // foreach ($response as $concepto) {
        //     $idConceptoEncriptado = base64_encode($this->encriptarKey( $concepto->id ));
        //     $idGrupoConceptoEncriptado = base64_encode($this->encriptarKey( $concepto->idGrupoConcepto ));
        //         $conceptoActual =[
        //             "id"=> $idConceptoEncriptado,
        //             "nombre"=> $concepto->nombre,
        //             "descripcion"=> $concepto->descripcion,
        //             "tipo"=> $concepto->tipo,
        //             "grupoConcepto"=> [
        //                 "id"=> $idGrupoConceptoEncriptado,
        //                 "descripcion"=> $concepto->grupoConcepto,
        //             ],
        //             "cuentaAuxiliar"=>[
        //                 "id"=> $concepto->idCuentaAuxiliar,
        //                 "descripcion"=> $concepto->descripcionCuentaAuxiliar,
        //             ],
        //         ];
        //         $nuevoGrupoConcepto[] = $conceptoActual;
        // }
        return $nuevoGrupoConcepto;
        
    }
    public function obtenerConceptosSinEncriptar(array $response, $encriptarDato){
     
        $nuevoGrupoConcepto=[];
        foreach ($response as $concepto) {
            if($encriptarDato ){
                $concepto->id = base64_encode($this->encriptarKey( $concepto->id ));
            }
            
            $concepto->idCuentaAuxiliar = base64_encode($this->encriptarKey( $concepto->idCuentaAuxiliar ));
            $idGrupoConceptoEncriptado = base64_encode($this->encriptarKey( $concepto->idGrupoConcepto ));
                $conceptoActual =[
                    "id"=> $concepto->id,
                    "nombre"=> $concepto->nombre,
                    "descripcion"=> $concepto->descripcion,
                    "tipo"=> $concepto->tipo,
                    "grupoConcepto"=> [
                        "id"=> $idGrupoConceptoEncriptado,
                        "descripcion"=> $concepto->grupoConcepto,
                    ],
                    "cuentaAuxiliar"=>[
                        "id"=> $concepto->idCuentaAuxiliar,
                        "descripcion"=> $concepto->descripcionCuentaAuxiliar,
                    ],
                ];
                $nuevoGrupoConcepto[] = $conceptoActual;
        }
        return $nuevoGrupoConcepto;
        
    }

    public function crearConceptos(TesoreriaConceptosDto $tesoreriaConceptosDto): Response{
        try {
            $idGrupoConceptoDesencriptado = $this->desencriptarKey(base64_decode($tesoreriaConceptosDto->getGrupoId() ));
            $tesoreriaConceptosDto->setGrupoId( $idGrupoConceptoDesencriptado );
            $this->iServicioConceptos->buscarGrupoConceptoPorId( $idGrupoConceptoDesencriptado);

            $idCuentaAuxiliarDesencriptado = $this->desencriptarKey(base64_decode($tesoreriaConceptosDto->getCuentaAuxiliarId() ));
            $tesoreriaConceptosDto->setCuentaAuxiliarId( $idCuentaAuxiliarDesencriptado );
            $this->iServicioCuentaAuxiliares->buscarCuentaAuxiliarPorId( $idCuentaAuxiliarDesencriptado);

            $this->repositoryDynamicsCrud->createInfo($this->tablaconceptos, $tesoreriaConceptosDto->toArray());
            
            return response()->json("Registro creado exitosamente", Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response($th->getMessage(), $th->getCode());
        }
    }

    public function actualizarConceptos(TesoreriaConceptosDto $tesoreriaConceptosDto):Response{
        try {
            $idConceptoDesencriptado = $this->desencriptarKey(base64_decode($tesoreriaConceptosDto->getId() ));
            $this->buscarConceptoPorId( $idConceptoDesencriptado );
            $tesoreriaConceptosDto->setId( $idConceptoDesencriptado );
            
            $idGrupoConceptoDesencriptado = $this->desencriptarKey(base64_decode($tesoreriaConceptosDto->getGrupoId() ));
            $tesoreriaConceptosDto->setGrupoId( $idGrupoConceptoDesencriptado );
            
             $idCuentaAuxiliarDesencriptado = $this->desencriptarKey(base64_decode($tesoreriaConceptosDto->getCuentaAuxiliarId() ));
            $tesoreriaConceptosDto->setCuentaAuxiliarId( $idCuentaAuxiliarDesencriptado );
            $this->iServicioCuentaAuxiliares->buscarCuentaAuxiliarPorId( $idCuentaAuxiliarDesencriptado);


            $this->iServicioConceptos->buscarGrupoConceptoPorId( $idGrupoConceptoDesencriptado);
            $this->repositoryDynamicsCrud->updateInfo($this->tablaconceptos, $tesoreriaConceptosDto->toArray(), $idConceptoDesencriptado);
            
            return response()->json("Registro actualizado exitosamente");
        } catch (\Throwable $th) {
            return response($th->getMessage(), $th->getCode());
        }
    }

    public function eliminarConceptos($id){
      try {
          $idConceptoDesencriptado = $this->desencriptarKey(base64_decode($id));
        $this->buscarConceptoPorId( $idConceptoDesencriptado );
        $this->repositoryDynamicsCrud->deleteInfoAllOrById($this->tablaconceptos, $idConceptoDesencriptado);
          return response("Registro eliminado", Response::HTTP_ACCEPTED);
      } catch (\Throwable $th) {
            return response($th->getMessage(), $th->getCode());
      }
    } 

    public function buscarConceptoPorId(String $id){

        $sql = "SELECT * FROM $this->tablaconceptos tc WHERE tc.id = '$id'";
        $response = $this->repositoryDynamicsCrud->sqlFunction( $sql);
        if(!$response){
            throw new \Exception("No se encontro ningun concepto ", Response::HTTP_NOT_FOUND);
        }
        return $response;
    }


    private function encriptarKey(string $id): string
    {
        return EncryptionFunction::StaticEncriptacion($id);
    }
    private function desencriptarKey(string $id): string
    {
        return EncryptionFunction::StaticDesencriptacion($id);
    }
}