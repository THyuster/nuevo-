@extends('layouts.superAdmin_vistapadre')
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
    <h4 class="toUpperCase">Licencias</h4>
    {{--boton de creación abre modal--}}

    <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createLicense" role="button">Agregar licencia</a>

    <div class="container">
        <div class="d-flex justify-content-center">
            <div id="loading_spinner" class="spinner-border" role="status" style="display: block;">
                <span class="sr-only"></span>
            </div>
        </div>
        <table id="compactData" class="shadow border table-responsive table table-hover table-striped"></table>
    </div>
</div>

@include('superAdmin/licencias/modal')
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
<script src="{{ asset('assets/js/superAdmin/licenciamiento/service.js') }}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
<script src="{{ asset('assets/js/components/validations.js') }}"></script>

<script>
    $(document).ready(async function() {
        const spinner = document.querySelector("#loading_spinner")
        await cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir, orden);
        spinner.style.display = "none"
    });
</script>


@endsection