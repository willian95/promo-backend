@extends("layouts.user")

@section("content")

    <div class="container pt-150" id="dev-area">
        <div class="row"> 
            <div class="col-12">
                <h3 class="text-center">Mis ventas</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-secondary">Publicación</th>
                            <th class="text-secondary">Usuario</th>
                            <th class="text-secondary">Status</th>
                            <th class="text-secondary">Delivery</th>
                            <th class="text-secondary">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sale in sales" v-if="sale.post">
                            <td class="text-secondary">@{{ sale.post.title }}</td>
                            <td class="text-secondary">@{{ sale.user.name }}</td>
                            <td class="text-secondary" v-if="sale.is_payment_complete == 0">En espera de finalización del pago</td>
                            <td class="text-secondary" v-if="sale.is_payment_complete == 1 && sale.shipping_state == 'en proceso'">Pago realizado, puede proceder a la entrega</td>
                            <td class="text-secondary" v-if="sale.is_payment_complete == 1 && sale.shipping_state == 'entregado'">Articulo entregado</td>
                            <td class="text-secondary" v-if="sale.is_payment_complete == 1 && sale.shipping_state == 'recibido'">Articulo recibido</td>
                            <td class="text-secondary" v-if="sale.has_delivery == 1">Sí</td>
                            <td class="text-secondary" v-else>No</td>
                            <td>
                                <button class="button" v-if="sale.is_payment_complete == 1 && sale.shipping_state == 'en proceso'" data-toggle="modal" data-target="#saleModal" @click="showModal(sale)">Entregar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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

        <div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="sale != ''">
                        
                        <img :src="'{{ url('/') }}'+'/images/posts/'+sale.post.image" alt="" style="width: 100%">
                        <h3>@{{ sale.post.title }}</h3>
                        <p>Usuario: @{{ sale.user.name }}</p>
                        <p>Dirección: @{{ sale.user.address }}, @{{ sale.user.commune.name }}</p>
                        <P>
                            <a :href="'https://www.google.com/maps/place/'+sale.user.address+','+sale.user.commune.name+', Chile'" target="_blank">Ver mapa</a>
                        </P>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="productPurchase in sale.products_purchase">
                                    <td>@{{ productPurchase.post_product.title }}</td>
                                    <td>@{{ productPurchase.amount }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <button class="button" @click="deliver()" data-dismiss="modal">Entregar</button>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
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
                    sales:[],
                    sale:"",
                    pages:0,
                    page:1
                }
            },
            methods:{
                
                fetch(page = 1){

                    this.page = page

                    axios.get("{{ url('api/my-sales/fetch/') }}"+"/"+this.page,{
                        headers: {
                            Authorization: "Bearer "+window.localStorage.getItem('token')
                        }
                    }).then(res => {

                        if(res.data.success == true){
                            this.sales = res.data.sales
                            this.pages = Math.ceil(res.data.salesCount / 20)
                        }

                    })

                },
                showModal(sale){

                    this.sale = sale

                },
                deliver(){

                    axios.post("{{ url('api/my-sales/deliver') }}",{id: this.sale.id}).then(res => {

                        if(res.data.success == true){
                            swal({
                                title: "Perfecto!",
                                text: res.data.msg,
                                icon: "success"
                            })
                            this.fetch(this.page)
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
                this.fetch()
            }
        })
    </script>

@endpush