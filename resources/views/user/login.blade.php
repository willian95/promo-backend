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
                            alert(value)
                            //alertify.error(value);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })

                }

            }

        })
    </script>

@endpush