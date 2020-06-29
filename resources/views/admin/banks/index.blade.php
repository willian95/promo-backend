@extends('layouts.admin')

@section('content')

    <div id="dev-area">
        <div class="container form">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Bancos</h3>
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
                                <th scope="col">Banco</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(bank, index) in banks">
                                <th>@{{ index + 1 }}</th>
                                <td>@{{ bank.bank_name }}</td>
                                <td>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createBank" @click="edit(bank)">editar</button>
                                    <button class="btn btn-danger" @click="erase(bank.id)">eliminar</button>
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
                            <label for="holderName">Nombre del propietario</label>
                            <input class="form-control" v-model="holderName" id="holderName"></input>
                        </div>
                        <div class="form-group">
                            <label for="holderRut">RUT del propietario</label>
                            <input v-model = "holderRut" class="form-control" id="holderRut"></input>
                        </div>
                        <div class="form-group">
                            <label for="bankName">Nombre del banco</label>
                            <input v-model = "bankName" class="form-control" id="bankName"></input>
                        </div>
                        <div class="form-group">
                            <label for="accountNumber">Número de  cuenta</label>
                            <input v-model = "accountNumber" id="accountNumber" class="form-control"></input>
                        </div>
                        <div class="form-group">
                            <label for="accountType">Tipo de cuenta</label>
                            <select placeholder="Elija" v-model="accountType" class="form-control">
                                <option value="ahorro">Ahorro</option>
                                <option value="corriente">Corriente</option>
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
                    holderName:"",
                    holderRut:"",
                    bankName:"",
                    accountNumber:"",
                    accountType:"",
                    bankId:"",
                    action:"create",
                    banks:[],
                    pages:0
                }
            },
            methods:{

                create(){
                    this.action = "create"
                    this.holderName = ""
                    this.holderRut = ""
                    this.bankName = ""
                    this.accountNumber = ""
                    this.accountType = ""
                    this.modalTitle = "Nueva categoría"
                    this.bankId = ""
                },
                store(){

                    axios.post("{{ url('api/admin/bank/store') }}", {holderName: this.holderName, holderRut: this.holderRut, bankName: this.bankName, accountNumber:this.accountNumber, accountType: this.accountType})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.holderName = ""
                            this.holderRut = ""
                            this.bankName = ""
                            this.accountNumber = ""
                            this.accountType = ""
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

                    axios.post("{{ url('/api/admin/bank/update') }}", {id: this.bankId, holderName: this.holderName, holderRut: this.holderRut, bankName: this.bankName, accountNumber:this.accountNumber, accountType: this.accountType})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.holderName = ""
                            this.holderRut = ""
                            this.bankName = ""
                            this.accountNumber = ""
                            this.accountType = ""
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
                edit(bank){
                    this.modalTitle = "Editar banco"
                    this.action = "edit"
                    this.holderName = bank.holder_name
                    this.holderRut = bank.holder_rut
                    this.bankName = bank.bank_name
                    this.accountNumber = bank.account_number
                    this.accountType = bank.account_type
                    this.bankId = bank.id
                },
                fetch(){

                    axios.get("{{ url('/api/bank/fetch') }}")
                    .then(res => {

                        this.banks = res.data.banks
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

                        axios.post("{{ url('/api/admin/bank/delete/') }}", {id: id}).then(res => {

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