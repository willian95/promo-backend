@extends("layouts.user")

@section("content")
<div class="area-explorar-comilandia" id="dev-area">

    <div class="loader-cover" v-if="loading == true">
        <div class="loader"></div>
    </div>

    <section class="resultado-explorer">
        <div class="container cont-productos product-home">
            

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
                    query:"la higuera",
                    posts:[],
                    page:1,
                    pages:0,
                    loading:false
                }
            },
            methods:{
                
                search(page = 1){

                    this.page = page
                    this.loading = true

                    axios.post("{{ url('/api/search/query') }}", {search: this.query}).then(res => {
                        this.loading = false
                        console.log("res", res)
                        if(res.data.success == true){

                            //this.posts = res.data.posts
                            //console.log("posts", this.posts)
                            //this.pages = Math.ceil(res.data.postsCount/20)

                        }else{
                            swal({
                                text: res.data.msg,
                                icon: "error"
                            })
                        }

                    })

                }
                

            },
            created(){

                this.search()

            }

        })
    </script>


@endpush