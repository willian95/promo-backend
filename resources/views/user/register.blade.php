@extends("layouts.user")

@section("content")

    <section class="ftco-cover" id="section-register">
        <div class="container-fluid">
           
            <div class="row information">
                <div class="col-md-6 pt-40">
                    <h3 class="ftco-heading ftco-animate mb-3" style="padding-top: 18px !important;">Registro</h3>
                    <div  class="form-register">
                        <div class="container">
                            <div class=" row">
                                <div class="col-md-6 mb-4">
                                    <label for="name">Nombre</label>
                                    <input id="name" type="text" class="form-control" placeholder="Nombre" v-model="name" >
                                </div> 
                                <div class="col-md-6  mb-4">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" placeholder="Email" v-model="email" >
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="password">Clave</label>
                                    <input id="password" type="password" class="form-control" placeholder="Clave" v-model="password" >
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="passwordRepeat">Repetir clave</label>
                                    <input type="password" id="passwordRepeat" class="form-control" placeholder="Confirmar Clave" v-model="password_confirmation" >
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="address">Dirección</label>
                                    <input id="address" type="address" class="form-control" placeholder="Dirección de entrega" v-model="address" >
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="telephone">Teléfono</label>
                                    <input id="telephone" type="text" class="form-control" placeholder="Teléfono" v-model="phone" >
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label> Seleccione una región </label>
                                    <select class="form-control" v-model="region" @change="onRegionChange()">
                                        <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label> Seleccione una comuna </label>
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