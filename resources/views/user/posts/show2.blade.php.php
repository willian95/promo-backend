
@extends("layouts.user")

@section("content")

    <div class="container pt-150" id="dev-area">

        <div class="row">
            <div class="col-12">
                <h3 class="text-center">@{{ title }}</h3>
            </div>
            <div class="col-md-5 col-lg-5">
                <img :src="'{{ url('/images/posts') }}'+'/'+image" style="width: 100%">
            </div>
            <div class="col-md-7 col-lg-7">
                <p class="text-dark">
                    <strong>Vendedor: </strong><a :href="'{{ url('/') }}'+'/profile'+'/'+seller.id">@{{ seller.name }}</a>
                </p>
                <p class="text-dark">
                    <span style="font-weight: bold;">Categoria</span>: @{{ category }}
                </p>
                <p>@{{ description }}</p>
                <p class="text-dark">
                    <strong>Descuento por hoy: </strong> @{{ discountPercentage }} %
                </p>
                <p class="text-dark">
                    <strong>Fecha de venta: </strong> @{{ saleDate.toString().substring(0, 10) }}
                </p>
                <p class="text-dark">
                    <strong>Fecha de finalización: </strong> @{{ dueDate.toString().substring(0, 10) }}
                </p>
                <p v-if="openDays.length > 0" class="text-dark">
                    <strong>Establecimiento abierto: </strong> @{{ openDays.replace(/,/g, ", ") }}
                </p>
                <p v-if="deliveryDays.length > 0" class="text-dark">
                    <strong>Delivery: </strong> @{{ deliveryDays.replace(/,/g, ", ") }}
                </p>
            </div>
        </div>

        <div class="row" style="margin-top: 30px;">

            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2" v-for="(product, index) in products">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4">
                            <img :src="'{{ url('/images/posts/products/') }}'+'/'+product.image" style="width: 100%">
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-center">@{{ product.title }}</h4>
                            <p class="text-justify">@{{ product.description }}</p>
                            
                        </div>
                        <div class="col-md-4">
                            <p><strong>Precio: </strong>$ @{{ parseInt(parseInt(product.price + (product.price * typePrice)) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>
                            <p class="text-dark" v-if="discountPercentage > 0"><strong>Precio por hoy: </strong>$ @{{ parseInt(parseInt((product.price) - (product.price * (discountPercentage/100)) + (product.price * typePrice)) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>
                           <!--<button class="btn btn-success" @click="substractUnit(index)">-</button> <input :id="'amount-'+index" type="text" class="form-control amount-input" style="width: 60px" value="0"> <button class="btn btn-success" @click="addUnit(index, product.amount)">+</button>-->
                           <div class="cantidad_btn">
                                <button class="btn" @click="substractUnit(index)">-</button>
                                <input :id="'amount-'+index" type="text" style="border:none; width: 12px;" class="amount-input" style="width: 60px" value="0">
                                <button class="btn" @click="addUnit(index, product.amount)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="text-center" v-if="hasDelivery == 1">
                    <p class="text-dark"><strong>Precio del delivery:</strong> @{{ parseInt(deliveryPrice).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="lunes" id="defaultCheck1" v-model="delivery" @click="checkDelivery()" :disabled="total <= 1">
                        <label class="form-check-label" for="defaultCheck1" style="color:#000">
                            ¿Desea delivery?
                        </label>
                    </div>
                    <small>Si no elige el servicio de delivery deberá buscar su promoción en el establecimiento de la publicación. Dicha dirección aparecerá en el perfil del vendedor.</small>                    
                </div>
            </div>
            <div class="col-12">
                
                <h3 class="text-center">Total: $ @{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</h3>
                <h3 class="text-center" v-if="purchaseType == 'reservation' && total > 0">Total a pagar por reservación: $ @{{ parseInt((total / 2)+1).toString().replace(/\B(?=(\d{3})+\b)/g, ".")  }}</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div v-if="todaysDate >= startDate && todaysDate <= dueDate">

                    <div v-if="authCheck == true && authUserId != seller.id">
                        <p class="text-center">
                            <a href="#"><button class="res button" style="margin-top: 3%;" data-toggle="modal" data-target="#shop" @click="productPushPurchase()">@{{ purchaseButtonText }}</button></a>
                        </p>
                    </div>
                    <div v-if="authCheck == false">
                        <h3 class="text-center">Para comprar debes iniciar sesión</h3>
                    </div>
                    <div v-if="authUserId == seller.id">
                        <h3 class="text-center">No puedes comprar o reservar una publicación que hayas hecho</h3>
                    </div>

                </div>
                <h3 v-if="todaysDate < startDate">Aún no ha comenzado la venta de esta promoción</h3>
                <h3 v-if="todaysDate > dueDate">Esta promoción ya terminó</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Fechas de Promoción</h3>
            </div>
            @foreach($promoPeriod as $promo)

                <div class="col-md-2">
                    <div class="card promo-date" style="height: 120px;">
                        <div class="card-body text-center">
                            
                            <p class="text-center"><strong>{{ $promo->locale('es')->dayName }}</strong></p>

                            <small>
                                {{ $promo->format('d-m-Y') }}
                            </small>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Fechas de Venta</h3>
            </div>
            @foreach($salePeriod as $sale)

                <div class="col-md-2">
                    <div class="card promo-date" style="height: 120px;">
                        <div class="card-body">
                            
                            <p class="text-center"><strong>{{ $sale->locale('es')->dayName }}</strong></p>

                            <small>
                                {{ $sale->format('d-m-Y') }}
                            </small>
                        </div>
                    </div>
                </div>

            @endforeach
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

                
                    <div v-if="paymentMethod == 'webpay'">

                        <div class="text-center" v-if="total > 1">

                            <img @click="webpay()" src="{{ asset('/user/images/article.jpg') }}" alt="" style="width: 200px; cursor: pointer;">
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
                    saleDate:"{{ $post->sale_date }}",
                    showBuyButton:"{{ $showBuyButton }}",
                    seller:JSON.parse('{!! $post->user !!}'),
                    products:JSON.parse('{!! $post->products !!}'),
                    productsPurchase:[],
                    discountPrice:0,
                    discountDays:JSON.parse('{!! $post->discountDays !!}'),
                    todaysDate:"{{ $todaysDate }}",
                    openDays:"{{ $post->user->open_days }}",
                    deliveryDays:"{{ $post->user->deliver_days }}",
                    purchaseType:"reservation",
                    purchaseButtonText:"Reservar",
                    discountPercentage:0,
                    paymentMethod:"webpay",
                    bankSelected:"",
                    total:0,
                    action: "make-purchase",
                    amountAvailable:"{{ $post->amount }}",
                    amount:1,
                    transactionId:"",
                    banks:[],
                    authCheck:false,
                    typePrice:0,
                    authUserId:0,
                    delivery:false,
                    originalPrice:"",
                    hasDelivery:"{{ $post->user->has_delivery }}",
                    deliveryPrice:"{{ $post->user->delivery_tax }}"
                }
            },
            methods:{

                checkDelivery(){

                    setTimeout(() => {

                        if(this.delivery == true){
                            this.total = parseInt(this.originalPrice) + parseInt(this.deliveryPrice)
                        }else{
                            this.total = parseInt(this.originalPrice)
                        }

                    }, 100);

                },
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
                addUnit(index, stock){
                    
                    let amount = $("#amount-"+index).val()
                    
                    if(parseInt(amount) + 1 <= stock){
                        amount++
                        $("#amount-"+index).val(amount)
                        this.checkTotal()
                    }
                    
                },
                substractUnit(index){
                    //alert(index)
                    let amount = $("#amount-"+index).val()
                    if(parseInt(amount) - 1 >= 0){
                        amount--
                        $("#amount-"+index).val(amount)
                        this.checkTotal()
                    }
                    
                },
                checkTotal(){

                    this.total = 0
                    var element = $('.amount-input').map((_,el) => el).get()
                    element.forEach((data, index) => {
                        
                        let value = $("#"+data.id).val()
                        let productPrice = this.products[parseInt(data.id.toString().substring(7, data.id.toString().length))].price
                        
                        this.total = this.total + (parseInt(value) * (parseInt((productPrice) - (productPrice * (this.discountPercentage/100)) + (productPrice * this.typePrice)) + 1))
                        this.originalPrice = this.total
                       
                    })

                },
                transfer(){

                    let price = 0

                    let amountToPay = 0
                    if(this.purchaseType == "reservation"){
                        if(this.delivery == true){
                            amountToPay = (this.total / 2) +1 
                        }
                        
                    }else{
                        amountToPay = this.total
                    }

                    axios.post("{{ url('/api/purchase/reserve') }}", {
                        postId: this.postId,  
                        amount: this.amount, 
                        transfer: this.transactionId, 
                        amountToPay: parseInt(amountToPay),
                        total: this.total, 
                        bank: this.bankSelected.id, 
                        type: this.purchaseType, 
                        action: "make-purchase", 
                        purchaseId: this.purchaseId,
                        productsPurchase: this.productsPurchase
                    },
                        {
                            headers: {
                                Authorization: "Bearer "+window.localStorage.getItem('token')
                            }
                        }
                    )
                    .then(res => {
                       
                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            }).then(() => {
                                window.location.href="{{ url('/') }}"
                            })

                        }else{
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            //alert(value)
                            alertify.error(value[0]);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })

                },
                productPushPurchase(){

                    var element = $('.amount-input').map((_,el) => el).get()
                    element.forEach((data, index) => {
                        
                        let value = $("#"+data.id).val()
                        if(value > 0){

                            let productPrice = this.products[parseInt(data.id.toString().substring(7, data.id.toString().length))].price
                            this.productsPurchase.push({product: this.products[parseInt(data.id.toString().substring(7, data.id.toString().length))], amount: value, price: (parseInt((productPrice) - (productPrice * (this.discountPercentage/100)) + (productPrice * this.typePrice)) + 1)})
                    
                        }
                       
                    })

                },
                webpay(){

                    let amountToPay = 0
                    if(this.purchaseType == "reservation"){
                        amountToPay = (this.total / 2) +1
                    }else{
                        amountToPay = this.total
                    }

                    axios.post("{{ url('/api/checkout/store/cart') }}", { total: this.total, amountToPay: amountToPay, paymentType: this.purchaseType, post_id: this.postId, productPurchases: this.productsPurchase, action: this.action, delivery:this.delivery,},{
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
                    this.authUserId = user.id 
                }

                let lastDiscountDay = new Date(this.discountDays[6].date)
                let todaysDate = new Date(this.todaysDate)

                if(todaysDate > lastDiscountDay){
                    this.purchaseType = "purchase"
                    this.purchaseButtonText = "Comprar"
                }else{

                    this.discountDays.forEach((data) => {
                        
                        if(data.date == this.todaysDate.substring(0, 10)){
                            console.log(data.date.toString(), this.todaysDate.substring(0, 10))
                            this.discountPercentage = data.discount
                        }

                    })

                }

                if(this.type == "1"){
                    
                    this.typePrice = 0.0005

                }else if(this.type == "2"){

                    this.typePrice = 0.0006

                }else if(this.type == "3"){

                    this.typePrice = 0.0007

                }

            }

        })
    </script>


@endpush