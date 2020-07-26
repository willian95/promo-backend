@extends('layouts.admin')

@section('content')

    <div id="dev-area">
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
                    imagePreview:"",
                    action:"create",
                    adId:"",
                    ads:[],
                    pages:0,
                    page:1
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
                            alert(value)
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
                            alert(value)
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
                            alert(value)
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
                                alert(value)
                            });
                        })

                    }

                }
                

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush