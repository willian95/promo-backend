@extends("layouts.user")

@section("content")

    <div class="container pt-150" id="dev-area">
        <div class="row">
            <div class="col-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Titulo del Post</th>
                            <th>Total</th>
                            <th>Tipo de compra</th>
                            <th>Fecha</th>
                            <th>Status</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="purchase in purchases" v-if="purchase.post">
                            <td>@{{ purchase.post.title }}</td>
                            <td>$ @{{ parseInt(purchase.total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                            <td>
                                <span v-if="purchase.payment_type == 'reservation'">Reservación</span>
                                <span v-else>Compra</span>
                            </td>
                            <td>@{{ purchase.created_at.toString().substring(0, 10) }}</td>
                            <td>
                                <span v-if="purchase.is_payment_complete == 0 && purchase.payment_type == 'reservation'">Compra aún no finalizada</span>
                                <span v-if="purchase.is_payment_complete == 1 && purchase.shipping_state == 'en proceso'">Compra finalizada, en espera de la entrega</span>
                                <span v-if="purchase.is_payment_complete == 1 && purchase.shipping_state == 'entregado'">Articulo entregado, confirma el pedido</span>
                                <span v-if="purchase.is_payment_complete == 1 && purchase.shipping_state == 'recibido'">Articulo recibido</span>
                            </td>
                            <td>
                                <a class="button" :href="'{{ url('/') }}'+'/my-purchases/purchase/'+purchase.id" v-if="purchase.is_payment_complete == 0">Pagar</a>
                                <a class="button" :href="'{{ url('/') }}'+'/my-purchases/purchase/'+purchase.id" v-else>Ver</a>
                                <button class="button" @click="confirmDelivery(purchase)" v-if="purchase.is_payment_complete == 1 && purchase.shipping_state == 'entregado'">Confirmar entrega</button>
                                <button class="button" data-toggle="modal" data-target="#rateModal"  v-if="purchase.is_seller_rated == false && purchase.shipping_state == 'recibido'" @click="qualify(purchase)">Calificar comprador</button>
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

        <div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Calificar Vendedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="purchase != ''">
                        <p>Vendedor: </p>
                        <h3 class="text-center">@{{ seller.name }}</h3>
                        
                        <select class="form-control" v-model="rate">
                            <option value="5">Muy bueno</option>
                            <option value="4">Bueno</option>
                            <option value="3">Regular</option>
                            <option value="2">Malo</option>
                            <option value="1">Muy malo</option>
                        </select>
                        
                        <div class="form-group">
                            <label>Comentario</label>
                            <textarea class="form-control" rows="3" v-model="comment" style="margin-top: 10px;"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="rateUser()">Calificar</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@push("scripts")    

    <script>
        const dev = new Vue({
            el: '#dev-area',
            data(){
                return{
                    purchases:"",
                    purchase:"",
                    seller:"",
                    rate:"",
                    comment:"",
                    pages:0,
                    page:1
                }
            },
            methods:{
                
                fetch(page = 1){

                    this.page = page

                    axios.get("{{ url('api/my-purchases/fetch/') }}"+"/"+this.page,{
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    })
                    .then(res => {

                        if(res.data.success == true){
                            this.purchases = res.data.purchases
                            this.pages = Math.ceil(res.data.purchasesCount / 20)
                        }

                    })
                },
                confirmDelivery(purchase){

                    axios.post("{{ url('api/purchase/confirmDelivery') }}", {id: purchase.id})
                    .then(res => {

                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            })
                            this.fetch(this.page)

                        }else{
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })
                        }

                    })

                },
                rateUser(){

                    axios.post("{{ url('api/rate/store') }}", {purchaseId: this.purchase.id, sellerId: this.seller.id, rate: this.rate, comment: this.comment}, {
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    })
                    .then(res => {

                        if(res.data.success == true){
                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            })
                            this.purchase = ""
                            this.seller = ""
                            this.rate = ""
                            this.comment = ""
                            this.fetch(this.page)
                        }else{
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value[0])
                            //alertify.error(value);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })

                },
                qualify(purchase){

                    this.purchase = purchase
                    this.seller = purchase.post.user

                }
            
            },
            created(){

                this.fetch()

            }

        })
    </script>

@endpush