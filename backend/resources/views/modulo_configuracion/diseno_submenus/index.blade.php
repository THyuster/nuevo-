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
    
    @foreach ( $construccionInmersion as $modulo )
        <h4 id="titleNavbar" class="mt-2 {{ $modulo ->modulo_nombre}}">GESTIÓN NAVBAR - {{ $modulo->modulo_nombre}} - {{$modulo->menu_nombre}} - SUBMENUS</h4>
    @endforeach
    <div class="container">
        
        {{-- <a class="btn btn-light mb-3 me-2 " type="button" href="{{route('diseno_menus.index')}}"><img src="{{ asset('assets/svg/solid/arrow-left-long.svg') }}" width="24"></a> --}}
        {{-- <a class="btn btn-light mb-3 me-2 " type="button" href="{{route('diseno_submenu.index')}}"><img src="{{ asset('assets/svg/solid/arrow-right-long.svg') }}" width="24"></a> --}}
        <button id="crear" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#CreateSubmenu" data-id="{{$id}}">Crear submenú</button>
            
        <table id="compactData" class="shadow border table-responsive table table-hover  table-striped">
            <thead>
                <tr>
                    <th scope="col">DESCRIPCIÓN</TH>
                    <th scope="col">ESTADO</TH>
                    <th scope="col">ACCIONES</TH>
                    <th scope="col">ORDEN</TH>

                </tr>
            </thead>
            <tbody>
             @if(empty($submenus))
             @else
                @foreach ($submenus as $submenu)  
                <tr>
                    <td>{{ $submenu->descripcion }}</td>
                    <td>{{ $submenu->estado? 'Activo':'Inactivo'}}</td>
                    <td class="text-center m-0">
                        <button data-id="{{ $submenu->id }}"  class="btn btn-outline-dark routeView" href=""> Vista </button>
                        <button type="button" id="statusChange" class="btn {{ $submenu->estado? 'btn-success':'btn-warning'}}" data-id="{{ $submenu->id}}" >{{ $submenu->estado? 'Activo':'Inactivo'}}</button>
                        <a href="#Edit"
                            data-id="{{ $submenu->id }}"
                            data-name="{{ $submenu->descripcion }}"
                            data-orden="{{$submenu->orden}}"
                            data-bs-toggle="modal" data-bs-target="#editSubmenu" data-idMenu ="{{$id}}"
                            class="btn btn-info editForm"><img src="{{ asset('assets/svg/regular/pen-to-square.svg') }}" width="24"></a>
                        <button  class="btn btn-danger" id="delete" data-bs-toggle="modal" data-bs-target="#deleteSubmenuModal"
                            data-id="{{ $submenu->id }}">
                            <img id="whiteSVG" src="{{ asset('assets/svg/regular/trash-can.svg') }}" width="24">
                        </button>
                    </td>
                    <td>{{ $submenu->orden }}</td>
                </tr>
                @endforeach
             @endif
            </tbody>
        </table>
    </div>
</div>


@include('modulo_configuracion/diseno_submenus/modals')

@endsection
@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>

<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{ asset('assets/js/components/Tables.js') }}"></script>

<script src="{{asset('assets/js/modulo_configuracion/navbar/diseno_submenus/servicesSubmenus.js')}}"></script>
<script src="{{asset('assets/js/modulo_configuracion/navbar/diseno_submenus/main.js')}}"></script>

@endsection