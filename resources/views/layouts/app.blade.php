<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/scss/app.scss')
</head>
<body>
<nav class="navbar is-black">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
            <img src="{{ asset('img/logo_coar.png') }}" width="150px">
        </a>
    </div>
    <div class="navbar-end">
        @guest
            <div class="navbar-item has-text-centered">
                Proceso único de admisión {{ date('Y')  }}
            </div>
        @endguest
        @auth
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    {{ auth()->user()->username }}
                </a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="{{ route('auth.logout') }}">
                        Cerrar sesión
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>

<section class="main-content columns is-fullheight">
    @auth
    <aside class="column is-3 is-narrow-mobile is-fullheight section is-hidden-mobile has-background-white-ter" style="height:100vh">
        <aside class="menu is-fullheight">
            <p class="menu-label">
                Administración
            </p>
            <ul class="menu-list">
                @role('admin')
                <li><a href="{{ route('page_programacion') }}" class="{{ request()->is('page/programacion') ? 'is-active' : '' }}">Programación</a></li>
                @endrole
                    <li><a href="/" class="{{ request()->is('/') ? 'is-active' : '' }}">Registro de control de asistencia</a></li>
                <li>
                    <p class="pt-5 pb-3">REPORTE</p>
                    <ul>
                        <li><a href="{{ url('/reporte/postulantes/user') }}" class="{{ request()->is('reporte/postulantes/user') ? 'is-active' : '' }}">Mis asistencias registradas</a></li>
                        <li><a href="{{ url('/reporte/postulantes') }}" class="{{ request()->is('reporte/postulantes') ? 'is-active' : '' }}">Asistencia general de postulantes</a></li>
                        <li><a href="{{ url('/reporte/aula') }}" class="{{ request()->is('reporte/aula') ? 'is-active' : '' }}">Asistencia general por aulas</a></li>
                        @role('admin')
                        <li><a href="{{ url('/reporte/registro/asistencia-users') }}" class="{{ request()->is('reporte/registro/asistencia-users') ? 'is-active' : '' }}">Asistencias registradas por usuarios</a></li>
                        @endrole
                        <li><a href="{{ url('/reporte/asistencia/resumen') }}" class="{{ request()->is('reporte/asistencia/resumen') ? 'is-active' : '' }}">Resumen general</a></li>
                    </ul>
                </li>

            </ul>

        </aside>
    </aside>
    @endauth
    <div class="container column is-9 is-fullheight">
        <div class="section">
            @yield('content')
        </div>
    </div>
</section>

    @viteReactRefresh
    @vite('resources/js/app.jsx')
</body>
</html>
