@extends("layouts.user")

@section("content")
<div class="area-explorar-comilandia" id="dev-area">

    <div class="elipse" v-if="loading == true">
        <img src="{{ asset('user/images/logo.png') }}">
    </div>
    <div class="area-explorar-comilandia-img-banner">
        <img class="area-explorar-comilandia-img-banner_img" src="{{ asset('user/images/explorer.jpg') }}" alt="">
    </div>
    <div class="cont-explorer-comilandia">
        <div class="container pt-150">

            <div class="row">
                <div class="col-md-6 cont-inf-estat-explorer">
                    <h3 class="pide-ahora-explorer">
                        <span style="font-size: 50px;color: #e3001b; font-weight: bold;">¡PIDE</span><br>
                        AHORA!
                    </h3>
                    <p class="pide-ahora-explorer_p">¡Vamos a todas partes!</p>
                    <p class="pide-ahora-explorer_p">Dínos a dónde quieres que lleguemos</p>
                </div>
                <div class="col-md-6 cont-op-explorer">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <!-- <p> <strong>Seleccione una región</strong> </p> -->
                            <select aria-placeholder="vbn" class="form-control form-explorer-comilandia" v-model="region" @change="onRegionChange()">
                                <option  value="">Seleccione una región</option>
                                <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <!-- <p><strong> Seleccione una comuna</strong> </p> -->
                            <select class="form-control form-explorer-comilandia" v-model="commune">
                                <option value="">Seleccione una comuna</option>
                                <option :value="commune.id" v-for="commune in communes">@{{ commune.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 " style="display: flex; justify-content: center;">
                        <button class="button" style="margin-top: 44px; background: #e3001b;" @click="search()">Buscar</button>
                    </div>
                    </div>
                </div>
            </div>
            <!--<div class="row">

                <div class="col-md-4 col-lg-3">

                    <div class="card" v-for="post in posts" style="padding-bottom: 20px;">
                        <div class="img-product">
                            <img :src="'{{ url('/images/posts/') }}'+'/'+post.post[0].image" alt="">
                        </div>
                        <div class="card-body">

                            <div class="card-image-section">
                                <p class="text-center">
                                    <img :src="'{{ url('/') }}'+'/images/users/'+post.post[0].user.image" alt="">
                                </p>
                                <p class="text-center">
                                    <a class="text-center" :href="'{{ url('/') }}'+'/profile'+'/'+post.post[0].user_id">@{{ post.post[0].user.name }}</a>
                                </p>
                            </div>

                            <h5>@{{ post.post[0].title }}</h5>
                            <p>@{{ post.post[0].commune.name }}</p>
                            <p class="description-post">@{{ post.post[0].description }}</p>
                            <p>promedio: @{{ post.overall }} / 5</p>
                            <p>Descuento: <span class="price">- @{{ post.discountPercentage }}%</span></p>
                            <p class="text-center button-show-more">
                                <a :href="'{{ url('/post/show') }}'+'/'+post.post[0].id">
                                <button class="button">Ver más</button></a>
                            </p>
                        </div>
                    </div>

                </div>
            
            </div>

            <div class="row" style="margin-top: 40px;">
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link text-dark" href="#" v-for="index in pages" :key="index" @click="fetch(index)" >@{{ index }}</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>-->

        </div>

    </div>

    <section class="resultado-explorer">
        <div class="container cont-productos product-home">
            <h3 class="resultado-busqueda">Resultados de la busqueda</h3>
            <br>
            <p class="resultado-busqueda-pide-ahora">¡PIDE AHORA!</p>

            <div class="prod-relacionado" v-for="post in posts">
                <div class="single-item-rtl relacionados">
                    <div class="productos-comilandia_item">
                        <a :href="'{{ url('/post/show') }}'+'/'+post.post[0].id">
                            <div class="img-producto-comilandia">
                                <img class="img-carrusel-productos" :src="'{{ url('/images/posts/') }}'+'/'+post.post[0].image" alt=""  >
                            </div>
                            <div class="img-producto-comilandia-prom">
                                <div class="prom-img-producto-comilandia-prom-desc">@{{ post.post[0].discountPercentage }}%</div>
                            </div>
                            <div class="cont-inf-u-comilandia">
                                <div class="cont-inf-u-comilandia-img">
                                    <img class="cont-inf-u-comilandia-img_img" :src="'{{ url('/') }}'+'/images/users/'+post.post[0].user.image" alt="" alt="">
                                </div>
                                <div class="cont-inf-u-comilandia-nombre">
                                    <p class="cont-inf-u-comilandia-nombre_p"><a class="text-center" :href="'{{ url('/') }}'+'/profile'+'/'+post.post[0].user_id">@{{ post.post[0].user.name }}</a></p>
                                </div>
                            </div>
                            <div class="box-inf-products-comilandia">
                                <h4>@{{ post.post[0].title }}</h4>
                                <p>@{{ post.post[0].commune.name }}</p>    
                                
                            </div>
                            
                        </a> 

                    </div>
                </div>

            </div>

        </div>
    </section>

</div>
@endsection

@push("scripts")

<script>
        const app = new Vue({
            el: '#dev-area',
            data(){
                return{
                    regions:[],
                    communes:[],
                    region:"",
                    commune:"",
                    selectedCommune:"",
                    posts:[],
                    page:1,
                    pages:0,
                    loading:false
                }
            },
            methods:{
                
                fetch(page = 1){

                    this.page = page
                    this.loading = true

                    axios.post("{{ url('/api/explorer/fetch') }}", {location_id: this.selectedCommune, page: this.page}).then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            this.posts = res.data.posts
                            console.log("posts", this.posts)
                            this.pages = Math.ceil(res.data.postsCount/20)

                        }else{
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })
                        }

                    })

                },
                search(){

                },
                onRegionChange(){

                    this.communesFetch()

                },
                regionsFetch(){

                    axios.get("{{ url('/api/regions') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.regions = res.data.regions
                        }else{
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })
                        }
                        

                    })

                },
                search(){

                    if(this.commune == ""){

                        alertify.error("Debe seleccionar una comuna")

                    }else{

                        this.page = 1
                        this.selectedCommune = this.commune

                        this.fetch()

                    }

                },
                communesFetch(){

                    axios.get("{{ url('/api/commune') }}"+"/"+this.region)
                    .then(res => {

                        if(res.data.success == true){
                            this.communes = res.data.communes
                        }else{
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })
                        }
                        

                    })

                },
                myData(){
                    axios.get("{{ url('api/my-profile/data') }}", {
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    }).then(res =>{
                        this.regionsFetch()
                        this.region = res.data.commune.region_id
                        this.commune = res.data.user.location_id
                        this.selectedCommune = this.commune
                        this.communesFetch()
                        this.fetch()
                    })
                }

            },
            created(){

                this.regionsFetch()
                this.myData()

            }

        })
    </script>


@endpush