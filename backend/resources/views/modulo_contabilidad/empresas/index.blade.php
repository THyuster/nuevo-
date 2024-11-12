@extends('layouts.superAdmin_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet" />
@endsection

@section('contenidoPrincipal')

<div class="container mt-3">

    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

    <div class="container">
        <h4>Gestión de empresas</h4>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCompany" role="button">Nueva empresa</button>

        {{--Espacio para DataTable--}}
        <table id="compactData"></table>
    </div>
</div>

@include('modulo_contabilidad/empresas/modal')


@endsection
@section('js')
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/js/datatablesBS.js') }}"></script>
<script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js') }}"></script>
<script src="{{asset('assets/js/components/loader.js')}}"></script>
<script src="{{ asset('assets/js/components/multiwindow.js') }}"></script>

<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{ asset('assets/js/modulo_contabilidad/companies/service.js') }}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
<script src="{{ asset('assets/js/components/validations.js') }}"></script>
{{-- <script src="{{ asset('assets/js/components/actualDate.js') }}"></script> --}}
<script src="{{asset('assets/js/components/autocomplete.js')}}"></script>
<script>
    $(document).ready(function() {
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