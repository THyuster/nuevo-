@extends('layouts.configuracion_vistapadre')
@extends('dashboard')

@section('css')
    <link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

<div class="container mt-2"> 
<h4> Clientes empresariales</h4>
    <table id="compactData" class="border table-responsive table table-hover table-striped">
</div>

@include('modulo_configuracion/erp_clientes/modal')
@section('js')
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/js/datatablesBS.js') }}"></script>
<script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js') }}"></script>

<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{ asset('assets/js/erp_costumers/service.js') }}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
<script src="{{ asset('assets/js/components/validations.js') }}"></script>
<script src="{{ asset('assets/js/components/actualDate.js') }}"></script>
<script src="{{asset('assets/js/components/autocomplete.js')}}"></script>
<script>
    $(document).ready(function () {
        cargarDatos(
            `${URL_PETICION_MODULOS}/show`,
            buttonsModal,
            "#compactData",
            camposExcluir,
            orden
        );
    });
</script>
@endsection
@endsection