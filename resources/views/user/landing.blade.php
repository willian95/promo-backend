@extends("layouts.user")

@section("content")

    <section class="ftco-cover" id="section-landing-hero">
        <div id="demo" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators indicadores-banner">
                <li class="redondo" data-target="#demo" data-slide-to="0" class="active"></li>
                <li class="redondo" data-target="#demo" data-slide-to="1"></li>
                <li class="redondo" data-target="#demo" data-slide-to="2"></li>
            </ul>


            <div class="carousel-inner">
                @foreach(\App\Carousel::all() as $carousel)
                    <div class="carousel-item active">
                        <div class="mask"></div>
                        <img src="{{ $carousel->image }}">
                        <div class="container cont-inf-banner">
                                <div class="row no-gutters align-items-center justify-content-center text-center ftco-vh-100">
                                    <div class="col-md-12 content-b-comilandia">
                                        <div  class="site-section hola" id="contact-section" >
                                            <h1 >{{ $carousel->text }}</h1>
                                            <!-- <p  >Lorem ipsum dolor sit amet.</p> -->
                                        </div>
                                        <div class="form-group row no-gutters btn-mira-menu">
                                            <div  class="col-md-5">
                                                @if($carousel->link != null)
                                                <a href="{{ $carousel->link }}" target="_blank">
                                                    <button class="res button">¡Mira el Menú!</button>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                @endforeach
                  

            </div>
        </div>

    </section>
    @if(App\HomeNote::first()->status == true)
    <section class="desc-not">
        <h3>{{ App\HomeNote::first()->text }}</h3>
    </section>
    @endif
    <section class="prom-comilandia">
        <div class="container container-prom-comilandia">
            <div class="row ">
            @if(App\HomeBanner::where("id", 1)->first()->status == '1')
                <div class="col-md-6 prom-prin">
                    <!--<div class="cont-cuadro-desc"><div class="cuadro-desc">-50%</div></div>
                <div class="cont-prom-comilandia-info">
                        <h3 class="container-prom-comilandia_h3">Promo agosto</h3>
                        <p class="container-prom-comilandia_p">Disfruta de <span>1</span> increíble</p>
                        <p class="container-prom-comilandia_p"> Cheese Burger + Soda + Cheese Fries</p>
                        <div class="cont-btn-prom-comilandia-pedir-ahora"><a class="btn-prom-comilandia-pedir-ahora" href="#">Pedir ahora</a></div>
                        
                </div>-->
                    <div  class="cont-prom-prom"><div class="img-prom-promo"></div></div>
                    <!--<div class="mask-img-prom"></div>-->
                    <img class="img-carrusel-login" src="{{ App\HomeBanner::where('id', 1)->first()->image }}" alt="promocion" >
                    <!--<div class="cont-img-categoria-des-comilandia"></div><div class="img-categoria-des-comilandia"></div>-->

                </div>

            @endif
            <div class="col-md-6">
                <div class="row cont-prom-img-dest">
                    @if(App\HomeBanner::where('id', 2)->first()->status == '1')
                    <div class="col-md-6 prom-sec">
                    <img class="img-carrusel-login" src="{{ App\HomeBanner::where('id', 2)->first()->image }}" alt="promocion" >
                    </div>
                    @endif
                    @if(App\HomeBanner::where('id', 3)->first()->status == '1')
                    <div class="col-md-6 prom-sec">
                    <img class="img-carrusel-login" src="{{ App\HomeBanner::where('id', 3)->first()->image }}" alt="promocion" >
                    </div>
                    @endif
                </div>
                <div class="row cont-prom-img-dest">
                    @if(App\HomeBanner::where('id', 4)->first()->status == '1')
                    <div class="col-md-12 prom-terc">
                    <img class="img-carrusel-login" src="{{ App\HomeBanner::where('id', 4)->first()->image }}" alt="promocion" >

                    </div>
                    @endif
                </div>
            </div>
            </div>
        </div>
    </section>


    <section class="menu" id="menu" style="margin-top: 80px;" >
        <h2>Productos</h2>      


        <!-- carrusel -->
        <!--<div class="container cont-productos">
            <div class="prueba">
                <div class="single-item-rtl">
                    <div class="productos-comilandia_item">
                       <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>
                <div class="single-item-rtl">
                    <div class="productos-comilandia_item">
                       <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>
                <div class="single-item-rtl">
                     <div class="productos-comilandia_item">
                       <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>
                <div class="single-item-rtl">
                    <div class="productos-comilandia_item">
                       <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>
                <div class="single-item-rtl">
                    <div class="productos-comilandia_item">
                       <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>

            </div>
        </div>-->
        

        <div class="container cont-productos product-home" id="dev-area">
            <div class="prod-relacionado" v-for="post in posts">
                <div class="single-item-rtl relacionados">
                    <div class="productos-comilandia_item">
                        <a :href="'{{ url('/post/show') }}'+'/'+post.post.id">
                            <div class="img-producto-comilandia">
                                <img class="img-carrusel-productos" :src="'{{ url('/images/posts/') }}'+'/'+post.post.image" alt=""  >
                            </div>
                            <div class="img-producto-comilandia-prom">
                                <div class="prom-img-producto-comilandia-prom-desc">@{{ post.discountPercentage }}%</div>
                            </div>
                            <div class="cont-inf-u-comilandia">
                                <div class="cont-inf-u-comilandia-img">
                                    <img class="cont-inf-u-comilandia-img_img" :src="'{{ url('/') }}'+'/images/users/'+post.post.user.image" alt="" alt="">
                                </div>
                                <div class="cont-inf-u-comilandia-nombre">
                                    <p class="cont-inf-u-comilandia-nombre_p"><a class="text-center" :href="'{{ url('/') }}'+'/profile'+'/'+post.post.user_id">@{{ post.post.user.name }}</a></p>
                                </div>
                            </div>
                            <div class="box-inf-products-comilandia">
                                <h4>@{{ post.post.title }}</h4>
                                <p>@{{ post.post.commune.name }}</p>    
                                
                            </div>
                            
                        </a> 

                    </div>
                </div>
  
            </div>
        </div>
        

        <br>
        <div class="btn-ver-mas-comilandia">
            <a class="btn-ver-mas-comilandia_a" href="#">Ver más</a>
        </div>
    </section>
    <section class="uber">
        <div class="uber-imagenes">
            
            <div class="img-uber-fondo">
                <img class="img-ube-ola" src="{{ asset('user/images/fondorojo.png') }}">
            </div>
            <div class="img-ube">
                <img class="img-ube-telefono" src="{{ asset('user/images/ej-4.png') }}">
            </div>
        </div>
        <div class="uber-cont">
            <div class="container">
                <div class="col-md-6 uber-cont-col-6">
                    <h3>¡Tu pedido en minutos!</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit ex, distinctio sequi quaerat illum ratione earum voluptas ipsam amet reprehenderit, facilis perspiciatis officiis. Esse odit nihil exercitationem sint blanditiis ea!</p>
                    <div class="btn-uber">
                        <a class="btn-uber_a" href="#">Pedir por UberEast</a>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <footer>
        <div class="footer">
            <div class="container container-footer">
                <div class="row">
                    <div class="col-md-5">
                        <h5>Comilandia</h5>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eos quisquam dolor eveniet dolore facilis vitae rerum quis. Sunt repellat laborum laudantium debitis recusandae ab, veniam quas, inventore minima et tenetur!</p>
                    </div>
                    <div class="col-md-2">
                        <h6 style="color: #e3001b;  font-weight: bold;">Menu del dia</h6>
                        <ul>
                            <li>Pedido online</li>
                            <li>Delivery</li>
                            <li>Contáctanos</li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h6>Menu del dia</h6>
                        <ul>
                            <li>Pedido online</li>
                            <li>Delivery</li>
                            <li>Contáctanos</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>Siguenos</h5>
                        <div class="rs-box">
                            <a class="rs-box_a" href="#">
                                <div class="rs">
                                    <div class="img-rs"><img src="{{ asset('user/images/facebook.png') }}" alt="Comilandiafood"></div>
                                    Comilandiafood
                                </div>
                            </a>
                            <a class="rs-box_a" href="#">
                                <div class="rs">
                                    <div class="img-rs"><img src="{{ asset('user/images/instagram.png') }}" alt="Comilandiafood"></div>
                                    Comilandiafood
                                </div>
                            </a>
                            <a class="rs-box_a" href="#">
                                <div class="rs">
                                    <div class="img-rs"><img src="{{ asset('user/images/youtube.png') }}" alt="Comilandiafood"></div>
                                    Comilandiafood
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- @foreach(App\Ad::inRandomOrder()->take(10)->get() as $ad)

      
        <div class="owl-carousel owl-theme">
          
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

    @endforeach -->


    



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

    <!-- <script>
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
    </script> -->

   

@endpush