@extends('layouts.superAdmin_vistapadre')
@extends('dashboard')
@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection
@section('contenidoPrincipal')
<div class="container">
     @foreach ( $descriptionModule as $modulo )
        <h4 id="titleNavbar" class="mt-2 {{ $modulo ->modulo_nombre}}">GESTIÓN NAVBAR - {{ $modulo->modulo_nombre}} - MENÚS</h4>
     @endforeach
    <span></span>
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>
    <div class="container">
        <a href="#Crear" class="btn btn-primary mt-3 mb-3 create_menu" data-bs-toggle="modal" data-bs-target="#createMenus"
            role="button" data-modulo_id="{{$id}}">Crear Menu</a>
        <table id="compactData" class="shadow border table-responsive table table-hover  table-striped">
            <thead>
                <tr>
                    <th scope="col">DESCRIPCIÓN</TH>
                    <th scope="col">ESTADO</TH>
                    <th scope="col">ORDEN</TH>
                    <th scope="col">ACCIONES</TH>
                </tr>
            </thead>
            <tbody>
            @if (empty($menus))                
            @else
                @foreach ($menus as $menu)
                <tr>
                    <td>{{ $menu->descripcion }}</td>
                    <td>{{ $menu->estado? 'Activo':'Inactivo'}}</td>
                    <td>{{ $menu->orden}}</td>
                    <td class="text-center m-0">
                        <button class="btn btn-outline-dark" id="submenu" data-name="{{ $menu->descripcion }}" data-id="{{$menu->id}}" > Submenu </button>
                        <button type="button" id="btnStatusChangeMenu" class="btn {{$menu->estado? 'btn-success': 'btn-warning'}}" data-id="{{$menu->id}}">{{$menu->estado? 'Activo': 'Inactivo'}}</button>
                        <a id="editMenu" href="#Edit" data-id="{{ $menu->id }}" data-nombre="{{ $menu->descripcion }}" data-bs-toggle="modal" data-bs-target="#editMenus"data-orden="{{$menu->orden}}" class="btn btn-info editForm"><img src="{{ asset('assets/svg/regular/pen-to-square.svg') }}" width="24"></a>
                        <button id="btnDeleteMenu" class="btn btn-danger delete" data-bs-target="#deleteMenus" data-bs-toggle="modal" data-id="{{ $menu->id }}"> <img id="whiteSVG" src="{{ asset('assets/svg/regular/trash-can.svg') }}" width="24"></button>
                    </td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
@include('modulo_configuracion/diseno_menus/modals')
@endsection
@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/Tables.js') }}"></script>
<script src="{{asset('assets/js/modulo_configuracion/navbar/diseno_menus/servicesMenus.js')}}"></script>
<script src="{{asset('assets/js/modulo_configuracion/navbar/diseno_menus/main.js')}}"></script>
@endsection