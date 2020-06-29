@extends("layouts.user")

@section("content")

    <div id="dev-area">
        <div class="container" style="padding-top: 150px;">
            <div class="row">

                <div class="col-12">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vendedor</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(transfer, index) in transfers">
                                <td>@{{ index + 1 }}</td>
                                <td>@{{ transfer.purchase.post.user.name }}</td>
                                <td>@{{ transfer.created_at.toString().substring(0, 10) }}</td>
                                <td>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#detail" @click="show(transfer)">Ver detalles</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>

        <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="transferDetail != ''">
                        <p>Pago: @{{ transferDetail.amount_to_pay }}</p>
                        <p>Banco: @{{ transferDetail.bank.bank_name }}</p>
                        <p>N° cuenta: @{{ transferDetail.bank.account_number }}</p>
                        
                        <h3 class="text-center">Calificar vendedor</h3>
                        <select class="form-control" v-model="qualification">
                            <option value="5">Muy bueno</option>
                            <option value="4">Bueno</option>
                            <option value="3">Regular</option>
                            <option value="2">Malo</option>
                            <option value="1">Muy malo</option>
                        </select>

                        <p class="text-center">
                            <button class="btn btn-success">Calificar</button>
                        </p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push("scripts")

    <script>

        const body = new Vue({
            el: '#dev-area',
            data(){
                return{
                    transfers:[],
                    transferDetail:"",
                    qualification:""
                }
            },
            methods:{
                
                fetchTransfer(){

                    axios.get("{{ url('/api/my-transfers') }}", {
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }

                    }).then(res => {

                        if(res.data.success == true){
                            this.transfers = res.data.payments
                        }

                    })

                },

                qualify(){

                    alert("Usuario calificado")

                },

                show(transfer){

                    this.transferDetail = transfer

                }
        
            },
            created(){

                this.fetchTransfer()

            }
        })

    </script>

@endpush