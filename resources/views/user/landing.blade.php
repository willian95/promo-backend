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
                <div class="carousel-item active">
                    <div class="mask"></div>
                    <img src="{{ asset('user/images/ej-3.jpg') }}">
                    <div class="container cont-inf-banner">
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
                <div class="carousel-item">
                    <div class="mask"></div>
                    <img src="{{ asset('user/images/ej-1.jpg') }}">
                    <div class="container cont-inf-banner">
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
                <div class="carousel-item">
                    <div class="mask"></div>
                    <img src="{{ asset('user/images/ej-2.jpg') }}">
                    <div class="container cont-inf-banner">
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
                <div class="cont-cuadro-desc"><div class="cuadro-desc">-50%</div></div>
               <div class="cont-prom-comilandia-info">
                    <h3 class="container-prom-comilandia_h3">Promo agosto</h3>
                    <p class="container-prom-comilandia_p">Disfruta de <span>1</span> increíble</p>
                    <p class="container-prom-comilandia_p"> Cheese Burger + Soda + Cheese Fries</p>
                    <div class="cont-btn-prom-comilandia-pedir-ahora"><a class="btn-prom-comilandia-pedir-ahora" href="#">Pedir ahora</a></div>
                    
               </div>
               <div  class="cont-prom-prom"><div class="img-prom-promo"></div></div>
               <div class="mask-img-prom"></div>
                <img class="img-carrusel-login" src="{{ asset('user/images/menu_3.jpg') }}" alt="promocion" >
                <div class="cont-img-categoria-des-comilandia"></div><div class="img-categoria-des-comilandia"></div> 

              </div>
            <div class="col-md-6">
                <div class="row cont-prom-img-dest">
                    <div class="col-md-6 prom-sec">
                    <img class="img-carrusel-login" src="{{ asset('user/images/menu_3.jpg') }}" alt="promocion" >
                    </div>
                    <div class="col-md-6 prom-sec">
                    <img class="img-carrusel-login" src="{{ asset('user/images/menu_3.jpg') }}" alt="promocion" >
                    </div>
                </div>
                <div class="row cont-prom-img-dest">
                    <div class="col-md-12 prom-terc">
                    <img class="img-carrusel-login" src="{{ asset('user/images/menu_3.jpg') }}" alt="promocion" >

                    </div>
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