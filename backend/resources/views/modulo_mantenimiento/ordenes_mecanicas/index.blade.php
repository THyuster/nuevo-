@extends('layouts.srm_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet" />

@endsection

@section('contenidoPrincipal')
<div class="container">
    {{--Alerta de notificación general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>
    <div class="container pt-3 pb-3">
        <h4>Ordenes mecánicas</h4>
        <span></span>
        {{--boton de creación abre modal--}}
        <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createMechanicalOrder" role="button">Crear nueva solicitud mecánica</a>
        <table id="compactData" ></table>
    </div>
</div>
{{-- class="dt-head-center shadow border table-responsive table table-hover table-striped" --}}
@include('modulo_mantenimiento/ordenes_mecanicas/modals')
@endsection

@section('js')
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/js/datatablesBS.js') }}"></script>
<script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js') }}"></script>
<script src="{{asset('assets/js/components/loader.js')}}"></script>

<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{ asset('assets/js/modulo_mantenimiento/ordenes_mecanicas/service.js') }}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
<script src="{{ asset('assets/js/components/validations.js') }}"></script>

<script>
    $(document).ready(function(){
        cargarDatos(
            `${URL_PETICION_MODULOS}/show`,
            buttonsModal,
            "#compactData",
            camposExcluir,
            orden
        )
    })
</script>
@endsection
