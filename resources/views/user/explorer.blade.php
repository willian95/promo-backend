@extends("layouts.user")

@section("content")

    <div class="container" style="padding-top: 150px;" id="dev-area">

        <div class="row">
            <div class="col-md-5 mb-4">
                <p> Seleccione una región </p>
                <select class="form-control" v-model="region" @change="onRegionChange()">
                    <option :value="region.id" v-for="region in regions">@{{ region.name }}</option>
                </select>
            </div>
            <div class="col-md-5 mb-4">
                <p> Seleccione una comuna </p>
                <select class="form-control" v-model="commune">
                    <option :value="commune.id" v-for="commune in communes">@{{ commune.name }}</option>
                </select>
            </div>
            <div class="col-md-2">
                
                <button class="btn btn-success" style="margin-top: 48px;" @click="search()">Buscar</button>
            </div>
        </div>

        <div class="row">

                <div class="card-item" v-for="post in posts">
                    <div class="img-product">
                        <img :src="'{{ url('/images/posts/') }}'+'/'+post.post[0].image" alt="">
                    </div>
                    <div class="card-body">
                        <h5>@{{ post.post[0].title }}</h5>
                        <p>@{{ post.post[0].commune.name }}</p>
                        <p class="description-post">@{{ post.post[0].description }}</p>
                        <img :src="'{{ url('/') }}'+'/images/users/'+post.post[0].user.image" alt="" style="width: 50px;"><a :href="'{{ url('/') }}'+'/profile'+'/'+post.post[0].user_id">@{{ post.post[0].user.name }}</a>
                        <p>promedio: @{{ post.overall }} / 5</p>
                        <div class="price">$@{{ post.post[0].products[0].price }}</div>
                        <a :href="'{{ url('/post/show') }}'+'/'+post.post[0].id">
                        <button class="button">Ver más</button></a>
                    </div>
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
                    pages:0
                }
            },
            methods:{
                
                fetch(page = 1){

                    this.page = page

                    axios.post("{{ url('/api/explorer/fetch') }}", {location_id: this.selectedCommune, page: this.page}).then(res => {

                        if(res.data.success == true){

                            this.posts = res.data.posts
                            this.pages = Math.ceil(res.data.postsCount/20)

                        }else{
                            alert(res.data.msg)
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
                            alert(res.data.msg)
                        }
                        

                    })

                },
                search(){

                    if(this.commune == ""){

                        alert("Debe seleccionar una comuna")

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
                            alert(res.data.msg)
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