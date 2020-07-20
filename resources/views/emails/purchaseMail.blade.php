<p></p>{{ $message }}

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

    
        
    </tbody>
</table>

@if($messageTo == 'buyer')
    <a href="{{ url('/my-purchases/purchase/'.$purchaseId) }}">Ver compra</a>
@elseif($messageTo == 'seller')
    <a href="{{ url('/my-sales') }}">Ver venta</a>
@endif