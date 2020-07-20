@extends("layouts.user")

@section("content")

    <div class="container detail" id="dev-area">

        <!--<div class="info-detail" style="margin-top: 50px;">
            <div class="info-img" style="width: 100%">
                <img :src="'{{ url('/images/posts') }}'+'/'+image">
            </div>
            <div class="view-detail">
                <h3>@{{ title }}</h3>
                <p>
                    <span style="font-weight: bold;">Categoria</span>: @{{ category }}
                </p>
                <p>@{{ description }}</p>
                <ul>
                    <li><span style="color:#fad201" class="fa fa-check"></span>Total a pagar:  <span style="font-weight: bold;">@{{ parseInt(price) }} </span></li>
                </ul>


                <div v-if="authCheck == true">


                    <h5 v-if="todaysDate < saleDate">La publicación aún no ha llegado al periodo de pago</h5>
                    <h5 v-if="todaysDate > dueDate">El periodo de pago de esta publicación ha pasado</h5>
                    <h5 v-if="paymentsAproved >= 1 && paymentsWaiting == 1 || paymentsWaiting > 1">Ya ha realizado los pagos respectivos, espere la confirmación de los mismos</h5>
                    <div v-else>
                        <a href="#" v-if="todaysDate >= saleDate && todaysDate <= dueDate && isPaymentComplete == false"><button class="res button" style="margin-top: 3%;" data-toggle="modal" data-target="#shop">@{{ purchaseButtonText }}</button></a>
                    </div>
                    
                </div>
                <div v-else>
                    <h3 >Para comprar debes iniciar sesión</h3>
                </div>

            </div>
            
        </div>-->

        <div class="row">
            <div class="col-12">
                <h3 class="text-center">@{{ title }}</h3>
            </div>
            <div class="col-md-5 col-lg-5">
                <img :src="'{{ url('/images/posts') }}'+'/'+image" style="width: 100%">
            </div>
            <div class="col-md-7 col-lg-7">
                <p>
                    <strong>Vendedor: </strong><a :href="'{{ url('/') }}'+'/profile'+'/'+seller.id">@{{ seller.name }}</a>
                </p>
                <p>
                    <span style="font-weight: bold;">Categoria</span>: @{{ category }}
                </p>
                <p>@{{ description }}</p>
                <p>
                    <strong>Fecha de venta: </strong> @{{ saleDate.toString().substring(0, 10) }}
                </p>
                <p>
                    <strong>Fecha de finalización: </strong> @{{ dueDate.toString().substring(0, 10) }}
                </p>
                <p v-if="seller.open_days != null">
                    <strong>Establecimiento abierto: </strong> @{{ seller.open_days.replace(/,/g, ", ") }}
                </p>
                <p v-if="seller.deliver_days != null">
                    <strong>Delivery: </strong> @{{ seller.deliver_days.replace(/,/g, ", ") }}
                </p>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-10 offset-lg-2 col-md-8 offset-md-2" v-for="(product, index) in products">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4">
                            <img :src="'{{ url('/images/posts/products') }}'+'/'+product.post_product.image" style="width: 100%">
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-center">@{{ product.post_product.title }}</h4>
                            <p class="text-justify">@{{ product.post_product.description }}</p>
                            
                        </div>
                        <div class="col-md-4">
                            <p><strong>Precio: </strong>$ @{{ parseInt(product.price) }}</p>
                            
                            <input readonly :id="'amount-'+index" type="text" class="form-control amount-input" style="width: 60px" :value="product.amount">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <h3 v-if="delivery == true">Delivery Activo</h3>
                <h3 class="text-center">Total: $ @{{ total }}</h3>
                <h3 class="text-center" v-if="purchaseType == 'reservation' && total > 0">Total a pagar por reservación: $ @{{ parseInt((total / 2)+1)  }}</h3>
            </div>
        </div>

        <div v-if="authCheck == true">

            <h5 v-if="todaysDate < saleDate">La publicación aún no ha llegado al periodo de pago</h5>
            <h5 v-if="todaysDate > dueDate">El periodo de pago de esta publicación ha pasado</h5>
            <h5 v-if="paymentsAproved >= 1 && paymentsWaiting == 1 || paymentsWaiting > 1">Ya ha realizado los pagos respectivos, espere la confirmación de los mismos</h5>
            <div v-else>
                <a href="#" v-if="todaysDate >= saleDate && todaysDate <= dueDate && isPaymentComplete == false"><button class="res button" style="margin-top: 3%;" data-toggle="modal" data-target="#shop">@{{ purchaseButtonText }}</button></a>
            </div>
            
        </div>
        <div v-else>
            <h3 >Para comprar debes iniciar sesión</h3>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Pagos</h3>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Transacción</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="payment in payments">
                                <td>@{{ payment.transfer }}</td>
                                <td>@{{ payment.created_at.toString().substring(0, 10) }}</td>
                                <td>@{{ parseInt(payment.amount_to_pay) }}</td>
                                <td>@{{ payment.state }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    <div class="modal fade" id="shop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tipo de pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="text-center" v-if="total > 1">
                        <!--<button type="button" class="btn btn-primary" @click="transferType()">Transferencia</button>
                        <button type="button" class="btn btn-primary" @click="webpayType()">Webpay</button>-->
                    </div>

                    <div v-else>
                        <h3 class="text-center">Cantidad debe ser mayor a 0</h3>
                    </div> 


                    <!--<div v-if="paymentMethod == 'transfer' && total > 1">

                        <p v-if="purchaseType == 'reservation'">Monto a transferir: @{{ parseInt(total / 2) + 1  }}</p>
                        <p v-else>Monto a transferir: @{{ total  }}</p>
                        <select class="form-control" v-model="bankSelected">
                            <option :value="bank" v-for="bank in banks">@{{ bank.bank_name }}</option>
                        </select>

                        <div v-if="bankSelected != '' && total > 1" >
                            
                            <h5>Información para la transferencia</h5>
                            
                            <p>
                            Nombre: @{{ bankSelected.holder_name }}
                            </p>
                            <p>
                            N° Cuenta: @{{ bankSelected.account_number }}
                            </p>
                            <p>
                            RUT: @{{ bankSelected.holder_rut }}
                            </p>
                            <p>
                            Tipo de cuenta: @{{ bankSelected.account_type }}
                            </p>
                        </div>

                        <label for="transaction" v-if="total > 1">Transacción</label>
                        <input type="text" class="form-control" v-model="transactionId" v-if="total > 1">

                        <p class="text-center" v-if="total > 1">
                            <button class="btn btn-success" @click="transfer()">transferir</button>
                        </p>

                    </div>-->
                    <div v-if="paymentMethod == 'webpay'">

                        <div class="text-center">
                            <button class="btn btn-success" @click="webpay()">
                                Webpay
                            </button>
                        </div>

                    </div>

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
        const app = new Vue({
            el: '#dev-area',
            data(){
                return{
                    purchaseId:"{{ $purchase->id }}",
                    title:"{{ $purchase->post->title }}",
                    description:"{{ $purchase->post->description }}",
                    category:"{{ $purchase->post->category->name }}",
                    image:"{{ $purchase->post->image }}",
                    price:"{{ $purchase->price }}",
                    seller:JSON.parse('{!! $purchase->user !!}'),
                    isPaymentComplete:"{{ $purchase->is_payment_complete }}",
                    saleDate:"{{ $purchase->post->sale_date }}",
                    dueDate:"{{ $purchase->post->due_date }}",
                    todaysDate:"{{ $todaysDate }}",
                    products:JSON.parse('{!! $purchase->productsPurchase !!}'),
                    paymentsAmount: "{{ $paymentsAmount }}",
                    paymentsAproved: "{{ $paymentsAproved }}",
                    paymentsWaiting: "{{ $paymentsWaiting }}",
                    payments:JSON.parse('{!! json_encode($purchase->payments) !!}'),
                    discountPrice:0,
                    total:"{{ $purchase->total }}",
                    purchaseType:"{{ $purchase->payment_type }}",
                    purchaseButtonText:"Pagar",
                    paymentMethod:"webpay",
                    bankSelected:"",
                    amount:"{{ $purchase->amount }}",
                    transactionId:"",
                    banks:[],
                    delivery:"{{ $purchase->has_delivery }}",
                    authCheck:false
                }
            },
            methods:{
                
                transferType(){

                    this.paymentMethod = "transfer"

                },
                webpayType(){

                    this.paymentMethod = "webpay"

                },  
                shop(){

                    if(this.purchaseType == "reservation"){



                    }else{

                    }

                },
                fetchBanks(){

                    axios.get("{{ url('/api/bank/fetch') }}").then(res => {

                        if(res.data.success == true){
                            this.banks = res.data.banks
                        }
                        

                    })

                },
                transfer(){


                    let amountToPay = this.price

                    axios.post("{{ url('/api/purchase/reserve') }}", {
                        postId: this.postId, 
                        price: this.price, 
                        amount: this.amount, 
                        transfer: this.transactionId, 
                        amountToPay: amountToPay, 
                        bank: this.bankSelected.id, 
                        type: this.purchaseType, 
                        action: "", 
                        purchaseId: this.purchaseId},
                        {
                            headers: {
                                Authorization: "Bearer "+window.localStorage.getItem('token')
                            }
                        }
                    )
                    .then(res => {
                        
                        console.log(res)

                        if(res.data.success == true){

                            alert(res.data.msg)
                            window.location.href="{{ url('/') }}"

                        }else{
                            alert(res.data.msg)
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alert(value)
                            //alertify.error(value);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })

                },
                webpay(){

                    let amountToPay = 0
                    if(this.purchaseType == "reservation"){
                        amountToPay = (this.total / 2) +1
                    }else{
                        amountToPay = this.total
                    }

                    axios.post("{{ url('/api/checkout/store/cart') }}", { total: this.total, amountToPay: amountToPay, paymentType: this.purchaseType, post_id: this.postId, productPurchases: this.productsPurchase, purchase_id: this.purchaseId},{
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    }).then(res => {

                        if(res.data.success == true){
                            window.location.href="{{ url('/checkout') }}"+"?token="+window.localStorage.getItem('token');
                        }

                    })

                }

            },
            created(){

                this.fetchBanks()

                let user = JSON.parse(localStorage.getItem("user"))
                if(user != null){
                    this.authCheck = true   
                }
                
            }

        })
    </script>


@endpush