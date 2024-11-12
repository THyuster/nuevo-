@extends('layouts.contabilidad_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet" />
@endsection

@section('contenidoPrincipal')

<div class="container mb-6 pb-5">

    <div id="notificacion"></div>

    <div class="container-sm justify-content-center">

        <div class="d-flex justify-content-center">
            <div id="loading_spinner" class="spinner-border" role="status" style="display: block;">
                <span class="sr-only"></span>
            </div>
        </div>
        <h5 class="mb-3 mt-3">Gestión de Terceros</h5>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#thirdParty" role="button">Nuevo tercero</button>
        
        <table id="compactData" class="shadow border table-responsive table table-hover table-striped"></table>
        
    </div>

</div>

@include('modulo_contabilidad/terceros/modals_extenseDatas')

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
<script src="{{ asset('assets/js/modulo_contabilidad/thirdParties/service.js') }}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
<script src="{{ asset('assets/js/components/validations.js') }}"></script>
<script src="{{ asset('assets/js/components/multiwindow.js') }}"></script>
<script src="{{ asset('assets/js/components/actualDate.js') }}"></script>
<script src="{{asset('assets/js/components/autocomplete.js')}}"></script>
<script>

    $(document).ready(async function () {
        const spinner = document.querySelector("#loading_spinner")
        await cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir, orden)
        spinner.style.display = "none";
    });
    
</script>

@endsection