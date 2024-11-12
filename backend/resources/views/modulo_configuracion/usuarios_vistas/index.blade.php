@extends('layouts.configuracion_vistapadre')
@extends('dashboard')




@section('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection



@section('contenidoPrincipal')



<h2></h2>
<h2>GESTION DE VISTAS</h2>


<div class="container">


    <a href="usuarios_vistas/create" class="btn btn-primary">Crear Nueva Vista</a>
    <h2></br></h2>

    <table id="vistas" class="table table-blue table-striped mt-4">

        <thead>
            <tr>
                <th scope="col">MODULO</TH>
                <th scope="col">CODIGO</TH>
                <th scope="col">MENU</TH>
                <th scope="col">SUBMENU</TH>
                <th scope="col">VISTA</TH>
                <th scope="col">RUTA</TH>
                <th scope="col">ESTADO</TH>

                <th scope="col">ACCION</TH>
            </tr>
        </thead>

        <tbody>
            @foreach ($vistas as $vista)
            <tr>
                
                <td>{{ $vista->name_modulo }}</td>
                <td>{{ $vista->codigo }}</td>
                <td>{{ $vista->menu }}</td>
                <td>{{ $vista->submenu }}</td>
                <td>{{ $vista->vista }}</td>
                <td>{{ $vista->ruta }}</td>
                <td>{{ $vista->estado }}</td>


                <td>
                    <a href="/usuarios_vistas/{{$vista->id}}/edit" class="btn btn-info">Editar</a>
                    <form action="{{ route ('usuarios_vistas.destroy',$vista->id) }}" class="d-inline formulario-eliminar" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>


</div>



@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- PAGINACION -->
<script>
    $(document).ready(function() {
        $('#grupos').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });

    });
</script>



<!-- VALIDACION DE REGISTRO DUPLICADO -->
@if( session('error') == 'duplicado')
<script>
    Swal.fire('Error !!! , Codigo Ya Existe ....')
</script>
@endif


<!-- INICIO ELIMINACION CON CONFIRMACION -->
@if( session('eliminar') == 'ok')
<script>
    Swal.fire('Borrado!', 'Su Registro Ha Sido Eliminado.', 'success');
</script>
@endif

@if( session('eliminar') == 'no')
<script>
    Swal.fire('Advertencia !!!', 'El Registro Seleccionado se Encuentra en Uso....', 'warning');
</script>
@endif




<script>
    $('.formulario-eliminar').submit(function(e) {

        e.preventDefault(e);

        Swal.fire({
            title: 'Por Favor Confirmar..?',
            text: "Esta Seguro de la Eliminacion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si , Borrar.!'
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
</script>
<!-- INICIO ELIMINACION CON CONFIRMACION  -->



@endsection


@endsection