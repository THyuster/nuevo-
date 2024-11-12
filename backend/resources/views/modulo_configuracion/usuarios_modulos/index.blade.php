@extends('layouts.configuracion_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')

<div class="container">
    {{--Notificación de alerta general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>
    <div class="container">
        <h4 class="mt-2">ASIGNACIÓN DE PERMISOS DE USUARIOS A MODULOS :</h4>
        <span></span>
        <a href="#Crear" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPermisos" role="button">Crear Asignación</a>
        {{--Datatable con estilo compacto--}}
        <table id="compactData" class="shadow border table-responsive table table-hover  table-striped">
            <thead>
                <tr>
                    <th scope="col">USUARIO</TH>
                    <th scope="col">MODULO</TH>
                    <th scope="col">ACCIONES</TH>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->modulo }}</td>
                    <td class="text-center m-0">
                        <a data-id="{{ $usuario->id }}" data-userId="{{ $usuario->users_id }}"
                            data-previos="{{$usuario->modulo}}" data-nombre="{{ $usuario->name }}" href="#Edit" data-bs-toggle="modal" data-bs-target="#editPermisos" class="btn btn-info editForm">Editar</a>
                        <button data-bs-toggle="modal" data-bs-target="#deletePermission" class="btn btn-danger"
                            id="deleteBtn" data-id="{{ $usuario->id }}">Borrar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('modulo_configuracion/usuarios_modulos/modals')
@endsection

@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js')}}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/Tables.js') }}"></script>
<script src="{{ asset('assets/js/modulo_configuracion/seguridad/permissionsModules/userModuleAssignment.js')}}"></script>
<script src="{{ asset('assets/js/modulo_configuracion/seguridad/permissionsModules/main.js') }}"></script>
@endsection


{{--
    Nombres de variables en frontend:
    -modales: 
    -alertas:
    -Javascript:
    -Controladores:
    -assets:

    --}}