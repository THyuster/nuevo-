@extends('layouts.inventario_vistapadre')
@extends('dashboard')
@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet">
{{--
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css"> --}}
@endsection
@section('contenidoPrincipal')

<div class="container">
    <h4 class="mt-2">Creacion de marca :</h4>

    {{--Notificación alerta general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

    <div class="container">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createMarcas"
            role="button">Crear Marca</button>

        <table id="tabla">

        </table>
    </div>
</div>

@include('modulo_inventarios/marcas/modals')
@endsection
@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/datatables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>

<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_inventarios/marcas/Service.js')}}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>

<script>
    $(document).ready(function () {
        cargarDatos(url, buttonsModal, "#tabla", camposExcluir);
    });
</script>

@endsection