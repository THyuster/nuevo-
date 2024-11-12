@extends('layouts.contabilidad_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')
<div class="container">
    <h3>Gestión de Sucursales</h3>
    <span></span>
    {{--Alerta de notificación general--}}
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>
    <div class="container">
        {{--boton de creación abre modal--}}
        <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createBranch" role="button">Crear nueva sucursal</a>

        <table id="compactData" class="dt-head-center shadow border table-responsive table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">CODIGO</th>
                    <th scope="col">DESCRIPCIÓN</th>
                    <th scope="col">Municipio</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                   
                </tr>
            </thead>
            <tbody class="body">
               @if (empty($branchs))
                   
               @else
                   
               
                @foreach ($branchs as $branch)
                <tr>
                    <td>{{ $branch->id }}</td>
                    <td>{{ $branch->codigo }}</td>
                    <td>{{ $branch->descripcion }}</td>
                    <td>{{ $branch->municipio }}</td>
                    <td>{{ $branch->departamento }}</td>
                    <td><button type="button" id="btnStatusChangeMenu"
                            class="btn {{$branch->estado? 'btn-success': 'btn-warning'}} "
                            data-id="{{$branch->id}}">{{$branch->estado? 'Activo': 'Inactivo'}}</button></td>
    
                    <td class="text-center m-0">
                        <button data-id="{{$branch->id}}"
                              data-codigo="{{$branch->codigo }}"  
                              data-descripcion="{{$branch->descripcion }}" 
                              data-munId="{{ $branch->municipio_id }}" 
                              data-bs-toggle="modal" data-bs-target="#editBranch" 
                              class="btn btn-info editFormModule"><img src="{{ asset('assets/svg/regular/pen-to-square.svg') }}" width="24"></button>
        
                        <button class="btn btn-danger btn-delete deleteBranch" 
                        data-id="{{ $branch->id }}" data-bs-toggle="modal" 
                        data-bs-target="#deleteModalBranch">
                        <img id="whiteSVG" src="{{ asset('assets/svg/regular/trash-can.svg') }}" 
                        width="24"></button>
                    </td>
                </tr>
                @endforeach
                @endif
                
            </tbody>
        </table>
    </div>
</div>

@include('modulo_contabilidad/sucursales/modals')
@endsection

@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{asset('assets/js/components/Tables.js') }}"></script>
<script src="{{asset('assets/js/components/AlertComponent.js') }}"></script>
<script src="{{asset('assets/js/modulo_contabilidad/branch/servicesBranch.js')}}"></script>
<script src="{{asset('assets/js/modulo_contabilidad/branch/main.js')}}"></script>


@endsection