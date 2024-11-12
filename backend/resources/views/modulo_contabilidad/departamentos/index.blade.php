@extends('layouts.contabilidad_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')
<div class="container">
    <h3>Gestión de departamentos</h3>
    <span></span>
    {{--Alerta de notificación general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>
    <div class="container">
        {{--boton de creación abre modal--}}
        <a href="#createDept" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createDept" role="button">Crear nuevo departamento</a>
        {{--Datatable de Departamentos--}}

        
        <table id="compactData" class="dt-head-center shadow border table-responsive table table-hover table-striped">
           
        </table>
    </div>
</div>

@include('modulo_contabilidad/departamentos/modals')
@endsection

@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/Env/Endpoint.js')}}"></script>

<script src="{{asset('assets/js/components/AlertComponent.js') }}"></script>


<script src="{{asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_contabilidad/departments/service.js') }}"></script>
<script src="{{asset('assets/js/components/CreateTables.js') }}"></script>



<script>
    $(document).ready(function () {
        cargarDatos(`${URL_PETICION_MODULOS}/show`,buttonsModal, "#compactData", camposExcluir);
    });
</script>

@endsection