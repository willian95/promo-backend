@extends('layouts.admin')

@section('content')

    <div id="dev-area">
        <div class="container form">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Pagos</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Transacción</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(transfer, index) in transfers" v-if="transfer.user">
                                <th>@{{ transfer.transfer }}</th>
                                <td>@{{ transfer.created_at.toString().substring(0, 10) }}</td>
                                <td>@{{ transfer.user.name }}</td>
                                <td>@{{ transfer.state }}</td>
                                <td v-if="transfer.state == 'en proceso'">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createCategory" @click="show(transfer)">Ver</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="transfer != ''">
                        
                        <p>Banco: @{{ transfer.bank.bank_name }}</p>
                        <p>N° de cuenta: @{{ transfer.bank.account_number }}</p>
                        <p>Transacción: @{{ transfer.transfer }}</p>
                        <p>Usuario: @{{ transfer.user.name }}</p>
                        <p>Monto a pagar: $ @{{ parseInt(transfer.amount_to_pay) + 1 }}</p>
                        
                        <select class="form-control" v-model="state">
                            <option value="aprobado">Aprobar</option>
                            <option value="rechazado">Rechazar</option>
                        </select>
                        
                        <div class="form-group" v-if="state == 'rechazado'">
                            <label>Comentario</label>
                            <textarea class="form-control" rows="3" v-model="comment" style="margin-top: 10px;"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="update()">Actualizar</button>
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
                    transfers:[],
                    transfer:"",
                    comment:"",
                    state:"",
                    page:1,
                    pages:0
                }
            },
            methods:{

                update(){

                    axios.post("{{ url('/api/admin/payments/update') }}", {paymentId: this.transfer.id, state: this.state, comment: this.comment})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.transfer = ""
                            this.state = ""
                            this.comment = ""
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
                show(transfer){
                    this.transfer = transfer
                },
                fetch(page = 1){

                    this.page = page

                    axios.get("{{ url('/api/admin/payments/fetch') }}"+"/"+this.page)
                    .then(res => {
                        console.log(res)
                        if(res.data.success == true){
                            this.transfers = res.data.payments
                            this.pages = Math.ceil(res.data.paymentsCount / 20)
                        }
                        //this.pages = Math.ceil(res.data.categoriesCount / 20)

                    })

                }
                

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush