@extends("layouts.user")

@section("content")

    <section class="ftco-cover" id="section-login">
        
      
        <div class="container-fluid">
            <div class="row text-center ftco-heading ftco-animate">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    
                    <div class="card">
                        <div class="card-body">

                            <h3 class="mb-3">Olvidé mi contraseña</h3>
                            
                            <div class="form-group row">
                                <div class="col-md-12 mb-4">
                                    <label for="email" class="text-dark" style="font-size: 18px;">Email</label>
                                    <input id="email" type="email" class="form-control" placeholder="Email" v-model="email">
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; margin-top: 10px;"class="form-group row">
                                <div style="text-align: center;" class="col-md-6">
                                    <button class="res button" @click="verifyEmail()">Enviar</button>
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
                    email:""
                }
            },
            methods:{
                
                verifyEmail(){

                    axios.post("{{ url('/forgot-password') }}", {email: this.email}).then(res => {

                        if(res.data.success == true){

                            swal({
                                title:"Excelente!",
                                text: res.data.msg,
                                icon:"success"
                            })

                            this.email = ""

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