<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Products</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-6xl mx-auto bg-white p-8 shadow rounded-lg">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">My Products</h1>
      <a href="{{ route('store-products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Product</a>
    </div>

    @if (session('success'))
      <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
        {{ session('success') }}
      </div>
    @endif

    <table class="min-w-full table-auto border rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-3 text-left">Image</th>
          <th class="p-3 text-left">Name</th>
          <th class="p-3 text-left">Price</th>
          <th class="p-3 text-left">Status</th>
          <th class="p-3 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($products as $product)
          <tr class="border-t">
            <td class="p-3">
              <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/images/placeholder.png') }}" class="h-12 w-12 object-cover rounded">
            </td>
            <td class="p-3 font-medium">{{ $product->name }}</td>
            <td class="p-3 text-green-600 font-bold">${{ number_format($product->price, 2) }}</td>
            <td class="p-3 capitalize">{{ $product->status }}</td>
            <td class="p-3 space-x-2">
              <a href="{{ route('store-products.edit', $product->id) }}" class="text-blue-600 hover:underline">Edit</a>
              <form method="POST" action="{{ route('store-products.destroy', $product->id) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this product?')">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-gray-500 p-4">No products yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{-- Pagination (if using paginate in controller) --}}
    <div class="mt-6">
      {{ $products->links() }}
    </div>
  </div>
</body>
</html>
