@extends('layouts.nomina_vistapadre')
@extends('dashboard')
@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet">
@endsection
@section('contenidoPrincipal')

<div class="container">
    <h4 class="mt-2" style="text-transform: uppercase;">Centros de trabajo</h4>

    {{--Notificación alerta general--}}
    <div id="notificacion"></div>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCentroTrabajo" role="button">Crear Centro Trabajo</button>

    <div class="container-sm justify-content-center">
        <table id="tabla"></table>
    </div>

</div>

@include('modulo_nomina/centro_trabajo/modals')
@endsection
@section('js')

<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/datatables.responsive.min.js')}}"></script>

<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>

<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_nomina/centro_trabajo/Services.js')}}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>

<script>
    $(document).ready(cargarDatos(url, buttonsModal, "#tabla", camposExcluir));
</script>
@endsection