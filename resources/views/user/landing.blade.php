@extends("layouts.user")

@section("content")

    <section class="ftco-cover" id="section-home">
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
                                <a href="#menu">
                                    <button class="res button">Ver menú</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="icons container" id="icons">
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
    </section>

    <section class="menu" id="menu">
        <h2> Promociones</h2>
        <div class="container cards-carrusel" id="dev-area">

            <div class="card-item" v-for="post in posts">
                <div class="img-product">
                    <img :src="'{{ url('/images/posts/') }}'+'/'+post.image" alt="">
                </div>
                <div class="card-body">
                    <h5>@{{ post.title }}</h5>
                    <p>@{{ post.commune.name }}</p>
                    <p>@{{ post.description }}</p>
                    <a :href="'{{ url('/') }}'+'/profile'+'/'+post.user_id">@{{ post.user.name }}</a>
                    <div class="price">$@{{ post.price }}</div>
                    <a :href="'{{ url('/post/show') }}'+'/'+post.id">
                    <button class="button">Ver más</button></a>
                </div>
            </div>
               
        </div>             
    </section>

    <!-- MENU DESTACADO -->
    <section class="menu-destacado">
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
    </section>
    <!-- FIN MENU DESTACADO -->

    <!-- FOOTER -->
    <footer>
        <div class="footer container" id="footer">
            <div class="logo-footer">
                <img src="{{ asset('user/images/logo.jpg') }}">
            </div>
            <div class="about-footer">
                <h6 style="font-weight: bold">Sobre Nosotros</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="hours">
                <h6 style="font-weight: bold;     margin-left: -25px;">Nuestro Horario</h6>
                <p> Lunes a Viernes <br>
                10.00 hrs a 20:00hrs</p>
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
                        console.log(res)
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

@endpush