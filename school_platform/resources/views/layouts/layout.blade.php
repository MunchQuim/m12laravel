<!--                         <li class="nav-item">
                            <a class="nav-link" href="{{route('projects.index') }}">Projects</a>
                        </li> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'School Platform')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home')}}">School Platform</a>
            
            <div class="collapse navbar-collapse">
                <!-- este comando hace el chekeo de autorizacion, es decir, que has iniciado sesion -->
                @auth 
                    <p class="font-weight-bold">Bienvenido, <strong>{{ auth()->user()->name }}</strong></p>
                @endauth
                
                <ul class="navbar-nav ms-auto"><!-- obtiene el rol de la vista que lo extiende, asegurar que esa vista recibe el rol -->
                @switch($role) 
                    @case('admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="border: none; background: none; cursor: pointer;">Cerrar sesión</button>
                            </form>
                        </li>
                        @break
                    @case('teacher')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Students</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="border: none; background: none; cursor: pointer;">Cerrar sesión</button>
                            </form>
                        </li>
                        @break
                    @case('student')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="border: none; background: none; cursor: pointer;">Cerrar sesión</button>
                            </form>
                        </li>
                        @break
                    @case('noRole')
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        @break
                    @default
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                @endswitch
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content') 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>





</body>

</html>