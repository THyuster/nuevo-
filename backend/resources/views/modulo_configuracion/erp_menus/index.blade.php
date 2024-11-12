@extends('layouts.superAdmin_vistapadre')
@extends('dashboard')
@section('contenidoPrincipal')

<h2>GESTION DE MENUS</h2>



<a href="#/Create" class="btn btn-primary" id="crearMenu" data-bs-toggle="modal" data-bs-target="#createMenu">CREAR</a>
<div class="container">

    <table class="table table-blue table-striped mt-4">
        <thead>
            <tr>
                <th scope="col">ID</TH>
                <th scope="col">MODULO</TH>
                <th scope="col">DESCRIPCIÓN</TH>
                <th scope="col">ESTADO</TH>
            </tr>
        </thead>

        <tbody>
            @foreach ($menus as $menu)
            <tr>
                <td>{{ $menu->descripcion }}</td>
                <td>{{ $menu->estado }}</td>
                <td>
                    <a href="#/Edit" data-id="{{ $menu->modulo_id }}" data-descripcion="{{ $menu->descripcion }}"
                        data-estado="{{ $menu->estado }}" id="editMenus" class="btn btn-success update_menu_form"
                        data-bs-toggle="modal" data-bs-target="#updateMenu">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('modulo_configuracion/erp_menus/modals')
@section('js')
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/Menus/MenusService.js') }}"></script>
<script src="{{ asset('assets/js/Menus/main.js') }}"></script>
@endsection

@endsection