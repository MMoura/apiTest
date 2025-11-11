<!doctype html>
<html>
<body>
    <p>Hi {{ $order->client->name }},</p>

    <p>Your order #{{ $order->id }} was received on {{ $order->created_at }}.</p>

    <ul>
        @foreach($order->products as $product)
            <li>{{ $product->name }} x {{ $product->pivot->quantity }} — {{ number_format($product->pivot->unit_price, 2) }}</li>
        @endforeach
    </ul>

    <p>Thank you for ordering at Pastelaria!</p>
</body>
</html>
