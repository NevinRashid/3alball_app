<!-- resources/views/store/orders/export_pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order #{{ $order->id }} - Export</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background-color: #f5f5f5; }
  </style>
</head>
<body>

  <h2>Order #{{ $order->id }}</h2>

  <p><strong>Recipient:</strong> {{ $order->recipient_name }}</p>
  <p><strong>Phone:</strong> {{ $order->recipient_phone }}</p>
  <p><strong>Address:</strong> {{ $order->recipient_address }}</p>
  <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
  <p><strong>Delivery:</strong> {{ $order->delivery_date }} @ {{ $order->delivery_time }}</p>
  <p><strong>Gift Message:</strong> {{ $order->gift_message ?? '-' }}</p>

  <table>
    <thead>
      <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price ($)</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($order->products as $product)
        <tr>
          <td>{{ $product->name }}</td>
          <td>{{ $product->pivot->quantity }}</td>
          <td>${{ number_format($product->price, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <p style="margin-top: 20px;"><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</p>

</body>
</html>
