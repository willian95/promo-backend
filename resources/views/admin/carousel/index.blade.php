@extends('layouts.admin')

@section('content')

    <div id="dev-area">
        <div class="container form">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Carrusel</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-center">
                        <button class="btn btn-success" data-toggle="modal" data-target="#createBank" @click="create()">Crear</button>
                    </p>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Texto</th>
                                <th scope="col">Link</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(carousel, index) in carousels">
                                <th>@{{ index + 1 }}</th>
                                <td>
                                    <img :src="carousel.image" alt="" style="width: 40%;">
                                </td>
                                <td>
                                    @{{ carousel.text }}
                                </td>
                                <td>
                                    @{{ carousel.link }}
                                </td>
                                <td>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createBank" @click="edit(carousel)">editar</button>
                                    <button class="btn btn-danger" @click="erase(carousel.id)">eliminar</button>
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

        <div class="modal fade" id="createBank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label for="image">Imagen</label>
                            <input class="form-control" type="file" id="image" @change="onImageChange" accept="image/*">
                            <img :src="imagePreview" alt="" style="width: 30%">
                        </div>
                        <div class="form-group">
                            <label for="text">Texto</label>
                            <input v-model = "text" class="form-control" id="text"></input>
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input v-model = "link" class="form-control" id="link"></input>
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
                    modalTitle:"Crear carrusel",
                    carouselId:"",
                    image:"",
                    text:"",
                    link:"",
                    action:"create",
                    imagePreview:"",
                    carousels:[],
                    pages:0
                }
            },
            methods:{

                create(){
                    this.action = "create"
                    this.image = ""
                    this.text = ""
                    this.link = ""
                    this.modalTitle = "Nuevo carrusel"
                    this.carouselId = ""
                },
                store(){

                    axios.post("{{ url('api/admin/carousel/store') }}", {image: this.image, text: this.text, link: this.link})
                    .then(res => {

                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            })
                            this.imagePreview = ""
                            this.text = ""
                            this.link = ""
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

                    axios.post("{{ url('/api/admin/carousel/update') }}", {id: this.carouselId, image: this.image, text: this.text, link: this.link})
                    .then(res => {

                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            })
                            this.imagePreview = ""
                            this.text = ""
                            this.link = ""
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
                edit(carousel){
                    this.modalTitle = "Editar carrusel"
                    this.action = "edit"
                    this.imagePreview = carousel.image,
                    this.text = carousel.text,
                    this.link  = carousel.link,
                    this.carouselId = carousel.id
                },
                fetch(){

                    axios.get("{{ url('/api/admin/carousel/fetch') }}")
                    .then(res => {

                        this.carousels = res.data.carousels
                        //this.pages = Math.ceil(res.data.categoriesCount / 20)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/api/admin/carousel/delete/') }}", {id: id}).then(res => {

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
                }
                

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush