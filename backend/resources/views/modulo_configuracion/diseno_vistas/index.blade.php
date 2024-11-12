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
            <h4 id="titleNavbar" class="mt-2">GESTIÓN NAVBAR - {{ $modulo->modulo_nombre}} - {{$modulo->menu_nombre}} - {{$modulo->nombre_submenu}} - VISTAS</h4>
        @endforeach

        <div class="container">
            <button class="btn btn-primary mb-3 rounded-0" 
                data-bs-toggle="modal" 
                data-bs-target="#createView"
                data-id="{{$id}}" id="btnModalCrear"
                role="button">Crear Vista
            </button>
            {{-- <div class="card card-body rounded-0 p-2"> --}}
            <table id="compactData" class="border table-responsive table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">DESCRIPCIÓN</TH>
                        <th scope="col">RUTA</TH>
                        <th scope="col">ORDEN</TH>
                        <th scope="col">ESTADO</TH>
                        <th scope="col">ACCIONES</TH>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($views))
                        
                    @else
                        @foreach ($views as $view)  
                        <tr>
                            <td>{{ $view->descripcion }}</td>
                            <td>{{ $view->ruta}}</td>
                            <td>{{ $view->orden}}</td>
                            <td><button type="button" id="statusChange" class="btn {{ $view->estado? 'btn-success':'btn-warning'}}" data-id="{{ $view->id}}" >{{ $view->estado? 'Activo':'Inactivo'}}</button></td>

                            <td class="text-center m-0">
                                <a href="#Edit"
                                    data-id="{{ $view->id }}"
                                    data-orden="{{$view->orden}}"
                                    data-submenu_id="{{ $view->submenu_id }}"
                                    data-name="{{ $view->descripcion }}"
                                    data-ruta="{{ $view->ruta }}"
                                    data-bs-toggle="modal" data-bs-target="#editView"
                                    class="btn btn-info editForm"><img src="{{ asset('assets/svg/regular/pen-to-square.svg') }}" 
                                    width="24">
                                </a>
                                <button  class="btn btn-danger deleteView" data-id="{{ $view->id }}">
                                    <img 
                                    id="whiteSVG" 
                                    src="{{ asset('assets/svg/regular/trash-can.svg') }}" 
                                    width="24">
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{-- </div> --}}
        </div>
    </div>
@include('modulo_configuracion/diseno_vistas/modals') 

@endsection

@section('js')
    <script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/js/datatablesBS.js')}}"></script>
    <script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
    <script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>
    <script src="{{ asset('assets/js/components/Tables.js') }}"></script>
    <script src="{{asset('assets/js/modulo_configuracion/navbar/diseno_vistas/servicesVistas.js')}}"></script>
    <script src="{{asset('assets/js/modulo_configuracion/navbar/diseno_vistas/main.js')}}"></script>
@endsection