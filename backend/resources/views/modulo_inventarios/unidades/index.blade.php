@extends('layouts.inventario_vistapadre')
@extends('dashboard')
@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection
@section('contenidoPrincipal')

<div class="container">
    <h4 class="mt-2">ASIGNACIÓN DE UNIDADES</h4>

    <span></span>
    {{--Notificación alerta general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

    <div class="container">

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUnit" role="button">Crear
            unidad</button>
        {{--Datatable de menus--}}
        <table id="tabla" class="table table-responsive" style="width: 100%">

        </table>

    </div>
</div>

@include('modulo_inventarios/unidades/modals')
@endsection
@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_inventarios/unidades/Service.js')}}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>

<script>
    $(document).ready(function () {
        cargarDatos(url, buttonsModal, "#tabla", camposExcluir);
    });
</script>
@endsection