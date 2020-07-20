{{ $messageMail }}

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Precio Total</th>
        </tr>
    </thead>
    <tbody>

        @foreach($purchaseProducts as $purchase)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $purchase->postProduct->title }}</td>
                <td>{{ $purchase->amount }}</td>
                <td>$ {{ $purchase->price }}</td>
                <td>$ {{ $purchase->price * $purchase->amount }}</td>
            </tr>
        @endforeach
        
    </tbody>
</table>

@if($messageTo == 'buyer')
    <p>Confirma tu entrega en el siguiente enlace</p>
    <a href="{{ url('/my-purchases') }}">Ver compra</a>
@endif