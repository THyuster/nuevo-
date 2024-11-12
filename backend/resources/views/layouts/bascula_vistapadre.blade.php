@php
use App\ViewsBlade;
@endphp

<!doctype html>
<html lang="en">


<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

@yield('css')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css')}}">
{{--
<link rel="stylesheet" href="{{ asset('assets/css/bascula.css')}}"> --}}
<link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
<title>Bascula/MLA</title>
</head>

<body>
    @php
    $modulos = new ViewsBlade();
    $modulosx = json_decode($modulos->UsuariosModulos(), true);
    $data = $modulos->autoConstruccionNavbar();
    $data = json_encode($data);
    $data = json_decode($data);
    // exit() ;
    @endphp
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-between h-10">
            <div class="container-fluid">
                <a class="navbar-brand" href=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Modulos
                            </a>
                            <ul id="MainMenu" class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @php
                                foreach ($modulosx as $key) {
                                echo '<li><a class="dropdown-item" href="/' . $key['ruta'] . '">' . $key['modulos'] .
                                        '</a></li>';
                                }
                                @endphp
                            </ul>
                        </li>
                        @foreach ($data as $modulo)
                        @if ($modulo->nombre_modulo === "Bascula")
                            @if (count($modulo->menu) > 0)
                                @foreach ($modulo->menu as $item)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $item->menus }}" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $item->menus }}
                                        </a>
                                        @if (count($item->submenus) > 0)
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $item->menus }}">
                                                @foreach ($item->submenus as $submenu)
                                                    <li class="position-relative">
                                                        <a class="dropdown-item dropdown-toggle" href="#">{{ $submenu->descripcion_submenu }}</a>
                                                        <ul class="dropdown-menu">
                                                            @foreach ($submenu->vistas as $vista)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ url($vista->ruta_vista) }}">
                                                                        {{ $vista->descripcion_vista }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        @endif
                    @endforeach

                    </ul>
                </div>
            </div>
        </nav>
    </div>

    @yield('contenidoPrincipal')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    @yield('js')
</body>

</html>
