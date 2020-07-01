@extends("layouts.user")

@section("content")

    <div class="container detail" id="dev-area">

        <div class="info-detail" style="margin-top: 50px;">
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
                    <li><span style="color:#fad201" class="fa fa-check"></span>Total a pagar:  <span style="font-weight: bold;">@{{ parseInt(price / 2) }} </span></li>
                </ul>


                <div v-if="authCheck == true">
                    <a href="#" v-if="todaysDate >= saleDate && todaysDate <= dueDate && isPaymentComplete == false"><button class="res button" style="margin-top: 3%;" data-toggle="modal" data-target="#shop">@{{ purchaseButtonText }}</button></a>
                    <h5 v-if="todaysDate < saleDate">La publicación aún no ha llegado al periodo de pago</h5>
                    <h5 v-if="todaysDate > dueDate">El periodo de pago de esta publicación ha pasado</h5>
                </div>
                <div v-else>
                    <h3 >Para comprar debes iniciar sesión</h3>
                </div>

            </div>
            
        </div>


    <!-- modal -->

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

                    <div class="text-center" v-if="amount > 0">
                        <button type="button" class="btn btn-primary" @click="transferType()">Transferencia</button>
                        <button type="button" class="btn btn-primary" @click="webpayType()">Webpay</button>
                    </div>

                    <div v-else>
                        <h3 class="text-center">Cantidad debe ser mayor a 0</h3>
                    </div>  

                    <div v-if="paymentMethod == 'transfer' && amount > 0">

                        <p>Monto a transferir: @{{ price / 2  }}</p>
                        <select class="form-control" v-model="bankSelected">
                            <option :value="bank" v-for="bank in banks">@{{ bank.bank_name }}</option>
                        </select>

                        <div v-if="bankSelected != '' && amount > 0" >
                            
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

                        <label for="transaction" v-if="amount > 0">Transacción</label>
                        <input type="text" class="form-control" v-model="transactionId" v-if="amount > 0">

                        <p class="text-center" v-if="amount > 0">
                            <button class="btn btn-success" @click="transfer()">transferir</button>
                        </p>

                    </div>
                    <div v-if="paymentMethod == 'webpay'">

                        <div class="text-center">
                            <button class="btn btn-success">
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

    <!-- modal -->

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
                    price:"{{ $purchase->total }}",
                    isPaymentComplete:"{{ $purchase->is_payment_complete }}",
                    saleDate:"{{ $purchase->post->sale_date }}",
                    dueDate:"{{ $purchase->post->due_date }}",
                    todaysDate:"{{ $todaysDate }}",
                    discountPrice:0,
                    purchaseType:"purchase",
                    purchaseButtonText:"Pagar",
                    paymentMethod:"transfer",
                    bankSelected:"",
                    amount:"{{ $purchase->amount }}",
                    transactionId:"",
                    banks:[],
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

                    let price = 0

                    if(this.discountPrice > 0){
                        price = this.discountPrice
                    }else{
                        price = this.price
                    }

                    let amountToPay = price * this.amount

                    axios.post("{{ url('/api/purchase/reserve') }}", {
                        postId: this.postId, 
                        price: price, 
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