@extends("layouts.user")

@section("content")

    <!--<div class="container" id="dev-area">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="email" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                        </div>

                        <div class="form-group">
                            <label for="region">Region</label>
                            <select v-model="region" class="form-control" @change="onRegionChange()">
                                <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="region">Comunas</label>
                            <select v-model="commune" class="form-control">
                                <option :value="commune.id" v-for="commune in communes">@{{ commune.name }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" v-model="password">
                        </div>
                        <div class="form-group">
                            <label for="repeatPassword">Repetir clave</label>
                            <input type="password" class="form-control" id="repeatPassword" v-model="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary" @click="register()">Submit</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <section class="ftco-cover" id="section-home">
        <img src="{{ asset('user/images/6.png') }}">
        <div class="container">
            <div class="mask">
                <div class="row information">
                    <div class="col-md-12">
                        <h3 class="ftco-heading ftco-animate mb-3" style="padding-top: 18px !important;">Registro</h3>
                        <div  class="form-register">
                            <div class="container">
                                <div class=" row">
                                    <div class="col-md-6 mb-4">
                                        <input type="text" class="form-control" placeholder="Nombre" v-model="name" style="color: #fff !important;">
                                    </div> 
                                    <div class="col-md-6  mb-4">
                                        <input type="email" class="form-control" placeholder="Email" v-model="email" style="color: #fff !important;">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <input type="password" class="form-control" placeholder="Clave" v-model="password" style="color: #fff !important;">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <input type="password" class="form-control" placeholder="Confirmar Clave" v-model="password_confirmation" style="color: #fff !important;">
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <input type="text" class="form-control" placeholder="Dirección de entrega" v-model="address" style="color: #fff !important;">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <p> Seleccione una región </p>
                                        <select class="form-control" v-model="region" @change="onRegionChange()">
                                            <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <p> Seleccione una comuna </p>
                                        <select class="form-control" v-model="commune">
                                            <option :value="commune.id" v-for="commune in communes">@{{ commune.name }}</option>
                                        </select>
                                    </div>
    
    
                                    <div style="display: flex; justify-content: center; width: 100%;"  class="form-group row">
                                        <div style="text-align: center;" class="col-md-6">       
                                            <button class="res button" @click="register()">Registrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push("scripts")

    <script>
        const app = new Vue({
            el: '#section-home',
            data(){
                return{
                    email:"",
                    password:"",
                    password_confirmation:"",
                    commune:"",
                    address:"",
                    region:"",
                    name:"",
                    regions:[],
                    communes:[]
                }
            },
            methods:{
                
                register(){

                    axios.post("{{ url('/api/register') }}", {
                        name: this.name,
                        password_confirmation: this.password_confirmation,
                        email: this.email,
                        password: this.password,
                        locationId: this.commune,
                        address:this.address
                    })
                    .then(res => {

                        if (res.data.success == false) {
                            alert(res.data.msg)
                            
                        } else {

                            alert(res.data.msg)
                            window.location.href="{{ url('/') }}"

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alert(value)
                            //alertify.error(value);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })

                },
                onRegionChange(){

                    this.communesFetch()

                },
                regionsFetch(){

                    axios.get("{{ url('/api/regions') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.regions = res.data.regions
                        }else{
                            alert(res.data.msg)
                        }
                        

                    })

                },
                communesFetch(){

                    axios.get("{{ url('/api/commune') }}"+"/"+this.region)
                    .then(res => {

                        if(res.data.success == true){
                            this.communes = res.data.communes
                        }else{
                            alert(res.data.msg)
                        }
                        

                    })

                }

            },
            created(){

                this.regionsFetch()

            }

        })
    </script>

@endpush