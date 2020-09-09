<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="{{ asset('/user/images/logo.png') }}">
        <!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700|Raleway" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

        <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/open-iconic-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}">
        
        <!--<link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/owl.theme.default.min.css') }}">-->
        <link rel="stylesheet" href="{{ asset('user/css/magnific-popup.css') }}">

        <link rel="stylesheet" href="{{ asset('user/css/bootstrap-datepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/jquery.timepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('user/css/icomoon.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/slick-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('user/css/media.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">

        <link rel="stylesheet" href="{{ asset('owlCarousel/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('owlCarousel/assets/owl.theme.default.min.css') }}">

        <link rel="stylesheet" href="{{ asset('/alertify/css/alertify.css') }}" >
        <link rel="stylesheet" href="{{ asset('/alertify/css/themes/bootstrap.css') }}" >
        
        

        @stack("css")

    </head>
        <div class="elipse">
            <img src="{{ asset('user/images/logo.png') }}">
        </div>


      <style>
        .elipse{
        background: #a31b27;
        position: fixed;
        z-index: 9999999;
        height: 100%;
        width: 100%;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0;
        }

        </style>

    <body>

        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
                <a class=" menu-logo" href="{{ url('/') }}"><img src="{{ asset('user/images/logo.png') }}"></a>
                <p class="pide-ahora">¡PIDE AHORA!</p>
                <div class="search-comilandia">
                    <input  class="search-comilandia-input" id="search" type="text" placeholder="¿Qué quieres comer?">
                    <a class="search-comilandia-a" href="#">Buscar</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
                </button>

                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <div class="search-comilandia d-n-c">
                        <div class="form">
                                <input  class="search-comilandia-input" type="text" placeholder="¿Qué quieres comer?" >
                                <a class="search-comilandia-a" href="#">Buscar</a>
                            </div>
                        </div>

                        <li class="nav-item active"><a href="{{ url('/') }}" class="nav-link">Inicio</a></li>
                        <li class="nav-item" v-if="authCheck == false">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#myModalogin" >Inicia Sesión</a>
                        </li>
                        
                        <li class="nav-item" v-if="authCheck == false">
                            <a class="nav-link btn-comilandia" href="{{ url('/register') }}">Crear una cuenta</a>
                        </li>
                        <li class="nav-item" v-if="authCheck == true">
                            <a class="nav-link" href="{{ url('/post') }}">Publicar</a>
                        </li>
                        <li class="nav-item" v-if="authCheck == true">
                            <a class="nav-link" href="{{ url('/explorer') }}">Explorar</a>
                        </li>
                        <div class="div-nav-item">
                            <li class="nav-item">
                                <a class="nav-link cont-carrito-span resp-m" href="#"><img class="ico-menu-comilandia carrito-span" src="{{ asset('user/images/cart.png') }}"><span class="ico-menu-comilandia_span ">1</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link resp-m" href="#"><img class="ico-menu-comilandia" src="{{ asset('user/images/useri.png') }}"></a>
                            </li>
                        </div>
                        
                        <!--<li class="nav-item"><a href="#menu" class="nav-link">Menú</a></li>
                        <li class="nav-item"><a href="#footer" class="nav-link">Contacto</a></li>-->
                    </ul>
                
                    <div class="dropdown">
                        <button @click="showListUser()" v-if="name" class="button dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @{{ name }}
                        </button>
                        <div id="list-user" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a v-if="roleId == 2" class="dropdown-item" href="{{ url('/my-profile') }}">Mi Perfil</a>
                            <a v-if="roleId == 2" class="dropdown-item" href="{{ url('/my-sales') }}">Mis Ventas</a>
                            <a v-if="roleId == 2" class="dropdown-item" href="{{ url('/my-purchases') }}">Mis Compras</a>
                            <a v-if="roleId == 1" class="dropdown-item" href="{{ url('/admin/dashboard') }}">Dashboard</a>
                            <a class="dropdown-item" href="#" @click="logout()">Cerrar sesión</a>
                        </div>
                    </div>
             
                </div>
          </div>
        </nav>
 <!-- The Modal -->
 <div class="modal" id="myModalogin">
    <div class="modal-dialog">
      <div class="modal-content modal-login-cont">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Iniciar Sesión</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <section class=" collapse-login-content" id="section-login">
                        {{--<img src="{{ asset('user/images/6.png') }}">--}}
                    
                 <div class="container-fluid collapse-login-content_container">
                     <!-- <h3 class="ftco-heading ftco-animate mb-3">Inicio de Sesión</h3> -->
                     <div class="form-group row">
                         <div class="col-md-12 mb-4">
                             <label for="email">Email</label>
                             <input class="input-login" id="email" type="email" class="form-control" placeholder="Email" v-model="email">
                         </div>
                         <div class="col-md-12 ">
                             <label for="password">Password</label>
                             <input class="input-login" id="password" type="password" class="form-control" placeholder="Contraseña" v-model="password">
                         </div>
                     </div>
                     <div style="display: flex; justify-content: center; margin-top: 10px;"class="form-group row">
                         <div style="text-align: center;" class="col-md-6">
                             <a class="res button" @click="login()">Entrar</a>
                         </div>
                     </div>
                     <a class="text-center text-secondary" href="{{ url('/forgot-password') }}">Olvidé mi contraseña</a>                              
                 </div>
            </section>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
        
      </div>
    </div>
  </div>


       

        @yield("content")

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<!-- jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->


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
        <script src="{{ asset('/user/alertify/alertify.min.js') }}"></script>
        <script src="{{ asset('owlCarousel/owl.carousel.min.js') }}"></script>
        <!--<script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/popper.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>-->
        <script src="{{ asset('/js/app.js') }}"></script>

        @stack("scripts")
        <script>
            $(document).ready(function () {
                setTimeout(function () {
                $('.elipse').fadeOut(300);
                }, 3000)
            });

        </script>
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
                    },
                    showListUser(){

                        if($("#list-user").hasClass("show")){
                            
                            $("#list-user").removeClass("show")

                        }else{

                            $("#list-user").addClass("show")

                        }

                    }

                },
                created(){

                    this.checkAuth()

                }

            })
        </script>

        <script>
            alertify.set('notifier','position', 'top-right');
        </script>

    </body>
</html>