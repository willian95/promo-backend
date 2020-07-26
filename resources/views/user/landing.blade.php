@extends("layouts.user")

@section("content")

    <section class="ftco-cover" id="section-landing-hero">
        <img src="{{ asset('user/images/6.png') }}">
        <div class="container">
            <div class="mask">
                <div class="row no-gutters align-items-center justify-content-center text-center ftco-vh-100">
                    <div class="col-md-12">
                        <div  class="site-section hola" id="contact-section" >
                            <h1 >Bienvenidos a <span style="color:rgb(226, 206, 130);">Comilandia</span></h1>
                            <p  >Lorem ipsum dolor sit amet.</p>
                        </div>
                        <div style="display: flex; justify-content: center;"class="form-group row no-gutters">
                            <div style="text-align: center;" class="col-md-6">
                                <a href="{{ url('/explorer') }}">
                                    <button class="res button">Explorar</button>
                                </a>
                            </div>
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
        <h2>Promociones</h2>
        <div class="container" id="dev-area">

            <div class="row">

                <div class="col-md-4" v-for="post in posts">

                    <div class="card" style="padding-bottom: 20px;">
                        <div class="img-product">
                            <img :src="'{{ url('/images/posts/') }}'+'/'+post.post[0].image" alt="">
                        </div>
                        <div class="card-body">
                            <div class="card-image-section">
                                <p class="text-center">
                                    <img :src="'{{ url('/') }}'+'/images/users/'+post.post[0].user.image" alt="">
                                </p>
                                <p class="text-center">
                                    <a class="text-center" :href="'{{ url('/') }}'+'/profile'+'/'+post.post[0].user_id">@{{ post.post[0].user.name }}</a>
                                </p>
                            </div>

                            <h5 class="text-center">@{{ post.post[0].title }}</h5>
                            <p>@{{ post.post[0].commune.name }}</p>
                            <p class="description-post">@{{ post.post[0].description }}</p>
                            <p>promedio: @{{ post.overall }} / 5</p>
                            <p>Descuento: <span class="price">- @{{ post.discountPercentage }}%</span></p>
                            <p class="text-center button-show-more">
                                <a :href="'{{ url('/post/show') }}'+'/'+post.post[0].id">
                                <button class="button">Ver más</button></a>
                            </p>
                        </div>
                    </div>

                </div>

            </div>
               
        </div>             
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
            <div class="item">
                <a href="{{ $ad->link }}" target="_blank">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ url('/images/ads/'.$ad->image) }}" alt="" style="width: 100%;">
                        </div>
                    </div>
                </a>
            </div>
        </div>

    @endforeach

    <!-- FOOTER -->
    <footer>
        <div class="footer container" id="footer">
            <div class="logo-footer">
                <img src="{{ asset('user/images/logo.png') }}">
            </div>
            <div class="about-footer">
                <h6 style="font-weight: bold">Sobre Nosotros</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="hours">
                <!--<h6 style="font-weight: bold;     margin-left: -25px;">Nuestro Horario</h6>
                <p> Lunes a Viernes <br>
                10.00 hrs a 20:00hrs</p>-->
            </div>
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