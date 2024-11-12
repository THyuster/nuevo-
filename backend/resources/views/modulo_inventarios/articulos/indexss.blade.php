@extends('layouts.inventario_vistapadre')
@extends('dashboard')
@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet" />
@endsection 
@section('contenidoPrincipal')

<div class="container">

    <h4 class="mb-3 mt-2 ">ASIGNACION DE ARTICULOS:</h4>
    
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

    <button id="crear_articulo" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#ArticuloCreate">Crear artículo</button>

    <table id="tabla">
        
    </table>

</div>

@include('modulo_inventarios/articulos/modals')
@include('modulo_inventarios/articulos/modals_extenseDatasss')
@endsection 

@section('js')

<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/datatablesBS.js') }}"></script>
<script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/Env/Endpoint.js') }}"></script> -->
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>

<script src="{{asset('assets/js/modulo_inventarios/articulos/Services.js')}}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
<script src="{{ asset('assets/js/components/validations.js') }}"></script>  
{{-- <script src="{{asset('assets/js/components/autocomplete.js')}}"></script> --}}
<script>
    $(document).ready(function () {
        cargarDatos(url, buttonsModal, "#tabla", camposExcluir,orden);
    });
</script>

@endsection