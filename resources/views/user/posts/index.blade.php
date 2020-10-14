@extends("layouts.user")

@section("content")
<div class="cont-publicacion">
    <div class="cont-publicacion-img"></div>
    <div class="container pt-150 " id="dev-area">

        <div class="elipse" v-if="loading == true">
            <img src="{{ asset('user/images/logo.png') }}">
        </div>

        <div class="row cont-publicacion-form-info">
            <div class="col-12 content_text_info">
                <h3 class="text-center cont-publicacion_h3">Publicación</h3>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="title">Titulo</label>
                    <input type="text" class="form-control input-publicacion" v-model="title" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="title">Tipo</label>
                    <select class="form-control" v-model="type" @change="onTypeChange()">
                        <option value="">Seleccione Tipo</option>
                        <option :value="1">Básica</option>
                        <option :value="2">Super</option>
                        <option :value="3">Premium</option>
                    </select>
                </div>
                <small v-if="type == 1">Puedes publicar 3 promociones</small>
                <p><small v-if="type == 1">Se añadirá un 0,05% de comisión</small></p>

                <small v-if="type == 2">Puedes publicar 5 promociones</small>
                <p><small v-if="type == 2">Se añadirá un 0,06% de comisión</small></p>

                <small v-if="type == 3">Puedes publicar 8 promociones</small>
                <p><small v-if="type == 3">Se añadirá un 0,08% de comisión</small></p>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="description">Breve descripción</label>
                    <textarea rows="2" id="description" v-model="description" class="form-control input-publicacion" ></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="category">Categoría</label>
                    <select id="category" class="form-control" v-model="category">
                        <option :value="categoryRow.id" v-for="categoryRow in categories">@{{ categoryRow.name }}</option>
                    </select>
                </div>
            </div>
            
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="saleDate">Fecha de venta</label>
                    <!--<input type="date" id="saleDate" class="form-control input-publicacion" v-model="saleDate">-->
                    <select class="form-control" id="saleDate" v-model="saleDate">
                        <option :value="monday" v-for="monday in mondays">@{{ monday }}</option>
                    </select>
                    <small>Debe existir un mínimo de 7 días para la fecha de venta</small>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="">¿Cuenta con delivery?</label>
                    <p class="text-dark" v-if="hasDelivery == 1"><strong>Sí</strong></p>
                    <p class="text-dark" v-else><strong>No</strong></p>
                </div><!---->
                <small>Para cambiar ésta opción debes hacerlo desde el perfil</small>
            </div>
            <div class="col-md-3" v-if="hasDelivery == 1">
                <div class="form-group">
                    <label for="">Precio de delivery</label>
                    <p>@{{ deliveryPrice }}</p>
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="image">Imagen</label>
                    <input type="file" class="form-control input-img-publicacion" id="image" ref="file" @change="onImageChange" accept="image/*" style="font-size: 14px;">

                    <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
                    
                </div>
            </div>
            
            
            <!--<div class="col-md-4">
                <div class="form-group">
                    <label for="maxDiscount">Descuento Máximo %</label>
                    <input type="text" id="maxDiscount" class="form-control" v-model="maxDiscount" @keypress="isNumber($event)">
                    <small>Valor mínimo es 20%. Este valor irá disminuyendo a medida que la promoción avance hasta llegar a un mínimo del 5% de descuento el día de la venta</small>
                </div>
            </div>-->
            
        </div>

        <div class="row">
            <div class="col-12 content_text_info">
                <h3 class="text-center cont-publicacion_h3">Promociones</h3>
                <p class="text-center">
                    <button class="btn btn-success" data-toggle="modal" data-target="#promotion" v-if="promos.length < amount ">+</button>
                </p>
            </div>
            <div class="col-12 content_text_info_table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titulo</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(promo, index) in promos">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ promo.title }}</td>
                            <td>$ @{{ parseInt(promo.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                            <td>@{{ promo.amount }}</td>
                            <td>
                                <button class="btn btn-danger" @click="deletePromo(index)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--<div class="row">
            <div class="col-12">
                <p class="text-center"><button class="btn btn-success" @click="store()">Publicar</button></p>
            </div>
        </div>-->

        <div class="modal fade" id="promotion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Promoción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="titleProduct">Titulo</label>
                            <input type="text" class="form-control input-promo " id="titleProduct" v-model="titleProduct">
                        </div>
                        <div class="form-group">
                            <label for="descriptionProduct">Descripción</label>
                            <textarea class="form-control input-promo-texta " rows="5" v-model="descriptionProduct" id="descriptionProduct"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="priceProduct">Precio</label>
                            <input type="text" class="form-control input-promo " id="priceProduct" v-model="priceProduct" @keypress="isNumber($event)">
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="amountProduct">Cantidad</label>
                                    <input type="text" class="form-control input-promo " id="amountProduct" v-model="amountProduct" @keypress="isNumber($event)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="priceProduct">Imagen</label>
                            <input type="file" class="form-control input-img-publicacion" id="image2" ref="file" @change="onImageChange2" accept="image/*">

                            <img id="blah2" :src="imagePreview2" class="full-image" style="margin-top: 10px; width: 40%">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="addPromo()">Crear</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h3 class="text-center text-desc">Descuentos</h3>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="discount1">Descuento % día 1</label>
                    <input type="text" id="discount1" class="form-control input-publicacion"  v-model="discount1" @blur="checkDiscounts()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="discount2">Descuento % día 2</label>
                    <input type="text" id="discount2" class="form-control input-publicacion"  v-model="discount2" @blur="checkDiscounts()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="discount3">Descuento % día 3</label>
                    <input type="text" id="discount3" class="form-control input-publicacion"  v-model="discount3" @blur="checkDiscounts()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="discount4">Descuento % día 4</label>
                    <input type="text" id="discount4" class="form-control input-publicacion"  v-model="discount4" @blur="checkDiscounts()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="discount5">Descuento % día 5</label>
                    <input type="text" id="discount5" class="form-control input-publicacion"  v-model="discount5" @blur="checkDiscounts()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="discount6">Descuento % día 6</label>
                    <input type="text" id="discount6" class="form-control input-publicacion"  v-model="discount6" @blur="checkDiscounts()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="cont-publicacion_label" for="discount7">Descuento % día 7</label>
                    <input type="text" id="discount7" class="form-control input-publicacion" v-model="discount7" @blur="checkDiscounts()">
                </div>
            </div>
            <div class="col-md-12">
                <p class="text-center">
                    <button class="res button" @click="store()">Publicar</button>
                </p>
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
                    title:"",
                    loading:false,
                    categories:[],
                    promos:[],
                    category:"",
                    mondays:[],
                    saleDate:"",
                    description:"",
                    imagePreview:"",
                    picture:"",
                    imagePreview2:"",
                    picture2:"",
                    type:"0",
                    titleProduct:"",
                    descriptionProduct:"",
                    priceProduct:"",
                    amountProduct:"",
                    maxDiscount:"",
                    amount:0,
                    hasDelivery:"",
                    deliveryPrice:"",
                    discount1:5,
                    discount2:5,
                    discount3:5,
                    discount4:5,
                    discount5:5,
                    discount6:5,
                    discount7:5
                }
            },
            methods:{
                
                checkDiscounts(){

                    if(this.discount1 < 5){
                        alertify.error("porcentaje de descuento no puede ser menor a 5%")
                        this.discount1 = 5
                    }
                    else if(this.discount2 < 5){
                        alertify.error("porcentaje de descuento no puede ser menor a 5%")
                        this.discount2 = 5
                    }
                    else if(this.discount3 < 5){
                        alertify.error("porcentaje de descuento no puede ser menor a 5%")
                        this.discount3 = 5
                    }
                    else if(this.discount4 < 5){
                        alertify.error("porcentaje de descuento no puede ser menor a 5%")
                        this.discount4 = 5
                    }
                    else if(this.discount5 < 5){
                        alertify.error("porcentaje de descuento no puede ser menor a 5%")
                        this.discount5 = 5
                    }
                    else if(this.discount6 < 5){
                        alertify.error("porcentaje de descuento no puede ser menor a 5%")
                        this.discount6 = 5
                    }
                    else if(this.discount7 < 5){
                        alertify.error("porcentaje de descuento no puede ser menor a 5%")
                        this.discount7 = 5
                    }

                },
                myData(){

                    axios.get("{{ url('api/my-profile/data') }}", {
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    }).then(res =>{
                        
                        this.hasDelivery = res.data.user.has_delivery
                        this.deliveryPrice = res.data.user.delivery_tax

                    })

                },
                store(){
                    this.loading = true
                    axios.post("{{ url('api/post/store') }}", {
                        title:this.title,
                        type: this.type,
                        categoryId:this.category,
                        saleDate:this.saleDate,
                        description:this.description,
                        main_image: this.picture,
                        discount1: this.discount1,
                        discount2: this.discount2,
                        discount3: this.discount3,
                        discount4: this.discount4,
                        discount5: this.discount5,
                        discount6: this.discount6,
                        discount7: this.discount7,
                        ///maxDiscount: this.maxDiscount,
                        promos: this.promos
                    },{
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }

                    })
                    .then(res => {
                        this.loading = false
                        //console.log("test-res", res)
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
                        this.loading = false
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value[0])
                        });
                    })

                },
                onImageChange(e){
                    this.picture = e.target.files[0];

                    this.imagePreview = URL.createObjectURL(this.picture);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.view_image = false
                    this.createImage(files[0]);
                },
                createImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.picture = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                onImageChange2(e){
                    this.picture2 = e.target.files[0];

                    this.imagePreview2 = URL.createObjectURL(this.picture2);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.view_image2 = false
                    this.createImage2(files[0]);
                },
                createImage2(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.picture2 = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                fetchCategories(){

                    axios.get("{{ url('/api/categories/fetch') }}").then(res => {
                        
                        if(res.data.success == true){

                            this.categories = res.data.categories

                        }else{

                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })

                        }

                    })

                },
                addPromo(){

                    let error = false

                    if(this.titleProduct == ""){
                        alertify.error("Debes agregar un titulo a tu promoción")
                        error = true
                    }

                    if(this.descriptionProduct == ""){
                        alertify.error("Debes agregar una descripción a tu promoción")
                        error = true
                    }

                    if(this.priceProduct == ""){
                        alertify.error("Debes agregar un precio a tu promoción")
                        error = true
                    }

                    if(this.amountProduct == ""){
                        alertify.error("Debes agregar una cantidad a tu promoción")
                        error = true
                    }

                    if(this.amountProduct < 5){
                        alertify.error("La cantidad mínima para publicar es de 5 unidades")
                        error = true
                    }

                    if(this.picture2 ==" "){
                        alertify.error("Promoción debe tener una imagen")
                        error = true
                    }

                    if(error == false){

                        this.promos.push({title: this.titleProduct, description: this.descriptionProduct, price: this.priceProduct, amount: this.amountProduct, picture: this.picture2})

                        this.titleProduct=""
                        this.descriptionProduct=""
                        this.priceProduct=""
                        this.amountProduct=""
                        this.imagePreview2=""
                        $("#image2").val(null)

                        alertify.success("Promoción agregada")


                    }

                },
                isNumber: function(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                deletePromo(indexPromo){

                    this.promos.forEach((data, index) => {

                        if(index == indexPromo){
                            this.promos.splice(index, 1)
                        }

                    })
                },
                onTypeChange(){

                    if(this.type == "1"){
                        this.promos = []
                        this.amount = 3
                    }else if(this.type == "2"){
                        this.promos = []
                        this.amount = 5
                    }if(this.type == "3"){
                        this.promos = []
                        this.amount = 8
                    }

                },
                getAllMondays(){
                    var d = new Date(),
                    e = new Date(),
                    year = d.getYear()

                    d.setDate(d.getDate() + 8);

                    while (d.getYear() === year + 1) {
                        var pushDate = new Date(d.getTime());

                        if(pushDate.getDay() == 1 && d.getTime() != e.getTime()){
                            
                            let month = '' + (d.getMonth() + 1)
                            let day = '' + d.getDate()
                            let year = d.getFullYear();

                            if (month.length < 2) 
                                month = '0' + month;
                            if (day.length < 2) 
                                day = '0' + day;

                            this.mondays.push([year, month, day].join('-'))
                        }
                        d.setDate(d.getDate() + 1);
                    }
                    
                }

            },
            created(){

                this.fetchCategories()
                this.myData()
                this.getAllMondays()

            }

        })
    </script>

@endpush