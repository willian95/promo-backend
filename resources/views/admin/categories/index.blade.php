@extends('layouts.admin')

@section('content')

    <div id="dev-area">
        <div class="container form">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Categorías</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-center">
                        <button class="btn btn-success" data-toggle="modal" data-target="#createCategory" @click="create()">Crear</button>
                    </p>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category, index) in categories">
                                <th>@{{ index + 1 }}</th>
                                <td>@{{ category.name }}</td>
                                <td>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createCategory" @click="edit(category)">editar</button>
                                    <button class="btn btn-danger" @click="erase(category.id)">eliminar</button>
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

        <div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" v-model="name">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea class="form-control" rows="5" v-model="description" id="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <select class="form-control" id="color" v-model="color">
                                <option value="blue">Azul</option>
                                <option value="red">Rojo</option>
                                <option value="yellow">Amarillo</option>
                                <option value="green">Verde</option>
                                <option value="purple">Violeta</option>
                            </select>
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
                    modalTitle:"Crear categoría",
                    description:"",
                    name:"",
                    color:"",
                    categoryId:"",
                    action:"create",
                    categories:[],
                    pages:0
                }
            },
            methods:{

                create(){
                    this.action = "create"
                    this.name = ""
                    this.description = ""
                    this.color = ""
                    this.modalTitle = "Nueva categoría"
                    this.categoryId = ""
                },
                store(){

                    axios.post("{{ url('api/admin/category/store') }}", {name: this.name, description: this.description, color: this.color})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.name = ""
                            this.description = ""
                            this.color = ""
                            this.fetch()
                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                update(){

                    axios.post("{{ url('/api/admin/category/update') }}", {id: this.categoryId, name: this.name, description: this.description, color: this.color})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.name = ""
                            this.description = ""
                            this.color = ""
                            this.fetch()
                            
                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                edit(category){
                    this.modalTitle = "Editar categoría"
                    this.action = "edit"
                    this.name = category.name
                    this.description = category.description
                    this.color = category.color
                    this.categoryId = category.id
                },
                fetch(){

                    axios.get("{{ url('/api/admin/category/fetch') }}")
                    .then(res => {

                        this.categories = res.data.categories
                        //this.pages = Math.ceil(res.data.categoriesCount / 20)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/api/admin/category/delete/') }}", {id: id}).then(res => {

                            if(res.data.success == true){
                                alert(res.data.msg)
                                this.fetch()
                            }else{

                                alert(res.data.msg)

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