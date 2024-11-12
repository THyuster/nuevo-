@extends('layouts.activos_fijos_vistapadre')
@extends('dashboard') 
@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet">
{{--
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css"> --}}
@endsection
@section('contenidoPrincipal')

<div class="container">
    <h4 class="mt-2" style="text-transform: uppercase;">ASIGNACIÓN DE TIPOS DE EQUIPOS</h4>

    <span></span>
    {{--Notificación alerta general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

    <div class="container">

        <button class="btn btn-primary mb-3 create_menu" data-bs-toggle="modal"
            data-bs-target="#createActivosFijosTiposEquipo" role="button">Crear tipo de equipo</button>
        {{--Datatable de menus--}}
        <table id="tabla" class="border table-responsive table table-hover  table-striped">

        </table>
    </div>
</div>

@include('modulo_activo_fijo/tipos_equipos/modals')
@endsection
@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/datatables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_activos_fijos/activos_fijos_tipo_vehiculos/Service.js')}}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>

<script>
    $(document).ready(function () {
        cargarDatos(url, buttonsModal, "#tabla", camposExcluir);
    });
</script>
@endsection