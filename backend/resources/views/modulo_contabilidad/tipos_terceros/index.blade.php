@extends('layouts.contabilidad_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')
<div class="container pt-6 pb-5">
    
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>
    <div class="container">
        <h4>GESTIÓN DE TIPOS DE TERCEROS</h4>
        <span></span>
        <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createThirdPartyType" role="button">Crear nuevo tipo de tercero</a>
        
        <table id="compactData" class="dt-head-center shadow border table-responsive table table-hover table-striped">

        </table>
    </div>
</div>

@include('modulo_contabilidad/tipos_terceros/modals')
@endsection

@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{asset('assets/js/components/AlertComponent.js') }}"></script>

<script src="{{asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_contabilidad/thirdparties_type/service.js') }}"></script>
<script src="{{asset('assets/js/components/CreateTables.js') }}"></script>

<script src="{{asset('assets/js/modulo_contabilidad/thirdParties_type/testSearch.js')}}"></script>

<script>
    $(document).ready(function () {
        cargarDatos(`${URL_PETICION_MODULOS}/show`,buttonsModal, "#compactData", camposExcluir);
    });
</script>


@endsection