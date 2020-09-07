@extends("layouts.user")

@section("content")

    <!--<div class="container detail" id="dev-area">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" v-model="password">
                        </div>
                        <button type="submit" class="btn btn-primary" @click="login()">Submit</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!-- <div id="demo" class="carousel slide" data-ride="carousel">
               
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img class="img-carrusel-login" src="{{ asset('user/images/6.png') }}" alt="Los Angeles" width="1100" height="500">
                    <div class="carousel-caption text-login-comilandia">
                        <h3><strong>UN MUNDO</strong></h3>
                        <h3> DE SABORES </h3>
                    </div>   
                    </div>
                    <div class="carousel-item">
                    <img  class="img-carrusel-login" src="{{ asset('user/images/6.png') }}" alt="Chicago" width="1100" height="500">
                    <div class="carousel-caption text-login-comilandia">
                        <h3><strong>UN MUNDO</strong></h3>
                        <h3> DE SABORES </h3>
                    </div>   
                    </div>
                    <div class="carousel-item">
                    <img class="img-carrusel-login" src="{{ asset('user/images/6.png') }}" alt="New York" width="1100" height="500">
                    <div class="carousel-caption text-login-comilandia">
                        <h3><strong>UN MUNDO</strong></h3>
                        <h3> DE SABORES </h3>
                    </div>   
                   
                    </div>
                       
                       
                </div>
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>   -->
            <!-- <div class="form-group row no-gutters btn-mira-menu p-ab">
                <div  class="col-md-12 boton-mira-menu-login">
                    <a href="{{ url('/explorer') }}">
                        <button class="res button">¡Mira el Menú!</button>
                    </a>
                </div>
            </div> -->
    <section class="ftco-cover" id="section-login">
    


        {{--<img src="{{ asset('user/images/6.png') }}">--}}
      
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-md-6">
                    <div class="mask">
                        <img src="{{ asset('user/images/6.png') }}">
                    
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="ftco-heading ftco-animate mb-3">Inicio de Sesión</h3>
                            
                    <div class="form-group row">
                        <div class="col-md-12 mb-4">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" placeholder="Email" v-model="email">
                        </div>

                        <div class="col-md-12 ">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control" placeholder="Contraseña" v-model="password">
                        </div>
                    </div>
                    <div style="display: flex; justify-content: center; margin-top: 10px;"class="form-group row">
                        <div style="text-align: center;" class="col-md-6">
                            <button class="res button" @click="login()">Entrar</button>
                        </div>
                    </div>

                    <a class="text-center text-secondary" href="{{ url('/forgot-password') }}">Olvidé mi contraseña</a>
                                
                </div>
            </div>
        </div>
        
    </section>

    <section class="vista-interna">
        <div class="cat-comilandia">
            <div class="basico-comilandia"></div>
            <div class="superior-comilandia"></div>
            <div class="premium-comilandia"></div>
        </div>
        <div class="descrip-producto-comilandia">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 img-producto-detallado">
                         <div class="descrip-producto-comilandia-descuento"><div class="descrip-producto-comilandia-descuento-des">-50%</div></div>
                         <img class="descrip-producto-comilandia_img" src="{{ asset('user/images/menu_3.jpg') }}"  >
                         <div class="descrip-producto-comilandia-cont-categoria"><div class="descrip-producto-comilandia-cont-categoria-div"></div></div>
                    </div>
                    <div class="col-md-7">
                        <div class="cont-inf-descrip-producto-comilandia">
                            <h2>Hamburguesa de carne</h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium accusamus blanditiis quae, recusandae ducimus consequatur quaerat maiores</p>
                            <div class="cont-inf-descrip-producto-comilandia-desc-det">
                                <div class="row">
                                    <div class="col-md-8 cont-inf-descrip-producto-comilandia-desc-det-cajas">
                                        <div class="caja-descrip-detallada"><h3>Carne de 200gr de cordero</h3></div>
                                        <div class="caja-descrip-detallada"><h3>Vegetales</h3></div>
                                        <div class="caja-descrip-detallada"><h3>Aros de cebolla</h3></div>
                                        <div class="caja-descrip-detallada"><h3>Salsa especial</h3></div>
                                        <div class="caja-descrip-detallada"><h3>Tocino</h3></div>
                                        <div class="caja-descrip-detallada"><h3>Champiñones</h3></div>

                                    </div>
                                    <div class="col-md-4 agregar-al-carrito">
                                        <a class="agregar-al-carrito_a" href="#">Agregar al carrito</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="cont-inf-descrip-producto-comilandia-c-fechas">
                                            <div class="cont-inf-descrip-producto-comilandia-fechas">01/01/2001<img class="descrip-producto-comilandia_img" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                                            <div class="cont-inf-descrip-producto-comilandia-fechas">01/01/2001<img class="descrip-producto-comilandia_img" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container cont-productos">
                                <div class="prod-relacionado">
                                    <div class="single-item-rtl relacionados">
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
                                    <div class="single-item-rtl relacionados">
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
                                    <div class="single-item-rtl relacionados">
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
                                    <div class="single-item-rtl relacionados">
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
                            </div>
    </section>

@endsection

@push("scripts")

    <script>
        const body = new Vue({
            el: '#section-login',
            data(){
                return{
                    email:"",
                    password:""
                }
            },
            methods:{
                
                login(){

                    axios.post("{{ url('/api/login') }}", {
                        email: this.email,
                        password: this.password
                    })
                    .then(res => {

                        if (res.data.success == false) {
                            //alertify.error(res.data.msg)
                          
                            swal({
                                title: "Hubo un problema!",
                                text: res.data.msg,
                                icon: "error"
                            });
                        } else {

                            localStorage.setItem("token", res.data.token)
                            localStorage.setItem("user", JSON.stringify(res.data.user))
                            
                            if (res.data.user.role_id == 1) {

                                swal({
                                    title: "Perfecto!",
                                    text: res.data.msg,
                                    icon: "success"
                                }).then(function() {
                                    window.location.replace("{{ url('admin/dashboard') }}")
                                });;

                                
                            } else if (res.data.user.role_id == 2) {

                                swal({
                                    title: "Perfecto!",
                                    text: res.data.msg,
                                    icon: "success"
                                }).then(function() {
                                    window.location.replace("{{ url('/') }}")
                                });;

                            }

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value[0])
                            //alertify.error(value);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })

                }

            }

        })
    </script>

@endpush