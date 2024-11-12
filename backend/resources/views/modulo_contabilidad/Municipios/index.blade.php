@extends('layouts.contabilidad_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')
<?php 
    // print_r(json_encode($municipalitys->original));
    // exit();
?>
<div class="container">
    <h4 class="mt-2" >GESTIÓN DE MUNICIPIOS</h4>
    <span></span>
    {{--Alerta de notificación general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>
    <div class="container">
        {{--boton de creación abre modal--}}
        <a href="#createmunicipality" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createMunicipality" role="button">Crear nuevo municipio</a>
        {{--Datatable de municipalities--}}
        <table id="tabla" class="dt-head-center shadow border table-responsive table table-hover table-striped">
        </table>
    </div>
</div>

@include('modulo_contabilidad/Municipios/modals')
@endsection

@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/Env/Endpoint.js')}}"></script>
{{-- <script src="{{asset('assets/js/components/Tables.js') }}"></script> --}}
<script src="{{asset('assets/js/components/AlertComponent.js') }}"></script>

<script src="{{asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_contabilidad/municipality/service.js') }}"></script>
<script src="{{asset('assets/js/components/CreateTables.js') }}"></script>
{{-- <script src="{{asset('assets/js/modulo_contabilidad/municipality/servicesMunicipality.js')}}"></script>
<script src="{{asset('assets/js/modulo_contabilidad/municipality/main.js')}}"></script> --}}

<script>
    $(document).ready(function () {
        
        cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#tabla", camposExcluir);
    });
</script>

@endsection