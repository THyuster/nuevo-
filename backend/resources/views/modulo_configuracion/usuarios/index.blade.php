@extends('layouts.configuracion_vistapadre')
@extends('dashboard')

@section('css')
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
@endsection

@section('contenidoPrincipal')

<div class="container">
    
    <div class="container justify-content-end">
        <div id="notificacion" class="container-sm"></div>
    </div>

        <div class="container ">
            <h4>GESTIÓN DE USUARIOS</h4>
            <span></span>   
                <table id="tabla" class="shadow border table-responsive table table-hover  table-striped">
                </table>
            {{-- <thead>
                <tr>
                    <th scope="col">ID</TH>
                    <th scope="col">NOMBRE</TH>
                    <th scope="col">EMAIL</TH>
                    <th scope="col">ADMINISTRADOR</TH>
                    <th scope="col">ESTADO</TH>
                    <th scope="col">ACCIONES</TH>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->administrador }}</td>
                        <td>{{ $usuario->estado }}</td>
                        <td>
                            <form action="{{ route ('usuarios.destroy',$usuario->id) }}" class="d-inline formulario-eliminar" method="POST">
                                <a data-id="{{ $usuario->id }}" data-name={{ $usuario->name }}"
                                    data-admin="{{$usuario->administrador}}" data-bs-toggle="modal" data-bs-target="#editUser"
                                    class="btn btn-info editForm">Editar</a>
                                <a href="/usuarios/{{$usuario->id}}/edit" class="btn btn-info">Editar</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody> 
        </table>--}}
    </div>
</div>
@endsection
@include('modulo_configuracion/usuarios/modals')
@section('js')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
{{-- <script src="{{ asset('assets/js/components/Tables.js') }}"></script> --}}


<script src="{{ asset('assets/js/components/SettingTable.js') }}"></script>
<script src="{{asset('assets/js/modulo_configuracion/usuarios/Service.js')}}"></script>
<script src="{{ asset('assets/js/components/CreateTables.js') }}"></script>
<script>
    $(document).ready(function () {
        cargarDatos(url,buttonsModal,"#tabla",camposExcluir);
    });
</script>

@endsection

{{-- 
<!-- INICIO ELIMINACION CON CONFIRMACION -->
@if( session('eliminar') == 'ok')
<script>
    Swal.fire('Borrado!', 'Su Registro Ha Sido Eliminado.', 'success');
</script>
@endif

@if( session('eliminar') == 'iguales')
<script>
    Swal.fire('No Borrado!', 'No Es Posible Eliminarse Asi Mismo.', 'warning');
</script>
@endif

<script>
    $('.formulario-eliminar').submit(function(e) {

        e.preventDefault(e);

        Swal.fire({
            title: 'Confirmación de eliminación',
            text: "¿Confirma que desea eliminar la asignación?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
        }).then((result) => {

            if (result.isConfirmed) {
                /* Swal.fire(
                'Borrado!',
                'Su Registro Ha Sido Eliminado.',
                'success'
                ) */
                this.submit();
            }
        })

    })
</script> --}}