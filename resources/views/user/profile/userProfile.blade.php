@extends("layouts.user")

@section("content")

    <div class="container pt-150" id="dev-area">

        <div class="row">

            <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3">
            
                <div class="form-group">
                    <p class="text-center">
                        <img id="blah" :src="'{{ url('/') }}'+'/images/users/'+image" class="full-image" style="margin-top: 10px; width: 140px; height: 140px; object-fit:cover; border-radius: 50%; ">
                    </p>
                    
                </div>
            
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <h5 for="name"><strong>nombre:</strong> @{{ name }}</h5>
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h5 for="email"><strong>email:</strong> @{{ email }}</h5>
                </div>
            </div>
            <div class="col-md-6" v-if="webSite != ''">
                <div class="form-group">
                    <a :href="webSite" target="_blank">Sitio Web</a>
                </div>
            </div>
            <div class="col-md-6" v-if="telephone != ''">
                <div class="form-group">
                    <h5 for="telephone"><strong>Teléfono:</strong> @{{ telephone }}</h5>
                </div>
            </div>
            <div class="col-md-6" v-if="facebook != ''">
                <div class="form-group">
                    <a :href="facebook" target="_blank">Facebook</a>
                </div>
            </div>
            <div class="col-md-6" v-if="instagram != ''">
                <div class="form-group">
                    <a :href="instagram" target="_blank">Instagram</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h5 for="address"><strong>Dirección:</strong> @{{ address }}</h5>
                </div>
            </div>
            <div class="col-md-6">
                <h5 for="region"><strong>Region:</strong> @{{ region }}</h5>
            </div>
            <div class="col-md-6">
                <h5 for="commune"><strong>Comuna:</strong> @{{ commune }} </h5>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Comentarios</h3>
            </div>
            <div class="col-12" v-for="rating in ratings">
                <h5>@{{ rating.qualifier.name }} @{{ rating.rating.rate }}/5</h5>
                <p>@{{ rating.rating.comment }}</p>
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
                    name:"{{ $user->name }}",
                    email:"{{ $user->email }}",
                    address:"{{ $user->address }}",
                    region:"{{ $region }}",
                    commune:"{{ $commune }}",
                    webSite:"{{ $user->web_site }}",
                    telephone:"{{ $user->telephone }}",
                    instagram:"{{ $user->instagram }}",
                    facebook:"{{ $user->facebook }}",
                    image:"{{ $user->image }}",
                    ratings:""
                }
            },
            methods:{

                fetch(){

                    axios.get("{{ url('api/rate/fetch') }}"+"/"+"{{ $user->id }}")
                    .then(res => {

                        this.ratings = res.data.ratings

                    })

                }

            },
            created(){

                this.fetch()

            }

        })
    </script>

@endpush