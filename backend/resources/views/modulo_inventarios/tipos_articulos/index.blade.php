@extends('layouts.inventario_vistapadre')
@extends('dashboard')
@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection
@section('contenidoPrincipal')

<div class="container">
    <h4 class="mt-2">ASIGNACIÓN DE TIPO DE ARTÍCULOS</h4>

    <span></span>
    {{--Notificación alerta general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

    <div class="container">

        <button class="btn btn-primary mb-3 create_menu" data-bs-toggle="modal" data-bs-target="#createArticleType"
            role="button">Crear tipo de articulos</button>
        {{--Datatable de menus--}}
        <table id="tabla" class="border table-responsive table table-hover  table-striped">

        </table>
    </div>
</div>

@include('modulo_inventarios/tipos_articulos/modals')
{{-- @include('modulo_inventarios/tipos_articulos/modals_extenseData') --}}
@endsection
@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_inventarios/tipo_articulo/Service.js')}}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>

<script>
    $(document).ready(function () {
        cargarDatos(url,buttonsModal, "#tabla", camposExcluir);
    });
</script>
@endsection