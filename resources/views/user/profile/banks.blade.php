@extends("layouts.user")

@push("css")

    <style>
        input, select, textarea{
            margin-bottom:15px;
        }
    </style>

@endpush

@section("content")
<div>

    <div class="container pt-150" id="dev-area">

        <div class="elipse" v-if="loading == true">
            <img src="{{ asset('user/images/logo.png') }}">
        </div>

        <div class="row">

            <div class="col-12">
                <h3 class="text-center">Cuentas</h3>
            </div>

            <div class="col-lg-12">

                <p class="text-center">
                    <button class="btn btn-success" data-toggle="modal" data-target="#bank" @click="create()">+</button>
                </p>    
            
            </div>

            <div class="col-lg-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th style="color: #34495e;">Banco</th>
                            <th style="color: #34495e;">Nro Cuenta</th>
                            <th style="color: #34495e;">RUT</th>
                            <th style="color: #34495e;">Email</th>
                            <th style="color: #34495e;">Tipo de cuenta</th>
                            <th style="color: #34495e;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="account in accounts">
                            <td style="color: #34495e;">@{{ account.bank.name }}</td>
                            <td style="color: #34495e;">@{{ account.account_number }}</td>
                            <td style="color: #34495e;">@{{ account.rut }}</td>
                            <td style="color: #34495e;">@{{ account.email }}</td>
                            <td style="color: #34495e;">@{{ account.account_type }}</td>
                            <td>
                                <button class="btn btn-success" data-toggle="modal" data-target="#bank" @click="edit(account)">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-secondary" @click="deleteAccount(account.id)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            

        </div>

        <div class="modal fade" id="bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label for="titleProduct">Banco</label>
                            <select class="form-control" style="background: #fff !important; color: #999 !important;" v-model="bankId">
                                <option :value="bank.id" v-for="bank in banks">@{{ bank.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descriptionProduct">Nro de cuenta</label>
                            <input type="text" class="form-control input-promo " id="priceProduct" v-model="accountNumber">
                        </div>
                        <div class="form-group">
                            <label for="rut">RUT</label>
                            <input type="text" class="form-control input-promo " id="rut" v-model="rut">
                        </div>

                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="text" class="form-control input-promo " id="email" v-model="email">
                        </div>
                        
                        <div class="form-group">
                            <label for="titleProduct">Tipo de cuenta</label>
                            <select class="form-control" style="background: #fff !important; color: #999 !important;" v-model="accountType">
                                <option value="ahorro">Ahorro</option>
                                <option value="corriente">Corriente</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button v-if="action == 'create'" type="button" class="btn btn-primary" data-dismiss="modal" @click="storeAccount()">Crear</button>
                        <button v-if="action == 'edit'" type="button" class="btn btn-primary" data-dismiss="modal" @click="updateAccount()">Actualizar</button>
                    </div>
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
                    action:"create",
                    modalTitle:"Añadir cuenta",
                    bankId:"",
                    banks:[],
                    accountId:"",
                    accounts:[],
                    accountNumber:"",
                    rut:"",
                    email:"",
                    accountType:"ahorro",
                    loading:false
                }
            },
            methods:{
                
                fetchBanks(){

                    axios.get("{{ url('api/bank/fetch') }}").then(res => {

                        this.banks = res.data.banks

                    })

                },
                fetchAccounts(){

                    axios.get("{{ url('api/my-account/fetch') }}", {headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }}).then(res => {

                        this.accounts = res.data.accounts

                    })

                },
                create(){

                    this.action = "create"
                    this.modalTitle = "Añadir cuenta"
                    this.bankId = ""
                    this.accountId=""
                    this.accountNumber=""
                    this.rut=""
                    this.email=""
                    this.accountType="ahorro"

                },
                edit(account){

                    this.action = "edit"
                    this.modalTitle = "Añadir cuenta"
                    this.bankId = account.bank_id
                    this.accountId= account.id
                    this.accountNumber= account.account_number
                    this.rut= account.rut
                    this.email= account.email
                    this.accountType= account.account_type

                },
                storeAccount(){
                    this.loading = true
                    axios.post("{{ url('/my-profile/bank/store') }}", {bankId: this.bankId, accountNumber: this.accountNumber, rut: this.rut, email: this.email, accountType: this.accountType}, {headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }}).then(res => {

                            this.loading = false

                        if(res.data.success == true){

                            swal({
                                "title": "Genial",
                                "text": res.data.msg,
                                "icon": "success"
                            })

                            this.fetchAccounts()

                        }else{

                            swal({
                                "title": "Lo sentimos",
                                "text": res.data.msg,
                                "icon": "error"
                            })

                        }

                    })
                    .catch(err => {
                        this.loading = false
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value[0])
                        });
                    })

                },
                updateAccount(){
                    this.loading = true
                    axios.post("{{ url('/my-profile/bank/update') }}", {accountId: this.accountId, bankId: this.bankId, accountNumber: this.accountNumber, rut: this.rut, email: this.email, accountType: this.accountType}, {headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }}).then(res => {

                            this.loading = false

                        if(res.data.success == true){

                            swal({
                                "title": "Genial",
                                "text": res.data.msg,
                                "icon": "success"
                            })

                            this.fetchAccounts()

                        }else{

                            swal({
                                "title": "Lo sentimos",
                                "text": res.data.msg,
                                "icon": "error"
                            })

                        }

                    })
                    .catch(err => {
                        this.loading = false
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value[0])
                        });
                    })

                },
                deleteAccount(id){

                    swal({
                        title: "¿Estás seguro?",
                        text: "Eliminarás esta cuenta!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            
                            axios.post("{{ url('/my-profile/bank/delete') }}", {id: id})
                            .then(res => {

                                if(res.data.success == true){

                                    swal({
                                    
                                        text:res.data.msg,
                                        icon:"success"
                                    })

                                    this.fetchAccounts()

                                }else{

                                    swal({
                                        title:"Lo sentimos",
                                        text:res.data.msg,
                                        icon:"error"
                                    })

                                }

                            })


                        }
                    });

                },

            },
            
            created(){

                this.fetchBanks()
                this.fetchAccounts()
                

            }

        })
    </script>

@endpush