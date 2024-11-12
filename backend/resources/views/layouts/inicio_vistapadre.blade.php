@php
use App\ViewsBlade;
@endphp
<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">

</head>

<body>
    @php
    $modulos = new ViewsBlade();
    $modulosx = json_decode($modulos->UsuariosModulos(), true);
    @endphp
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-between h-10">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Modulos
                            </a>
                            <ul id="MainMenu" class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @php
                                foreach ($modulosx as $key) {
                                echo '<li><a class="dropdown-item moduleSelect" id="'.  $key['descripcion'] .'" href="'.  $key['ruta'] .'">' .
                                        $key['descripcion'] .'</a></li>';
                                }
                                @endphp
                            </ul>
                        </li>
                    </ul>
                    <span class="navbar-text "><b>Bienvenido/a</b></span>
                </div>


            </div>

        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    @yield('contenidoPrincipal')

    @yield('js')
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>




</body>

</html>