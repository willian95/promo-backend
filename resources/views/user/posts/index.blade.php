@extends("layouts.user")

@section("content")

    <div class="container" id="dev-area" style="padding-top: 150px;">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Publicación</h3>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control" v-model="title">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="title">Tipo</label>
                    <select class="form-control" v-model="type">
                        <option :value="1">Básica</option>
                        <option :value="2">Super</option>
                        <option :value="3">Premium</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="image">Imagen</label>
                    <input type="file" class="form-control" id="image" ref="file" @change="onImageChange" accept="image/*">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="amount">Cantidad</label>
                    <input type="text" class="form-control" id="amount" v-model="amount">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea rows="5" id="description" v-model="description" class="form-control"></textarea>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="price">Precio</label>
                    <input type="text" class="form-control" id="price" v-model="price">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="category">Categoría</label>
                    <select id="category" class="form-control" v-model="category">
                        <option :value="categoryRow.id" v-for="categoryRow in categories">@{{ categoryRow.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="saleDate">Fecha de venta</label>
                    <input type="date" id="saleDate" class="form-control" v-model="saleDate">
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Descuentos</h3>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount1">Descuento % día 1</label>
                    <input type="text" id="discount1" class="form-control" v-model="discount1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount2">Descuento % día 2</label>
                    <input type="text" id="discount2" class="form-control" v-model="discount2">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount3">Descuento % día 3</label>
                    <input type="text" id="discount3" class="form-control" v-model="discount3">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount4">Descuento % día 4</label>
                    <input type="text" id="discount4" class="form-control" v-model="discount4">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount5">Descuento % día 5</label>
                    <input type="text" id="discount5" class="form-control" v-model="discount5">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount6">Descuento % día 6</label>
                    <input type="text" id="discount6" class="form-control" v-model="discount6">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount7">Descuento % día 7</label>
                    <input type="text" id="discount7" class="form-control" v-model="discount7">
                </div>
            </div>
            <div class="col-md-12">
                <p class="text-center">
                    <button class="btn btn-success" @click="store()">crear</button>
                </p>
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
                    amount:"",
                    price:"",
                    categories:[],
                    category:"",
                    saleDate:"",
                    description:"",
                    discount1:"0",
                    discount2:"0",
                    discount3:"0",
                    discount4:"0",
                    discount5:"0",
                    discount6:"0",
                    discount7:"0",
                    imagePreview:"",
                    picture:"",
                    type:"1"
                }
            },
            methods:{
                
                store(){

                    axios.post("{{ url('api/post/store') }}", {
                        title:this.title,
                        type: this.type,
                        amount:this.amount,
                        price:this.price,
                        categoryId:this.category,
                        saleDate:this.saleDate,
                        description:this.description,
                        discount1:this.discount1,
                        discount2:this.discount2,
                        discount3:this.discount3,
                        discount4:this.discount4,
                        discount5:this.discount5,
                        discount6:this.discount6,
                        discount7:this.discount7,
                        main_image: this.picture
                    },{
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }

                    })
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
                fetchCategories(){

                    axios.get("{{ url('/api/categories/fetch') }}").then(res => {
                        
                        if(res.data.success == true){

                            this.categories = res.data.categories

                        }else{

                            alert(res.data.msg)

                        }

                    })

                }

            },
            created(){

                this.fetchCategories()

            }

        })
    </script>

@endpush