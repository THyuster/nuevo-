@extends('layouts.contabilidad_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet" />
@endsection

@section('contenidoPrincipal')
<div class="container ">
    
    <h3>Gestión de periodos</h3>
    

        <div class="container justify-content-end">
            <div id="notificacion" class="container-sm"></div>
        </div>

        <div class="align-items-start">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPeriod" role="button">Crear nuevo tipo de comprobante</button>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#cloneFiscalYear" role="button">Clonación de año fiscal</button>
        </div>
        <div class="row">
            <form id="periodFilter">
                <div class="col-2">
                    <div class="align-items-start mb-2">
                        <label for="aFiscal_id"><strong>Año fiscal</strong></label>
                        <select class="form-select" id="afiscal_id" name="afiscal_id" aria-label="Año fiscal" required>
                            <option value="0">Todos</option>
                            @foreach ($fiscalYear as $fiscalYears)
                            <option value="{{$fiscalYears->id}}">{{$fiscalYears->afiscal}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        {{--Espacio para DataTable--}}
        <table id="compactData"></table>
    </div>
</div>
                {{-- <div class="col-2">
                    <button id="filtroPeriodo" class="btn btn-secondary">
                        Filtro anual
                    </button>
                </div> --}}
@include('modulo_contabilidad/periodos/modal')

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
<script src="{{ asset('assets/js/modulo_contabilidad/periods/service.js') }}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
<script src="{{ asset('assets/js/components/validations.js') }}"></script>
<script src="{{ asset('assets/js/components/multiwindow.js') }}"></script>
<script src="{{asset('assets/js/components/autocomplete.js')}}"></script>
<script>
    $(document).ready(function () {
        console.log(`${URL_PETICION_MODULOS}/show`)
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