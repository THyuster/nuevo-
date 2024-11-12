@extends('layouts.inventario_vistapadre')
@extends('dashboard')
@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection
@section('contenidoPrincipal')

<div class="container">
    <h4 class="mt-2">ASIGNACIÓN DE GRUPOS CONTABLES</h4>

    <span></span>
    {{--Notificación alerta general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

    <iv class="container">

        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
            data-bs-target="#createGrupoContable" role="button">Crear Grupo contable</button>

        {{--Datatable de menus--}}

        <div class="div card card-body  ">
            <table id="tabla" class=" border table-responsive table table-hover  table-striped">
          
            </table>
        </div>
</div>
</div>


@include('modulo_inventarios/grupos_contables/modals')
@endsection
@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>


<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>

<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_inventarios/grupo_contables/Service.js')}}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>

<script>
    $(document).ready(function () {
        cargarDatos(url,buttonsModal,"#tabla",camposExcluir);
    });
</script>
@endsection