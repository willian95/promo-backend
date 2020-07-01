@extends("layouts.user")

@section("content")

    <div class="container" id="dev-area" style="padding-top: 150px;">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">nombre: @{{ name }}</label>
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">email: @{{ email }}</label>
                </div>
            </div>
            <div class="col-md-6" v-if="webSite != ''">
                <div class="form-group">
                    <a :href="webSite" target="_blank">Sitio Web</a>
                </div>
            </div>
            <div class="col-md-6" v-if="telephone != ''">
                <div class="form-group">
                    <label for="telephone">Teléfono: @{{ telephone }}</label>
                </div>
            </div>
            <div class="col-md-6" v-if="facebook != ''">
                <div class="form-group">
                    <a :href="facebook" target="_blank">Facebook</a>
                </div>
            </div>
            <div class="col-md-6" v-if="instragram != ''">
                <div class="form-group">
                    <a :href="instagram" target="_blank">Instagram</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">Dirección: @{{ address }}</label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="region">Region: @{{ region }}</label>
            </div>
            <div class="col-md-6">
                <label for="commune">Comuna: @{{ commune }} </label>
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
                    facebook:"{{ $user->facebook }}"
                }
            },
            methods:{

            },
            created(){

            }

        })
    </script>

@endpush