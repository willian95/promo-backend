@extends("layouts.user")

@section("content")

    <div class="container" id="dev-area" style="padding-top: 150px;">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" v-model="name" id="name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" v-model="email" id="email" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="website">Web site</label>
                    <input type="text" class="form-control" v-model="webSite" id="website" placeholder="https://www.mysite.com">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="profile-image">Imagen Perfil</label>
                    <input type="file" class="form-control" id="profile-image" accept="image/*" @change="onImageChange">
                    <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input type="text" class="form-control" v-model="telephone" id="telephone" placeholder="+5612345678">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <input type="text" class="form-control" v-model="facebook" id="facebook" placeholder="https://www.facebook.com/myprofile">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="instagram">Instagram</label>
                    <input type="text" class="form-control" v-model="instagram" id="instagram" placeholder="https://www.instagram.com/myprofile">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" v-model="address" id="address">
                </div>
            </div>
            <div class="col-md-6">
                <label for="region"> Seleccione una región </label>
                <select class="form-control" v-model="region" @change="onRegionChange()" id="region">
                    <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="commune"> Seleccione una comuna </label>
                <select class="form-control" v-model="commune" id="commune">
                    <option :value="commune.id" v-for="commune in communes">@{{ commune.name }}</option>
                </select>
            </div>

            <div class="col-md-12">
                <p class="text-center">
                    <button class="btn btn-success" @click="update()">Actualizar</button>
                </p>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Comentarios</h3>
            </div>
            <div class="col-12" v-for="rating in ratings">
                <h5>@{{ rating.qualifier.name }} @{{ rating.rating.rate }}</h5>
                <p>@{{ rating.rating.comment }}</p>
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

                    axios.post("{{ url('api/my-profile/update') }}", {name: this.name, address: this.address, commune: this.commune, webSite: this.webSite, telephone: this.telephone, facebook: this.facebook, instagram: this.instagram, image: this.image},{
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    }).then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                        }else{
                            alert(res.data.msg)
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