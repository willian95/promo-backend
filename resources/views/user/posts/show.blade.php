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
                    <li><span style="color:#fad201" class="fa fa-check"></span>Descuento:  <span style="font-weight: bold;">@{{ discountPercentage }} %</span></li>
                    <li><span style="color:#fad201" class="fa fa-check"></span>Precio de venta:  <span style="font-weight: bold;">$ @{{ parseInt(price) }}</span> </li>
                    <li><span style="color:#fad201" class="fa fa-check"></span>Precio por hoy: <span style="font-weight: bold;" v-if="discountPrice <= 0">$ @{{ parseInt(price)  }}</span><span style="font-weight: bold;" v-else>$ @{{ parseInt(discountPrice)  }}</span></li>
                </ul>

                <div v-if="todaysDate >= startDate && todaysDate <= dueDate">

                    <div v-if="authCheck == true">
                        <p>
                            Cantidad: <input type="text" class="form-control" v-model="amount">
                        </p>

                        <a href="#"><button class="res button" style="margin-top: 3%;" data-toggle="modal" data-target="#shop">@{{ purchaseButtonText }}</button></a>
                    </div>
                    <div v-else>
                        <h3 >Para comprar debes iniciar sesión</h3>
                    </div>

                </div>
                <h3 v-if="todaysDate < startDate">Aún no ha comenzado la venta de esta promoción</h3>
                <h3 v-if="todaysDate > dueDate">Esta promoción ya terminó</h3>
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

                        <p v-if="discountPrice > 0 && purchaseType == 'purchase'">Monto a transferir: @{{ parseInt(discountPrice) * amount  }}</p>
                        <p v-if="discountPrice > 0 && purchaseType == 'reservation'">Monto a transferir: @{{ (parseInt(discountPrice) * amount) / 2  }}</p>
                        <p v-if="discountPrice == 0 && purchaseType == 'reservation'">Monto a transferir: @{{ (parseInt(price) * amount) / 2  }}</p>
                        <p v-if="discountPrice == 0 && purchaseType == 'purchase'">Monto a transferir: @{{ parseInt(price) * amount  }}</p>
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
                    postId:"{{ $post->id }}",
                    title:"{{ $post->title }}",
                    description:"{{ $post->description }}",
                    category:"{{ $post->category->name }}",
                    type:"{{ $post->type }}",
                    image:"{{ $post->image }}",
                    price:"{{ $post->price }}",
                    dueDate:"{{ $post->due_date }}",
                    startDate:"{{ $post->start_date }}",
                    showBuyButton:"{{ $showBuyButton }}",
                    discountPrice:0,
                    discountDays:JSON.parse('{!! $post->discountDays !!}'),
                    todaysDate:"{{ $todaysDate }}",
                    purchaseType:"reservation",
                    purchaseButtonText:"Reservar",
                    discountPercentage:0,
                    paymentMethod:"transfer",
                    bankSelected:"",
                    action: this.action,
                    amountAvailable:"{{ $post->amount }}",
                    amount:1,
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
                    let amountToPay = 0
                    if(this.purchaseType == "reservation"){
                        price = price / 2
                        amountToPay = price * this.amount
                    }else{
                        price = price
                        amountToPay = price * this.amount
                    }

                    axios.post("{{ url('/api/purchase/reserve') }}", {
                        postId: this.postId, 
                        price: price, 
                        amount: this.amount, 
                        transfer: this.transactionId, 
                        amountToPay: parseInt(amountToPay), 
                        bank: this.bankSelected.id, 
                        type: this.purchaseType, 
                        action: "make-purchase", 
                        purchaseId: this.purchaseId},
                        {
                            headers: {
                                Authorization: "Bearer "+window.localStorage.getItem('token')
                            }
                        }
                    )
                    .then(res => {
                       
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

                let lastDiscountDay = new Date(this.discountDays[6].date)
                let todaysDate = new Date(this.todaysDate)

                if(todaysDate > lastDiscountDay){
                    this.purchaseType = "purchase"
                    this.purchaseButtonText = "Comprar"
                }else{

                    this.discountDays.forEach((data) => {

                        if(data.date == this.todaysDate.substring(0, 10)){
                            this.discountPercentage = data.discount
                            if(this.discountPercentage > 0){
                                this.discountPrice = this.price - (this.price * (this.discountPercentage / 100))
                            }
                        }

                    })

                }

                if(this.type == "1"){
                    
                    this.price = parseInt(this.price) + (parseInt(this.price) * 0.0005) + 1
                    this.discountPrice = parseInt(this.discountPrice) + (parseInt(this.discountPrice) * 0.0005) + 1

                }else if(this.type == "2"){

                    this.price = parseInt(this.price) + (parseInt(this.price) * 0.0006) + 1
                    this.discountPrice = parseInt(this.discountPrice) + (parseInt(this.discountPrice) * 0.0006) + 1

                }else if(this.type == "3"){

                    this.price = parseInt(this.price) + (parseInt(this.price) * 0.0007) + 1
                    this.discountPrice = parseInt(this.discountPrice) + (parseInt(this.discountPrice) * 0.0007) + 1

                }

            }

        })
    </script>


@endpush