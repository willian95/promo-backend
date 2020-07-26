<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Empire is one of the unique admin template built on top of Bootstrap 4 framework. It is easy to customize, flexible code styles, well tested, modern & responsive are the topmost key factors of Empire Dashboard Template" />
        <meta name="keywords" content="bootstrap admin template, dashboard template, backend panel, bootstrap 4, backend template, dashboard template, saas admin, CRM dashboard, eCommerce dashboard">
        <meta name="author" content="" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

        <link rel="stylesheet" href="{{ url('admin/assets/fonts/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ url('admin/assets/fonts/ionicons.css') }}">
        <link rel="stylesheet" href="{{ url('admin/assets/fonts/linearicons.css') }}">
        <link rel="stylesheet" href="{{ url('admin/assets/fonts/open-iconic.css') }}">
        <link rel="stylesheet" href="{{ url('admin/assets/fonts/pe-icon-7-stroke.css') }}">
        <link rel="stylesheet" href="{{ url('admin/assets/fonts/feather.css') }}">

        <link rel="stylesheet" href="{{ url('admin/assets/css/bootstrap-material.css') }}">
        <link rel="stylesheet" href="{{ url('admin/assets/css/shreerang-material.css') }}">
        <link rel="stylesheet" href="{{ url('admin/assets/css/uikit.css') }}">

        <link rel="stylesheet" href="{{ url('admin/assets/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

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
                        <a class="nav-link" href="{{ url('/admin/ads/index') }}">Publicidades</a>
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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{ url('admin/assets/js/pace.js') }}"></script>
        <script src="{{ url('admin/assets/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ url('admin/assets/libs/popper/popper.js') }}"></script>
        <script src="{{ url('admin/assets/js/bootstrap.js') }}"></script>
        <script src="{{ url('admin/assets/js/sidenav.js') }}"></script>
        <script src="{{ url('admin/assets/js/layout-helpers.js') }}"></script>
        <script src="{{ url('admin/assets/js/material-ripple.js') }}"></script>

        <script src="{{ url('admin/assets/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

        <!--<script src="{{ url('admin/assets/js/demo.js') }}"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="{{ url('admin/assets/js/analytics.js') }}"></script>
        <script src="{{ asset('/js/app.js') }}"></script>

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