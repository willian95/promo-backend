@extends("layouts.admin")

@section("content")

    <h3 class="text-center" style="margin-top: 40px;">Admin</h3>

    <div class="container-fluid" id="admin-area">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h5 class="text-center">Ventas en los últimos 30 días</h5>
                <canvas id="myChart"></canvas>
            </div>
            <div class="col-lg-6 col-md-6">
                <h5 class="text-center">Ultimas publicaciones</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Vendedor</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Fecha Publicación</th>
                            <th scope="col">Fecha Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(latestPost, index) in latestPosts">
                            <th>@{{ index + 1 }}</th>
                            <td>@{{ latestPost.user.name }}</td>
                            <td>@{{ latestPost.title }}</td>
                            <td>@{{ latestPost.category.name }}</td>
                            <td>@{{ latestPost.start_date.toString().substring(0, 10) }}</td>
                            <td>@{{ latestPost.sale_date.toString().substring(0, 10) }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>


@endsection

@push("scripts")

    <script>
                    
        const app = new Vue({
            el: '#admin-area',
            data(){
                return{
                    latestPosts:[]
                }
            },
            methods:{

                
                fetchLatestPosts(){

                    axios.get("{{ url('/api/admin/latest/posts/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.latestPosts = res.data.posts
                        }else{
                            alertify.error(res.data.msg)
                        }
                        //this.pages = Math.ceil(res.data.categoriesCount / 20)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/api/admin/bank/delete/') }}", {id: id}).then(res => {

                            if(res.data.success == true){
                                swal({
                                    title: "Perfecto!",
                                    text: res.data.msg,
                                    icon: "success"
                                })
                                this.fetch()
                            }else{

                                swal({
                                    text: res.data.msg,
                                    icon: "error"
                                })

                            }

                        })
                        .catch(err => {
                            $.each(err.response.data.errors, function(key, value){
                                alertify.error(value[0])
                            });
                        })

                    }

                }
                

            },
            mounted(){
                this.fetchLatestPosts()
            }

        })

    </script>


    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['01-07-2020', '05-07-2020', '09-07-2020'],
                datasets: [{
                    label: '# of Votes',
                    data: [3, 5, 1],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

@endpush