@extends('layouts.logistica_vistapadre')
 
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet" />
@endsection

@section('contenidoPrincipal')

<div class="container">
    
    <h5 class="mb-3 mt-2">Ficha técnica de vehículos:</h5>
    
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#vehiclesCreate">Crear Ficha Técnica</button>
    
    <div id="notificacion"></div>

    <div class="container-sm justify-content-center">

        <div class="d-flex justify-content-center">
            <div id="loading_spinner" class="spinner-border" role="status" style="display: block;">
                <span class="sr-only"></span>
            </div>
        </div>

        <table id="tabla"></table>

    </div>

</div>

<!-- CSS para ocultar las columnas que exceden las 6 primeras -->
<style>
    .miTabla td:nth-child(n+7),
    .miTabla th:nth-child(n+7) {
      display: none;
    }
</style>
  

@include('modulo_logistica/vehiculos/modal_extenseData')
@endsection

@section('js')
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatablesBS.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
    <script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
    <script src="{{ asset('assets/js/components/multiwindow.js') }}"></script>
    <script src="{{ asset('assets/js/modulo_logistica/Vehicles/Services.js') }}"></script>
    <script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/modulo_logistica/Vehicles/Main.js') }}"></script>

    <script>
        $(document).ready(async function () {
            const spinner = document.querySelector("#loading_spinner")
            await cargarDatos(url, buttonsModal, "#tabla", camposExcluir, orden,camposIncluir);
            spinner.style.display = "none"
        });
    </script>
@endsection