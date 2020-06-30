@extends('layouts.admin')

@section('content')

    <div id="dev-area">
        <div class="container form">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Usuarios</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Email</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users">
                                <th>@{{ user.name }}</th>
                                <td>@{{ user.email }}</td>
                                <td>
                                    <a :href="'{{ url('/profile/') }}'+'/'+user.id" target="_blank" class="btn btn-info">ver</a>
                                    <button class="btn btn-danger" @click="erase(user.id)">Eliminar</button>
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
    
    </div>

@endsection

@push('scripts')

    <script>
                    
        const app = new Vue({
            el: '#dev-area',
            data(){
                return{
                    users:[],
                    page:1,
                    pages:0
                }
            },
            methods:{

                fetch(page = 1){

                    this.page = page

                    axios.get("{{ url('/api/admin/users/fetch') }}"+"/"+this.page)
                    .then(res => {

                        if(res.data.success == true){
                            this.users = res.data.users
                            this.pages = Math.ceil(res.data.usersCount / 20)
                        }
                        //this.pages = Math.ceil(res.data.categoriesCount / 20)

                    })

                },
                erase(id){

                    axios.post("{{ url('/api/admin/users/delete') }}", {id: id})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.fetch(this.page)
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