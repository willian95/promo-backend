@extends("layouts.user")

@section("content")

    <section class="ftco-cover" id="section-landing-hero">
        <img src="{{ asset('user/images/6.png') }}">
        <div class="container">
            <div class="mask">
                <div class="row no-gutters align-items-center justify-content-center text-center ftco-vh-100">
                    <div class="col-md-12 content-b-comilandia">
                        <div  class="site-section hola" id="contact-section" >
                            <h1 >¿QUIERES <BR>PROBAR, <BR>EL PARAISO?</h1>
                            <!-- <p  >Lorem ipsum dolor sit amet.</p> -->
                        </div>
                        <div class="form-group row no-gutters btn-mira-menu">
                            <div  class="col-md-5">
                                <a href="{{ url('/explorer') }}">
                                    <button class="res button">¡Mira el Menú!</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="desc-not">
        <h3><strong>¡SOLO PARA TI! </strong>  Descuento de 30% en todas las compras mayores de 15.000 CLP</h3>
    </section>
    <section class="prom-comilandia">
        <div class="container container-prom-comilandia">
            <div class="row ">
            <div class="col-md-6 prom-prin">

            </div>
            <div class="col-md-6">
                <div class="row cont-prom-img-dest">
                    <div class="col-md-6 prom-sec">

                    </div>
                    <div class="col-md-6 prom-sec">
                        
                    </div>
                </div>
                <div class="row cont-prom-img-dest">
                    <div class="col-md-12 prom-terc">

                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <!--<section class="icons container" id="icons">
        <div class="icons-info">
            <div class="card-icons">
                <div div class="icon-img">
                    <img src="{{ asset('user/images/comida.svg') }}">           
                </div>
                <h5>DISFRUTA COMER</h5>
                <div class="icon-description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>          
            </div>
        </div>
        <div class="icons-info">
            <div class="card-icons">
                <div class="icon-img">
                    <img src="{{ asset('user/images/pez.svg') }}">           
                </div>
                <h5>COMIDA FRESCA</h5>
                <div class="icon-description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
          
            </div>
        </div>
        <div class="icons-info">
            <div class="card-icons">
                <div class="icon-img">
                    <img src="{{ asset('user/images/cafe.svg') }}">           
                </div>
                <h5>BEBIDAS</h5>
                <div class="icon-description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="icons-info">
            <div class="card-icons">
                <div class="icon-img">
                    <img src="{{ asset('user/images/carne.svg') }}">           
                </div>
                <h5>CARNES</h5>
                <div class="icon-description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div> 
            </div>
        </div>      
    </section>-->

    <section class="menu" id="menu" style="margin-top: 80px;">
        <h2>Productos</h2>
        <!-- <div class="container" id="dev-area">

            <div class="row">

                <div class="col-md-4" v-for="post in posts">

                    <div class="card" style="padding-bottom: 20px;">
                        <div class="img-product">
                            <img :src="'{{ url('/images/posts/') }}'+'/'+post.post.image" alt="">
                        </div>
                        <div class="card-body">
                            <div class="card-image-section">
                                <p class="text-center">
                                    <img :src="'{{ url('/') }}'+'/images/users/'+post.post.user.image" alt="">
                                </p>
                                <p class="text-center">
                                    <a class="text-center" :href="'{{ url('/') }}'+'/profile'+'/'+post.post.user_id">@{{ post.post.user.name }}</a>
                                </p>
                            </div>

                            <h5 class="text-center">@{{ post.post.title }}</h5>
                            <p>@{{ post.post.commune.name }}</p>
                            <p class="description-post">@{{ post.post.description }}</p>
                            <p>promedio: @{{ post.overall }} / 5</p>
                            <p>Descuento: <span class="price">- @{{ post.discountPercentage }}%</span></p>
                            <p class="text-center button-show-more">
                                <a :href="'{{ url('/post/show') }}'+'/'+post.post.id">
                                <button class="button">Ver más</button></a>
                            </p>
                        </div>
                    </div>

                </div>

            </div>
               
        </div>              -->
    </section>

    <!-- MENU DESTACADO -->
    <!--<section class="menu-destacado">
        <div class="menu-fav">
            <div class="fav-1">
                <div class="img-fav">
                    <img src="{{ asset('user/images/menu_1.jpg') }}">
                </div>
                <div class="mask-there">
                    <div class="card-info">
                        <div class="price">$50.00</div>
                            <h2 style="color: #fff;">Menu 1</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.</p>
                            <button class="button">Ver más</button>
                        </div>
                    </div>
                </div>
                <div class="fav-1">
                    <div class="img-fav">
                        <img src="{{ asset('user/images/menu_2.jpg') }}">
                    </div>
                    <div class="mask-there">
                        <div class="card-info">
                            <div class="price">$50.00</div>
                            <h2 style="color: #fff;">Menu 2</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <button class="button">Ver más</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
    <!-- FIN MENU DESTACADO -->

    @foreach(App\Ad::inRandomOrder()->take(10)->get() as $ad)

        <div class="owl-carousel owl-theme">
            <!-- <div class="item">
                <a href="{{ $ad->link }}" target="_blank">
                    <div class="card">
                        
                    <img src="{{ asset('user/images/logo.png') }}">
                        <div class="card-body">
                        </div>
                    </div>
                </a>
            </div> -->
            <div class="item">
                <a href="#" target="_blank">
                    <div class="card card-comilandia">
                      <img class="img-prod-comilandia" src="{{ asset('user/images/offer_2.jpg') }}">
                      <h5 class="nombre-producto">Hamburguesa</h5>
                      <h6 class="desc-producto">50% OFF</h6>

                    </div>
                </a>
            </div>
            <div class="item">
                <a href="#" target="_blank">
                    <div class="card card-comilandia">
                      <img class="img-prod-comilandia" src="{{ asset('user/images/offer_2.jpg') }}">
                      <h5 class="nombre-producto">Hamburguesa</h5>
                      <h6 class="desc-producto">50% OFF</h6>

                    </div>
                </a>
            </div>
            <div class="item">
                <a href="#" target="_blank">
                    <div class="card card-comilandia">
                      <img class="img-prod-comilandia" src="{{ asset('user/images/offer_2.jpg') }}">
                      <h5 class="nombre-producto">Hamburguesa</h5>
                      <h6 class="desc-producto">50% OFF</h6>

                    </div>
                </a>
            </div>
            <div class="item">
                <a href="#" target="_blank">
                    <div class="card card-comilandia">
                      <img class="img-prod-comilandia" src="{{ asset('user/images/offer_2.jpg') }}">
                      <h5 class="nombre-producto">Hamburguesa</h5>
                      <h6 class="desc-producto">50% OFF</h6>

                    </div>
                </a>
            </div>
        </div>

    @endforeach

    <!-- FOOTER -->
    <footer>
        <div class="footer " id="footer">
            <div class="container row footer-cont">
                <div class="col-md-5 footer-cont-c5">
                    <h5 class="comilandia-titulo-footer">COMILANDIA</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa deleniti illum a nobis odio vel dolores quaerat odit, repellendus fuga cum nemo eveniet, vero accusantium debitis voluptatum, facere itaque laboriosam!</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-red">Menú del día</h6>
                    <ul>
                        <li>Pedido online</li>
                        <li>Delivery</li>
                        <li>Contáctanos</li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Menú del día</h6>
                    <ul>
                        <li>Pedido online</li>
                        <li>Delivery</li>
                        <li>Contáctanos</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Síguenos</h6>
                    <div class="rs-comilandia">
                        <ul>
                            <li><img src="" alt="">Comilandiafood</li>
                            <li><img src="" alt="">Comilandiafood</li>
                            <li><img src="" alt="">Comilandiafood</li>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- <div class="logo-footer">
                <img src="{{ asset('user/images/logo.png') }}">
            </div>
            <div class="about-footer">
                <h6 style="font-weight: bold">Sobre Nosotros</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="hours">
                <h6 style="font-weight: bold;     margin-left: -25px;">Nuestro Horario</h6>
                <p> Lunes a Viernes <br>
                10.00 hrs a 20:00hrs</p>
            </div> -->
        </div>
    </footer>



@endsection

@push("scripts")

    <script>
        const app = new Vue({
            el: '#dev-area',
            data(){
                return{
                    posts:[]
                }
            },
            methods:{
                
                fetchAuth(){

                    axios.get("{{ url('/api/fetch') }}", {
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    })
                    .then(res => {
                        
                        if(res.data.success == true){
                            this.posts = res.data.posts
                        }

                    })

                },
                fetchGuest(){

                    axios.get("{{ url('/api/guest/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.posts = res.data.posts
                        }

                    })

                }

            },
            created(){
                
                let user = JSON.parse(localStorage.getItem("user"))
                if(user != null){
                    this.fetchAuth()   
                }else{
                    this.fetchGuest()
                }


            }

        })
    </script>

    <script>
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            loop:false,
            dotsEach:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        })
    </script>
    

@endpush