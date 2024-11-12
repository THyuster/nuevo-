@extends('layouts.superAdmin_vistapadre')
@extends('dashboard')
@section('css')
    <link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet" />
@endsection
@section('contenidoPrincipal')

<div class="container">

    <h4 class="mt-3">Super Administrador</h4>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSuperSU" role="button">Crear SAdministrador</button>

    <div class="container justify-content-end">
        <div id="notificacion"></div>
    </div>

    <div>
        <div class="d-flex justify-content-center">
            <div id="loading_spinner" class="spinner-border" role="status" style="display: block;">
                <span class="sr-only"></span>
            </div>
        </div>
        <table id="tabla"></table>

    </div>

</div>
@include('superAdmin/super_administrador/modal')
@endsection
@section('js')
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/datatablesBS.js') }}"></script>
<script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{ asset('assets/js/superAdmin/superAdministrador/Services.js') }}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>

<script>
    $(document).ready(async function () {
        const spinner = document.querySelector("#loading_spinner")
        await cargarDatos(`/su_administrador/crear/superadmin/show`, buttonsModal, "#tabla", camposExcluir);
        spinner.style.display = "none"
    });
</script>
@endsection