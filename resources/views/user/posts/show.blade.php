
@extends("layouts.user")

@section("content")

    <section class="vista-interna" id="dev-area">

        <div class="elipse" v-if="loading == true">
            <img src="{{ asset('user/images/logo.png') }}">
        </div>

         <!--<div class="cat-comilandia">
            <div class="btn-group">
                <button type="button" class="btn cat-comilandia-btn">Basico</button>
                <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                </button>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Link 1</a>
                <a class="dropdown-item" href="#">Link 2</a>
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn cat-comilandia-btn">Superior</button>
                <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                </button>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Link 1</a>
                <a class="dropdown-item" href="#">Link 2</a>
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn cat-comilandia-btn">Premium</button>
                <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                </button>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Link 1</a>
                <a class="dropdown-item" href="#">Link 2</a>
                </div>
            </div>
        </div>-->
        <div class="descrip-producto-comilandia">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 img-producto-detallado">
                         <!-- <div class="descrip-producto-comilandia-descuento"><div class="descrip-producto-comilandia-descuento-des">@{{ discountPercentage }} %</div></div> -->
                         <img class="descrip-producto-comilandia_img" :src="'{{ url('/images/posts') }}'+'/'+image"  >
                         <div class="descrip-producto-comilandia-cont-categoria"><div class="descrip-producto-comilandia-cont-categoria-div">- @{{ discountPercentage }} %</div></div>
                    </div>
                    <div class="col-md-7">
                        <div class="cont-inf-descrip-producto-comilandia">
                            <img :src="'{{ url('/assets/images/etiqueta-basica.png') }}'" alt="" v-if="type == 1">
                            <img :src="'{{ url('/assets/images/etiqueta-superior.png') }}'" alt="" v-if="type == 2">
                            <img :src="'{{ url('/assets/images/etiqueta-premium.png') }}'" alt="" v-if="type == 3">
                            <h2>@{{ category }}</h2>
                            <p>@{{ description }}</p>
                            <div class="cont-inf-descrip-producto-comilandia-desc-det">
                                <div class="row">
                                    <div class="col-md-8 cont-inf-descrip-producto-comilandia-desc-det-cajas">
                                        <div class="caja-descrip-detallada"><h3><strong>Fecha de venta: </strong> @{{ saleDate.toString().substring(0, 10) }}</h3></div>
                                        <div class="caja-descrip-detallada"><h3><strong>Fecha de finalización: </strong> @{{ dueDate.toString().substring(0, 10) }}</h3></div>
                                        <div class="caja-descrip-detallada"><h3><strong>Establecimiento abierto: </strong> @{{ openDays.replace(/,/g, ", ") }}</h3></div>
                                        <div class="caja-descrip-detallada"><h3><strong>Delivery: </strong> @{{ deliveryDays.replace(/,/g, ", ") }}</h3></div>
                                        <!--<div class="caja-descrip-detallada"><h3>Tocino</h3></div>
                                        <div class="caja-descrip-detallada"><h3>Champiñones</h3></div>-->

                                    </div>
                                    
                                </div>
                                <!--<div class="row">
                                    <div class="col-md-12">
                                        <div class="cont-inf-descrip-producto-comilandia-c-fechas">
                                            <div class="cont-inf-descrip-producto-comilandia-fechas">01/01/2001<img class="descrip-producto-comilandia_img" src="{{ asset('user/images/calendario.png') }}"  ></div>
                                            <div class="cont-inf-descrip-producto-comilandia-fechas">01/01/2001<img class="descrip-producto-comilandia_img" src="{{ asset('user/images/calendario.png') }}"  ></div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
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
                                    <button class="btn cat-comilandia-btn" style="margin-top: 3%;" data-toggle="modal" data-target="#shop" @click="productPushPurchase()">@{{ purchaseButtonText }}</button>
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
                        <small>Debes realizar una transferencia a la cuenta seleccionada</small>
                        <select class="form-control" v-model="selectedAccount" style="background: #fff !important; color: #999 !important;"> 
                            <option value="">Seleccione</option>
                            <option :value="account" v-for="account in accounts">@{{ account.bank.name }}</option>
                        </select>

                        <div v-if="selectedAccount != ''">
                            <div class="form-group">
                                <label for="">Nro Cuenta</label>
                                <input type="text" readonly class="form-control" :value="selectedAccount.account_number">
                            </div>

                            <div class="form-group">
                                <label for="">RUT</label>
                                <input type="text" readonly class="form-control" :value="selectedAccount.rut">
                            </div>

                            <div class="form-group">
                                <label for="">Correo Electrónico</label>
                                <input type="text" readonly class="form-control" :value="selectedAccount.email">
                            </div>

                            <div class="form-group">
                                <label for="">Tipo de cuenta</label>
                                <input type="text" readonly class="form-control" :value="selectedAccount.account_type">
                            </div>

                            <div class="form-group">
                                <label for="">Monto a enviar</label>
                                <input type="text" readonly class="form-control" :value="parseInt((total / 2)+1).toString().replace(/\B(?=(\d{3})+\b)/g, '.')">
                            </div>

                            <div class="form-group">
                                <label for="">Ingrese su RUT</label>
                                <input type="text" class="form-control" style="color: #000 !important;" v-model="clientRut">
                            </div>
                        </div>

                    </div>

                    <div v-else>
                        <h3 class="text-center">Cantidad debe ser mayor a 0</h3>
                    </div>  

                
                    {{--<div v-if="paymentMethod == 'webpay'">

                        <div class="text-center" v-if="total > 1">

                            <img @click="webpay()" src="{{ asset('/user/images/article.jpg') }}" alt="" style="width: 200px; cursor: pointer;">
                        </div>

                    </div>--}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="notifyTransfer()">Notificar</button>
                </div>
            </div>
        </div>
    </div>
        <!--<div class="container cont-productos">
            <div class="prod-relacionado">
                <div class="single-item-rtl relacionados">
                    <div class="productos-comilandia_item">
                    <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>  
            </div>
            <div class="prod-relacionado">
                <div class="single-item-rtl relacionados">
                    <div class="productos-comilandia_item">
                    <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>  
            </div>
            <div class="prod-relacionado">
                <div class="single-item-rtl relacionados">
                    <div class="productos-comilandia_item">
                    <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>  
            </div>
            <div class="prod-relacionado">
                <div class="single-item-rtl relacionados">
                    <div class="productos-comilandia_item">
                    <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>  
            </div>
            <div class="prod-relacionado">
                <div class="single-item-rtl relacionados">
                    <div class="productos-comilandia_item">
                    <a href="#">
                            <div class="img-producto-comilandia"><img class="img-carrusel-productos" src="{{ asset('user/images/menu_3.jpg') }}"  ></div>
                            <div class="img-producto-comilandia-prom"><div class="prom-img-producto-comilandia-prom-desc"></div></div>
                            <div class="box-inf-products-comilandia">
                                <h4>Hamburguesa de carne</h4>
                                <h5>50% OFF</h5>
                            </div>
                            </a> 

                    </div>
                </div>  
            </div>
        </div>-->
    </section>

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
                    deliveryPrice:"{{ $post->user->delivery_tax }}",
                    accounts:[],
                    clientRut:"",
                    selectedAccount:"",
                    loading:false
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

                    axios.post("{{ url('/api/checkout/store/cart') }}", { total: this.total, amountToPay: amountToPay, paymentType: this.purchaseType, post_id: this.postId, productPurchases: this.productsPurchase, action: this.action, delivery:this.delivery},{
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    }).then(res => {

                        if(res.data.success == true){
                            window.location.href="{{ url('/checkout') }}"+"?token="+window.localStorage.getItem('token');
                        }

                    })

                },
                getSellerAccount(){

                    axios.get("{{ url('/bank-account/profile/') }}"+"/"+this.seller.id).then(res => {

                        this.accounts = res.data.accounts

                    })

                },
                notifyTransfer(){

                    if(this.clientRut == ""){

                        swal({

                            text:"Debes ingresar tu RUT para continuar",
                            icon:"error"

                        })

                    }else{
                        
                        let amountToPay = 0
                        if(this.purchaseType == "reservation"){
                            
                            amountToPay = (this.total / 2) +1 
        
                            
                        }else{
                            amountToPay = this.total
                        }

                        this.loading = true

                        axios.post("{{ url('api/transfer/notify') }}", {accountId: this.selectedAccount.id, price: parseInt(amountToPay), paymentType: "reservation", total: this.total, postId: this.postId, bankId: this.selectedAccount.bank_id, amountToPay: parseInt(amountToPay), productsPurchase: this.productsPurchase, action: "make-purchase", rut: this.clientRut},{
                            headers: {
                                Authorization: "Bearer "+window.localStorage.getItem('token')
                            }
                        }).then(res => {

                            this.loading = false

                            if(res.data.success == true){
                                swal({

                                    text:res.data.msg,
                                    icon:"success"

                                }).then(res => {

                                    window.location.href= "{{ url('/') }}"

                                })
                            }else{
                                swal({

                                    text:res.data.msg,
                                    icon:"error"

                                })
                            }

                        })
                    }


                }

            },
            created(){

                this.fetchBanks()
                this.getSellerAccount()

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
                    
                    this.typePrice = 0.005

                }else if(this.type == "2"){

                    this.typePrice = 0.006

                }else if(this.type == "3"){

                    this.typePrice = 0.007

                }

            }

        })
    </script>


@endpush