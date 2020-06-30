<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">

        <title>Comilandia</title>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="dev-navbar">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/category/index') }}">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/bank/index') }}">Bancos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/transfers/index') }}">Transferencias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/posts/index') }}">Publicaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/users/index') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click="logout()">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </nav>

        @yield("content")

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/js/popper.min.js') }}"></script>
        <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin/js/app.js') }}"></script>

        @stack("scripts")

        <script>
            const navbar = new Vue({
                el: '#dev-navbar',
                data(){
                    return{
                        name:"",
                        roleId:"",
                        authCheck:false
                    }
                },
                methods:{
                
                    logout(){
                        localStorage.removeItem("user")
                        this.authCheck = false
                        this.name = ""
                        this.roleId = ""
                        window.location.href="{{ url('/') }}"
                    }

                }

            })
        </script>

    </body>
</html>