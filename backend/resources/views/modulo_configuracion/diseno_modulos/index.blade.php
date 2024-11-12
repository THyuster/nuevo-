@extends('layouts.superAdmin_vistapadre')
@extends('dashboard')

@section('css')
    <link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')
    <div class="container">
        {{-- Alerta de notificación general --}}
        <div class="container justify-content-end">
            <div id="notificacion" class="container-sm"></div>
        </div>
        <div class="container">
            <h4 class="mt-2">GESTIÓN NAVBAR - MODULOS</h4>
            <span></span>
            {{-- boton de creación abre modal --}}
            <a href="#Crear" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModules"
                role="button">Crear Nuevo Módulo</a>
            <a id="validarbd" class="btn btn-primary mb-3" role="button">Validar Base Datos</a>
            <a href="{{ route('erp_migraciones.index') }}" class="btn btn-primary mb-3" role="button">Gestion de
                Migraciones</a>
            {{-- Datatable de modulos --}}
            <table id="compactData" class="dt-head-center shadow border table-responsive table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">TIPO ACCESOo</th>
                        <th scope="col">DESCRIPCIÓN</th>
                        <th scope="col">ORDEN</th>
                        <th scope="col">UBICACIÓN</th>
                        <!-- <th scope="col">ESTADO</th> -->
                        <th scope="col">IMAGEN</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>

                <tbody id="refresh" class="body">
                    @foreach ($modulos as $modulo)
                        <tr>
                            <td>{{ $modulo->codigo}}</td>
                            <td>{{ $modulo->tipo_acceso }}</td>
                            <td>{{ $modulo->descripcion }}</td>
                            <td>{{ $modulo->orden }}</td>
                            <td>{{ $modulo->ruta }}</td>
                            <td><img src="{{ $modulo->logo }}" ></td>
                            <!-- <td>{{ $modulo->activo ? 'Activo' : 'Inactivo' }}</td> -->
                            {{-- acciones de la tabla --}}
                            <td class="text-center m-0">
                                {{-- boton de menus --}}
                                <button data-id="{{ $modulo->id }}" data-name="{{ $modulo->descripcion }}"
                                    class="changeRouter btn btn-outline-primary">Menu</button>
                                {{-- boton activo/inactivo --}}
                                <button data-id="{{ $modulo->id }}" data-codigo="{{ $modulo->codigo }}"
                                    data-orden="{{ $modulo->orden }}" data-descripcion="{{ $modulo->descripcion }}"
                                    data-ubicacion="{{ $modulo->ruta }}" type="button"
                                    class="btn {{ $modulo->activo ? 'btn-success' : 'btn-warning' }}"
                                    id="btnState">{{ $modulo->activo ? 'Activo' : 'Inactivo' }}</button>
                                {{-- boton de edicion abre modal --}}
                                <button data-id="{{ $modulo->id }}" data-codigo="{{ $modulo->codigo }}" data-logo="{{$modulo->logo}}"
                                    data-tipo_acceso="{{ $modulo->tipo_acceso }}" data-orden="{{ $modulo->orden }}"
                                    data-descripcion="{{ $modulo->descripcion }}" data-ubicacion="{{ $modulo->ruta }}"
                                    data-bs-toggle="modal" data-bs-target="#editModules"
                                    class="btn btn-info editFormModule"><img
                                        src="{{ asset('assets/svg/regular/pen-to-square.svg') }}" width="24"></button>
                                {{-- boton de borrar --}}
                                <button class="btn btn-danger btn-delete" data-id="{{ $modulo->id }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal"><img id="whiteSVG"
                                        src="{{ asset('assets/svg/regular/trash-can.svg') }}" width="24"></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('modulo_configuracion/diseno_modulos/modals')
@endsection

@section('js')
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/datatablesBS.js') }}"></script>
    <script src="{{ asset('assets/js/Env/Endpoint.js') }}"></script>
    {{-- <script src="{{asset('assets/js/components/test.js') }}"></script> --}}
    <script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
    <script src="{{ asset('assets/js/modulo_configuracion/navbar/diseno_modulos/servicesModules.js') }}"></script>
    <script src="{{ asset('assets/js/modulo_configuracion/navbar/diseno_modulos/main.js') }}"></script>
@endsection
