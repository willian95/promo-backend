@extends("layouts.user")

@section("content")

    <section class="ftco-cover" id="section-register">
        <div class="container-fluid">
           
            <div class="row information">
                <div class="col-md-6 pt-40 cont-registrar-comilandia">
                    <h3 class="ftco-heading ftco-animate mb-3" style="padding-top: 18px !important;">¡Regístrate ahora!</h3>
                    <div  class="form-register">
                        <div class="container">
                            <div class=" row">
                                <div class="col-md-12 mb-10px">
                                    <!-- <label for="name">Nombre</label> -->
                                    <input id="name" type="text" class="form-control input-registro" placeholder="Nombre" v-model="name" >
                                </div> 
                                <div class="col-md-12  mb-10px">
                                    <!-- <label for="email">Email</label> -->
                                    <input id="email" type="email" class="form-control input-registro" placeholder="Email" v-model="email" >
                                </div>
                                <div class="col-md-12 mb-10px">
                                    <!-- <label for="password">Clave</label> -->
                                    <input id="password" type="password" class="form-control input-registro" placeholder="Clave" v-model="password" >
                                </div>
                                <div class="col-md-12 mb-10px">
                                    <!-- <label for="passwordRepeat">Repetir clave</label> -->
                                    <input type="password" id="passwordRepeat" class="form-control input-registro" placeholder="Confirmar Clave" v-model="password_confirmation" >
                                </div>
                                <div class="col-md-12 mb-10px">
                                    <!-- <label for="address">Dirección</label> -->
                                    <input id="address" type="address" class="form-control input-registro" placeholder="Dirección de entrega" v-model="address" >
                                </div>
                                <div class="col-md-12 mb-10px">
                                    <!-- <label for="telephone">Teléfono</label> -->
                                    <input id="telephone" type="text" class="form-control input-registro" placeholder="Teléfono" v-model="phone" >
                                </div>
                                <div class="col-md-12 mb-10px mt-registro">
                                    <!-- <label> Seleccione una región </label> -->
                                    <select class="form-control form-explorer-comilandia comilandia-registro" v-model="region" @change="onRegionChange()">
                                        <option  value="">Seleccione una región</option>
                                        <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-10px mb-registro">
                                    <!-- <label> Seleccione una comuna </label> -->
                                    <select class="form-control form-explorer-comilandia comilandia-registro" v-model="commune">
                                    <option value="">Seleccione una comuna</option>
                                        <option :value="commune.id" v-for="commune in communes">@{{ commune.name }}</option>
                                    </select>
                                </div>


                                <div style="display: flex; justify-content: center; width: 100%;"  class="form-group row">
                                    <div style="text-align: center;" class="col-md-6">       
                                        <button style=" background: #ee2e3d;" class="res button" @click="register()">Registrarse</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mask">
                        <img src="{{ asset('user/images/6.png') }}">
                    </div>
                </div>
            </div>
            
        </div>
    </section>

@endsection

@push("scripts")

    <script>
        const app = new Vue({
            el: '#section-register',
            data(){
                return{
                    email:"",
                    password:"",
                    password_confirmation:"",
                    commune:"",
                    address:"",
                    phone:"",
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
                        address:this.address,
                        telephone: this.phone
                    })
                    .then(res => {

                        if (res.data.success == false) {
                            swal({
                                text: res.data.msg,
                                icon: "success"
                            })
                            
                        } else {

                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            }).then(function() {
                                window.location.href="{{ url('/') }}"
                            });;

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value[0])
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
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })
                        }
                        

                    })

                },
                communesFetch(){

                    axios.get("{{ url('/api/commune') }}"+"/"+this.region)
                    .then(res => {

                        if(res.data.success == true){
                            this.communes = res.data.communes
                        }else{
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })
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