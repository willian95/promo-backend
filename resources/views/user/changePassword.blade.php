@extends("layouts.user")

@section("content")

    <section class="ftco-cover" id="section-login">
        
      
        <div class="container-fluid">
            <div class="row text-center ftco-heading ftco-animate">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    
                    <div class="card">
                        <div class="card-body" style="height: unset;">

                            <h3 class="mb-3">Nueva contraseña</h3>
                            
                            <div class="form-group row">
                                <div class="col-md-12 mb-4">
                                    <label for="password" class="text-dark" style="font-size: 18px;">Contraseña</label>
                                    <input id="password" type="password" class="form-control" placeholder="Contraseña" v-model="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 mb-4">
                                    <label for="passwordRepeat" class="text-dark" style="font-size: 18px;">Repetir Contraseña</label>
                                    <input id="passwordRepeat" type="password" class="form-control" placeholder="Email" v-model="password_confirmation">
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; margin-top: 10px;"class="form-group row">
                                <div style="text-align: center;" class="col-md-6">
                                    <button class="res button" @click="changePassword()">Actualizar</button>
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
        const body = new Vue({
            el: '#section-login',
            data(){
                return{
                    password:"",
                    password_confirmation:"",
                    hash:"{{ $hash }}"
                }
            },
            methods:{
                
                changePassword(){

                    axios.post("{{ url('/forgot-password/change') }}", {password: this.password, password_confirmation: this.password_confirmation, hash:this.hash}).then(res => {

                        if(res.data.success == true){

                            swal({
                                title:"Excelente!",
                                text: res.data.msg,
                                icon:"success"
                            }).then(() => {

                                this.password = ""
                                this.password_confirmation = ""
                                window.location.href ="{{ url('/') }}"
                            })

                        }else{

                            swal({
                                title:"Lo sentimos!",
                                text: res.data.msg,
                                icon:"error"
                            })

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