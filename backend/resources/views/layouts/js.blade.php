<!-- assets publicos para datatables con bootstrap y librería de bootstrap -->

<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/datatablesBS.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/config.css') }}">
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>

<!--assets de redirección al JS con el formato deseado de las Datatables -->
<script src="{{ asset('assets/js/components/Tables.js') }}"></script>

<!-- -->


<!-- para usar botones en datatables JS -->
<script src="datatables_bootstrp_5/Buttons-2.3.5/js/dataTables.buttons.min.js"></script>
<script src="datatables_bootstrp_5/JSZip-2.5.0/jszip.min.js"></script>
<script src="datatables_bootstrp_5/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="datatables_bootstrp_5/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="datatables_bootstrp_5/Buttons-2.3.5/js/buttons.html5.min.js"></script>



<!-- assets locales de librerías para pdfmake y buttons -->

<!-- VALIDACION DE REGISTRO DUPLICADO -->
@if( session('error') == 'duplicado')
<script>
    Swal.fire('Error !!! , PLACA Ya Existe ....')
</script>
@endif



<!-- INICIO ELIMINACION CON CONFIRMACION -->
@if( session('eliminar') == 'ok')
<script>
    Swal.fire('Borrado!', 'Su Registro Ha Sido Eliminado.', 'success');
</script>
@endif


<!-- SCRIPTS DE DATATABLES RESPONSIVA  -->
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/datatablesBS.js')}}"></script>
<script src="{{asset('assets/js/datatables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/js/Env/Endpoint.js')}}"></script>
<script src="{{ asset('assets/js/components/AlertComponent.js') }}"></script>


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


{{--codigo basico de vista deseada--}}
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">Menu
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li class="position-relative">
            <a class="dropdown-item dropdown-toggle" href="#">submenu</a>
                <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="">
                    vista
                </a>
            </li>
    </ul>
</li>
</ul>
</li>