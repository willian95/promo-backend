@extends("layouts.user")

@section("content")


    <div class="container" id="dev-area" style="margin-top: 150px;">
        <div class="row">
            <div class="col-12">
                <p class="text-center">
                    <img src="{{ asset('/user/images/logo.png') }}" alt="" style="width: 220px;">
                </p>

                <h3 class="text-center">Pago exitoso</h3>
                

                <table class="table" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th class="text-secondary">#</th>
                            <th class="text-secondary">Articulo</th>
                            <th class="text-secondary">Cantidad</th>
                            <th class="text-secondary">Precio</th>
                            <th class="text-secondary">Precio total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseProducts as $purchase)
                    
                            <tr>
                                <td class="text-center text-secondary">{{ $loop->index + 1 }}</td>
                                <td class="text-center text-secondary">{{ $purchase->postProduct->title }}</td>
                                <td class="text-center text-secondary">{{ $purchase->amount }}</td>
                                <td class="text-center text-secondary">$ {{ number_format($purchase->price, 0, ",", ".") }}</td>
                                <td class="text-center text-secondary">$ {{ number_format($purchase->price * $purchase->amount, 0, ",", ".") }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p class="text-center" style="margin-top: 20px;">
                    <a href="{{ url('/') }}" class="button">Ir al inicio</a>
                </p>

            </div>
        </div>
    </div>

@endsection