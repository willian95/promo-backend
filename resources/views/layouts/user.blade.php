<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <link rel="icon" href="assets/images/comida.svg">
        <meta name="description" content="Free Template by Free-Template.co" />
        <meta name="keywords" content="free bootstrap 4, free bootstrap 4 template, free website templates, free html5, free template, free website template, html5, css3, mobile first, responsive" />
        <meta name="author" content="Free-Template.co" />
        
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700|Raleway" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/open-iconic-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}">
        
        <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/magnific-popup.css') }}">

        <link rel="stylesheet" href="{{ asset('user/css/bootstrap-datepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/jquery.timepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('user/css/icomoon.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/slick-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/media.css') }}">
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('user/images/logo.jpg') }}"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
                </button>

                <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="#" class="nav-link">Inicio</a></li>
                    <li class="nav-item" v-if="authCheck == false">
                        <a class="nav-link" href="{{ url('login') }}">Login</a>
                    </li>
                    <li class="nav-item" v-if="authCheck == false">
                        <a class="nav-link" href="{{ url('/register') }}">Register</a>
                    </li>
                    <li class="nav-item" v-if="authCheck == true">
                        <a class="nav-link" href="{{ url('/post') }}">Publicar</a>
                    </li>
                    <li class="nav-item" v-if="authCheck == true">
                        <a class="nav-link" href="{{ url('/explorer') }}">Explorar</a>
                    </li>
                    <li class="nav-item" v-if="authCheck == true">
                        <a class="nav-link" href="{{ url('/my-purchases') }}">Mis Compras</a>
                    </li>
                    <li class="nav-item" v-if="authCheck == true">
                        <a class="nav-link" href="{{ url('/my-sales') }}">Mis Ventas</a>
                    </li>
                    <li class="nav-item" v-if="authCheck == true">
                        <a class="nav-link" href="{{ url('/my-profile') }}">Mi Perfil</a>
                    </li>
                    <li class="nav-item" v-if="authCheck == true">
                        <a class="nav-link" href="#" @click="logout()">Cerrar sesión</a>
                    </li>
                    <!--<li class="nav-item"><a href="#menu" class="nav-link">Menú</a></li>
                    <li class="nav-item"><a href="#footer" class="nav-link">Contacto</a></li>-->
                </ul>
                <button class="button" v-if="name">@{{ name }}</button>
                </div>
            </div>
        </nav>

        @yield("content")

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="{{ asset('user/js/jquery.min.js') }}"></script>
        <script src="{{ asset('user/js/popper.min.js') }}"></script>
        <script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('user/js/jquery.easing.1.3.js') }}"></script>
        <script src="{{ asset('user/js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('user/js/jquery.magnific-popup.min.js') }}"></script>

        <script src="{{ asset('user/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('user/js/jquery.timepicker.min.js') }}"></script>
        
        <script src="{{ asset('user/js/jquery.animateNumber.min.js') }}"></script>
        <script src="{{ asset('user/js/slick.min.js') }}"></script>
        <script src="{{ asset('user/js/setting-slick.js') }}"></script>

        <script src="{{ asset('user/js/main.js') }}"></script>
        <!--<script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/popper.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>-->
        <script src="{{ asset('/js/app.js') }}"></script>

        @stack("scripts")

        <script>
            const navbar = new Vue({
                el: '#ftco-navbar',
                data(){
                    return{
                        name:"",
                        roleId:"",
                        authCheck:false
                    }
                },
                methods:{
                    
                    checkAuth(){

                        let user = JSON.parse(localStorage.getItem("user"))
                        if(user != null){
                            this.authCheck = true
                            this.name = user.name
                            this.roleId = user.role_id
                        }
                    },
                    logout(){
                        localStorage.removeItem("user")
                        this.authCheck = false
                        this.name = ""
                        this.roleId = ""
                        window.location.href="{{ url('/') }}"
                    }

                },
                created(){

                    this.checkAuth()

                }

            })
        </script>

    </body>
</html>