@extends('layouts.superAdmin_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')
<div class="container justify-content-end">
    <div id="notificacion" class="container-sm"></div>
</div>

<div class="container">

    <h3>GESTIÓN DE MIGRACIONES</h3>
    <span></span>

    <div class="container">
        <a href="#Crear" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createMigration" role="button">Crear Nueva Migracion</a>
        <a id="validarbd" class="btn btn-primary mb-3" role="button">Actualizar Data Bases</a>
        <a id="compararbd" class="btn btn-primary mb-3" role="button">Comparar Data Bases</a>

        <table id="compactData" class="dt-head-center shadow border table-responsive table table-hover  table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</TH>
                    <th scope="col">TABLA</TH>
                    <th scope="col">CAMPO</TH>
                    <th scope="col">ATRIBUTO</TH>
                    <th scope="col">EJECUCION</TH>
                    <th scope="col">ESTADO</TH>
                    <th scope="col">SCRIPT</TH>
                    <th scope="col">Conexiones en empresas no realizadas</TH>
                    <th scope="col">ACCIONES</TH>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataMigraciones as $migracion)
                <tr>
                    <td>{{ $migracion->id }}</td>
                    <td>{{ $migracion->tabla }}</td>
                    <td>{{ $migracion->campo }}</td>
                    <td>{{ $migracion->atributo }}</td>
                    <td>{{ $migracion->accion }}</td>
                    <td>{{ $migracion->estado }}</td>
                    <td>{{ $migracion->script_db }}</td>
                    <td>{{ $migracion->conexion_empresa_no_realizada }}</td>
                    <td class="text-center m-0">
                        <button id="actualizarMigracion" data-id="{{$migracion->id}}" data-tabla="{{ $migracion->tabla }}" data-campo="{{$migracion->campo}}" data-atributo="{{ $migracion->atributo }}" data-accion="{{$migracion->accion }}" data-script_db="{{$migracion->script_db }}" data-bs-toggle="modal" data-bs-target="#editarMigracion" href="#Edit" data-bs-toggle="modal" data-bs-target="#editMigracion" class="btn btn-info">
                            <img src="{{ asset('assets/svg/regular/pen-to-square.svg') }}" width="24"></button>

                        <button id="modalDeleteMigration" class="btn btn-danger delete" data-bs-target="#deleteMigration" data-bs-toggle="modal" data-id="{{ $migracion->id }}"><img id="whiteSVG" src="{{ asset('assets/svg/regular/trash-can.svg') }}" width="24"></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@include('modulo_configuracion/erp_migraciones/modals')
@endsection


@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>

<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/Tables.js') }}"></script>
<script src="{{asset('assets/js/modulo_configuracion/navbar/erp_migraciones/main.js')}}"></script>
<script src="{{asset('assets/js/modulo_configuracion/navbar/erp_migraciones/servicesMigrations.js')}}"></script>
@endsection