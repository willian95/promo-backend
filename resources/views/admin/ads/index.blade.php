@extends('layouts.admin')

@section('content')

    <div id="dev-area">
        
        <div class="container form">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Nota</h3>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="homeText">Texto</label>
                        <input v-model = "homeText" id="homeText" class="form-control"></input>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="homeStatus">status</label>
                        <select id="homeStatus" class="form-control" v-model="homeStatus">
                            <option value="1">Activado</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <p class="text-center">
                        <button class="btn btn-success" @click="updateNote()">Crear</button>
                    </p>
                </div>

            </div>
        </div>

        <div class="container form">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Publicidades Banner</h3>
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="banner1">Imagen Banner 1</label>
                        <input type="file" id="banner1" class="form-control" @change="onBannerImageChange($event, 1)" accept="image/*"></input>
                        <img :src="bannerAdPreview1" alt="" style="width: 30%;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bannerStatus1">Link Banner 1</label>
                        <input type="text" class="form-control" v-model="banner1Link">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bannerStatus1">Status Imagen Banner 1</label>
                        <select id="bannerStatus1" class="form-control" v-model="banner1ImageStatus">
                            <option value="1">Activado</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <p class="text-center">
                        <button class="btn btn-success" @click="updateBanner(1)">Actualizar</button>
                    </p>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="banner2">Imagen Banner 2</label>
                        <input type = "file" id="banner2" class="form-control" @change="onBannerImageChange($event, 2)" accept="image/*"></input>
                        <img :src="bannerAdPreview2" alt="" style="width: 30%;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bannerLink">Link Banner 2</label>
                        <input type="text" class="form-control" v-model="banner2Link">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="bannerStatus2">Status Imagen Banner 2</label>
                        <select id="bannerStatus2" class="form-control" v-model="banner2ImageStatus">
                            <option value="1">Activado</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <p class="text-center">
                        <button class="btn btn-success" @click="updateBanner(2)">Actualizar</button>
                    </p>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="banner3">Imagen Banner 3</label>
                        <input type = "file" id="banner3" class="form-control" @change="onBannerImageChange($event, 3)" accept="image/*"></input>
                        <img :src="bannerAdPreview3" alt="" style="width: 30%;">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="bannerStatus3">Status Imagen Banner 3</label>
                        <select id="bannerStatus3" class="form-control" v-model="banner3ImageStatus">
                            <option value="1">Activado</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <p class="text-center">
                        <button class="btn btn-success" @click="updateBanner(3)">Actualizar</button>
                    </p>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="banner4">Imagen Banner 4</label>
                        <input type = "file" id="banner4" class="form-control" @change="onBannerImageChange($event, 4)" accept="image/*"></input>
                        <img :src="bannerAdPreview4" alt="" style="width: 30%;">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="bannerStatus4">Status Imagen Banner 4</label>
                        <select id="bannerStatus4" class="form-control" v-model="banner4ImageStatus">
                            <option value="1">Activado</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <p class="text-center">
                        <button class="btn btn-success" @click="updateBanner(4)">Actualizar</button>
                    </p>
                </div>

            </div>

        </div>

        <div class="container form">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Publicidades</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-center">
                        <button class="btn btn-success" data-toggle="modal" data-target="#createAd" @click="create()">Crear</button>
                    </p>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">publicidad</th>
                                <th scope="col">link</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ad, index) in ads">
                                <th>@{{ index + 1 }}</th>
                                <td>
                                    <img style="width: 180px;" :src="'{{ url('/') }}'+'/images/ads/'+ad.image" alt="">
                                </td>
                                <td>
                                    <a :href="ad.link" target="_blank">ir</a>
                                </td>
                                <td>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createAd" @click="edit(ad)">editar</button>
                                    <button class="btn btn-danger" @click="erase(ad.id)">eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" v-for="index in pages" :key="index" @click="fetch(index)" >@{{ index }}</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- modal -->

        <div class="modal fade" id="createAd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="link">link</label>
                            <input v-model = "link" id="link" class="form-control"></input>
                        </div>
                        <div class="form-group">
                            <label for="image">imagen</label>
                            <input type="file" class="form-control" id="image" ref="file" @change="onImageChange" accept="image/*">

                            <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="store()" v-if="action == 'create'">Crear</button>
                        <button type="button" class="btn btn-primary" @click="update()" v-if="action == 'edit'">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->
    
    </div>

@endsection

@push('scripts')

    <script>
                    
        const app = new Vue({
            el: '#dev-area',
            data(){
                return{
                    modalTitle:"Crear publicidad",
                    link:"",
                    image:"",
                    homeStatus:"{{ App\HomeNote::first()->status }}",
                    homeText:"{{ App\HomeNote::first()->text }}",
                    imagePreview:"",
                    action:"create",
                    adId:"",
                    ads:[],
                    pages:0,
                    page:1,
                    bannerAd1:"",
                    bannerAdPreview1:"{{ App\HomeBanner::where('id', 1)->first()->image }}",
                    banner1ImageStatus:"{{ App\HomeBanner::where('id', 1)->first()->status }}",
                    banner1Link:"{{ App\HomeBanner::where('id', 1)->first()->link }}",
                    bannerAd2:"",
                    bannerAdPreview2:"{{ App\HomeBanner::where('id', 2)->first()->image }}",
                    banner2ImageStatus:"{{ App\HomeBanner::where('id', 3)->first()->status }}",
                    banner2Link:"{{ App\HomeBanner::where('id', 2)->first()->link }}",
                    bannerAd3:"",
                    bannerAdPreview3:"{{ App\HomeBanner::where('id', 3)->first()->image }}",
                    banner3ImageStatus:"{{ App\HomeBanner::where('id', 3)->first()->status }}",
                    banner3Link:"{{ App\HomeBanner::where('id', 3)->first()->link }}",
                    bannerAd4:"",
                    bannerAdPreview4:"{{ App\HomeBanner::where('id', 4)->first()->image }}",
                    banner4ImageStatus:"{{ App\HomeBanner::where('id', 4)->first()->status }}",
                    banner4Link:"{{ App\HomeBanner::where('id', 4)->first()->link }}",
                }
            },
            methods:{

                create(){
                    this.action = "create"
                    this.link = ""
                    this.image = ""
                },
                onImageChange(e){
                    this.image = e.target.files[0];

                    this.imagePreview = URL.createObjectURL(this.image);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
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
                onBannerImageChange(e, ad){

                    if(ad == 1){
                        this.bannerAd1 = e.target.files[0];
                        this.bannerAdPreview1 = URL.createObjectURL(this.bannerAd1);
                    }

                    else if(ad == 2){
                        this.bannerAd2 = e.target.files[0];
                        this.bannerAdPreview2 = URL.createObjectURL(this.bannerAd2);
                    }

                    else if(ad == 3){
                        this.bannerAd3 = e.target.files[0];
                        this.bannerAdPreview3 = URL.createObjectURL(this.bannerAd3);
                    }

                    else if(ad == 4){
                        this.bannerAd4 = e.target.files[0];
                        this.bannerAdPreview4 = URL.createObjectURL(this.bannerAd4);
                    }
                    
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createBannerImage(files[0], ad);

                },
                createBannerImage(file, ad) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        if(ad == 1){
                            vm.bannerAd1 = e.target.result;
                        }

                        else if(ad == 2){
                            vm.bannerAd2 = e.target.result;
                        }

                        else if(ad == 3){
                            vm.bannerAd3 = e.target.result;
                        }

                        else if(ad == 4){
                            vm.bannerAd4 = e.target.result;
                        }
                    };
                    reader.readAsDataURL(file);
                },
                store(){

                    axios.post("{{ url('api/admin/ads/store') }}", {image: this.image, link: this.link})
                    .then(res => {

                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            })
                            this.image = ""
                            this.link=""
                            this.imagePreview = ""
                            $("#image").val(null)
                            this.fetch()
                        }else{

                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                update(){

                    axios.post("{{ url('/api/admin/ads/update') }}", {id: this.adId, link: this.link, image: this.image})
                    .then(res => {

                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            })
                            this.link = ""
                            this.image = ""
                            this.imagePreview = ""
                            $("#image").val(null)
                            this.fetch()
                            
                        }else{

                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                edit(ad){
                    this.modalTitle = "Editar publicidad"
                    this.action = "edit"
                    this.link = ad.link
                    this.imagePreview = "{{ url('/') }}"+"/images/ads/"+ad.image
                    this.adId = ad.id
                },
                fetch(page = 1){
                    
                    this.page = page

                    axios.get("{{ url('api/admin/ads/fetch/') }}"+"/"+this.page)
                    .then(res => {

                        this.ads = res.data.ads
                        this.pages = Math.ceil(res.data.adsCount / 20)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/api/admin/ads/delete/') }}", {id: id}).then(res => {

                            if(res.data.success == true){
                                swal({
                                    title: "Perfecto!",
                                    text: res.data.msg,
                                    icon: "success"
                                })
                                this.fetch()
                            }else{

                                swal({
                                    text: res.data.msg,
                                    icon: "error"
                                })

                            }

                        })
                        .catch(err => {
                            $.each(err.response.data.errors, function(key, value){
                                alertify.error(value[0])
                            });
                        })

                    }

                },
                updateNote(){

                    axios.post("{{ url('api/admin/ads/home-note/update') }}", {text: this.homeText, status: this.homeStatus}).then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                        }else{
                            alert(res.data.msg)
                        }

                    })

                },
                updateBanner(ad){
                    let data = {}
                    if(ad == 1){
                        data = {
                            banner_id: ad,
                            image: this.bannerAd1,
                            status: this.banner1ImageStatus,
                            link:this.banner1Link
                        }

                        $("#banner1").val(null)

                    }

                    else if(ad == 2){
                        data = {
                            banner_id: ad,
                            image: this.bannerAd2,
                            status: this.banner2ImageStatus,
                            link:this.banner2Link
                        }
                        $("#banner2").val(null)
                    }

                    else if(ad == 3){
                        data = {
                            banner_id: ad,
                            image: this.bannerAd3,
                            status: this.banner3ImageStatus,
                            link:this.banner3Link
                        }
                        $("#banner3").val(null)
                    }

                    else if(ad == 4){
                        data = {
                            banner_id: ad,
                            image: this.bannerAd4,
                            status: this.banner4ImageStatus,
                            link:this.banner4Link
                        }
                        $("#banner4").val(null)
                    }

                    axios.post("{{ url('api/admin/banner/update') }}", data).then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                        }else{
                            alert(res.data.msg)
                        }

                    })

                }
                

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush