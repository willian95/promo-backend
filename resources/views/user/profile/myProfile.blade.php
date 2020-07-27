@extends("layouts.user")

@push("css")

    <style>
        input, select, textarea{
            margin-bottom:15px;
        }
    </style>

@endpush

@section("content")

    <div class="container pt-150" id="dev-area">

        <div class="row">

            <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3">
          
                <div class="form-group">
                    <p class="text-center">
                        <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 140px; height: 140px; object-fit:cover; border-radius: 50%; ">
                    </p>

                    <label class="text-dark" for="profile-image">Imagen Perfil</label>
                    <input type="file" class="form-control" id="profile-image" accept="image/*" @change="onImageChange">
                    
                </div>
            
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="text-dark">Nombre</label>
                    <input type="text" class="form-control" v-model="name" id="name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="text-dark">Email</label>
                    <input type="text" class="form-control" v-model="email" id="email" readonly>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="website" class="text-dark">Web site</label>
                    <input type="text" class="form-control" v-model="webSite" id="website" placeholder="https://www.mysite.com">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telephone" class="text-dark">Telephone</label>
                    <input type="text" class="form-control" v-model="telephone" id="telephone" placeholder="+5612345678">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="facebook" class="text-dark">Facebook</label>
                    <input type="text" class="form-control" v-model="facebook" id="facebook" placeholder="https://www.facebook.com/myprofile">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="instagram" class="text-dark">Instagram</label>
                    <input type="text" class="form-control" v-model="instagram" id="instagram" placeholder="https://www.instagram.com/myprofile">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address" class="text-dark">Dirección</label>
                    <input type="text" class="form-control" v-model="address" id="address">
                </div>
            </div>
            <div class="col-md-6">
                <label for="region" class="text-dark"> Seleccione una región </label>
                <select class="form-control" v-model="region" @change="onRegionChange()" id="region">
                    <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="commune" class="text-dark"> Seleccione una comuna </label>
                <select class="form-control" v-model="commune" id="commune">
                    <option :value="commune.id" v-for="commune in communes">@{{ commune.name }}</option>
                </select>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-dark">¿Ofrece delivery?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" v-model="hasDelivery" id="exampleRadios1" value="true" checked>
                        <label class="form-check-label text-dark" for="exampleRadios1">
                            Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" v-model="hasDelivery" id="exampleRadios2" value="false">
                        <label class="form-check-label text-dark" for="exampleRadios2">
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="delivery_price" class="text-dark">Precio delivery</label>
                    <input type="text" class="form-control" id="delivery_price" v-model="deliveryPrice">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-dark">Días abiertos</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="lunes" id="defaultCheck1" v-model="checkedOpenDays">
                        <label class="form-check-label" for="defaultCheck1" style="color:#000">
                            Lunes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="martes" id="defaultCheck2" v-model="checkedOpenDays">
                        <label class="form-check-label" for="defaultCheck2" style="color:#000">
                            Martes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="miércoles" id="defaultCheck3" v-model="checkedOpenDays">
                        <label class="form-check-label" for="defaultCheck3" style="color:#000">
                            Miércoles
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="jueves" id="defaultCheck4" v-model="checkedOpenDays">
                        <label class="form-check-label" for="defaultCheck4" style="color:#000">
                            Jueves
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="viernes" id="defaultCheck5" v-model="checkedOpenDays">
                        <label class="form-check-label" for="defaultCheck5" style="color:#000">
                            Viernes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="sábado" id="defaultCheck6" v-model="checkedOpenDays">
                        <label class="form-check-label" for="defaultCheck6" style="color:#000">
                            Sábado
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="domingo" id="defaultCheck7" v-model="checkedOpenDays">
                        <label class="form-check-label" for="defaultCheck7" style="color:#000">
                            Domingo
                        </label>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-dark">Días de Delivery</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="lunes" id="defaultDelivery1" v-model="checkedDeliveryDays">
                        <label class="form-check-label" for="defaultCheck1" style="color:#000">
                            Lunes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="martes" id="defaultDelivery2" v-model="checkedDeliveryDays">
                        <label class="form-check-label" for="defaultDelivery2" style="color:#000">
                            Martes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="miercoles" id="defaultDelivery3" v-model="checkedDeliveryDays">
                        <label class="form-check-label" for="defaultDelivery3" style="color:#000">
                            Miércoles
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="jueves" id="defaultDelivery4" v-model="checkedDeliveryDays">
                        <label class="form-check-label" for="defaultDelivery4" style="color:#000">
                            Jueves
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="viernes" id="defaultDelivery5" v-model="checkedDeliveryDays">
                        <label class="form-check-label" for="defaultDelivery5" style="color:#000">
                            Viernes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="sábado" id="defaultDelivery6" v-model="checkedDeliveryDays">
                        <label class="form-check-label" for="defaultDelivery6" style="color:#000">
                            Sábado
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="domingo" id="defaultDelivery7" v-model="checkedDeliveryDays">
                        <label class="form-check-label" for="defaultDelivery7" style="color:#000">
                            Domingo
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 15px;">
                <p class="text-center">
                    <button class="button" @click="update()">Actualizar</button>
                </p>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Comentarios</h3>
            </div>
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3" v-for="rating in ratings">
                <div class="card">
                    <div class="card-body">
                    <h5 class="text-center">@{{ rating.qualifier.name }} @{{ rating.rating.rate }}/5</h5>
                    <p>@{{ rating.rating.comment }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push("scripts")

<script>
        const app = new Vue({
            el: '#dev-area',
            data(){
                return{
                    name:"",
                    email:"",
                    checkedOpenDays:[],
                    deliveryPrice:0,
                    hasDelivery:true,
                    checkedDeliveryDays:[],
                    address:"",
                    regions:[],
                    communes:[],
                    region:"",
                    commune:"",
                    webSite:"",
                    telephone:"",
                    instagram:"",
                    facebook:"",
                    image:"",
                    imagePreview:"",
                    ratings:""
                }
            },
            methods:{
                
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

                },
                myFetch(){

                    axios.get("{{ url('api/rate/myFetch') }}", {
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    })
                    .then(res => {

                        this.ratings = res.data.ratings
                        

                    })

                },
                onImageChange(e){
                    this.image = e.target.files[0];

                    this.imagePreview = URL.createObjectURL(this.image);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.view_image = false
                    this.createImage(files[0]);
                },
                createImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                myData(){

                    axios.get("{{ url('api/my-profile/data') }}", {
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    }).then(res =>{
                        if(res.data.open_days != null)
                            this.checkedOpenDays = res.data.user.open_days.split(",")
                        if(res.data.deliver_days != null)
                        this.checkedDeliveryDays = res.data.user.deliver_days.split(",")
                        this.hasDelivery = res.data.user.has_delivery
                        this.deliveryPrice = res.data.user.delivery_tax

                        this.regionsFetch()
                        this.name = res.data.user.name
                        this.email = res.data.user.email
                        this.address = res.data.user.address
                        this.region = res.data.commune.region_id
                        this.commune = res.data.user.location_id
                        this.webSite = res.data.user.web_site
                        this.telephone = res.data.user.telephone
                        this.facebook = res.data.user.facebook
                        this.instagram = res.data.user.instagram
                        this.imagePreview = "{{ url('/') }}"+"/images/users/"+res.data.user.image
                        this.communesFetch()

                    })

                },
                update(){

                    axios.post("{{ url('api/my-profile/update') }}", {name: this.name, address: this.address, commune: this.commune, webSite: this.webSite, telephone: this.telephone, facebook: this.facebook, instagram: this.instagram, image: this.image, hasDelivery: this.hasDelivery, deliveryPrice: this.deliveryPrice, checkedDeliveryDays: this.checkedDeliveryDays, checkedOpenDays: this.checkedOpenDays},{
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    }).then(res => {

                        if(res.data.success == true){
                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            })
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

                this.myData()
                this.myFetch()
                

            }

        })
    </script>

@endpush