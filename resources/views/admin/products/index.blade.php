@extends('admin.layouts.base')

@section('title', 'Product Approval')

@section('content')
<div class="mt-12 space-y-6">
  <div class="flex items-center justify-between">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white">📦 Product Management</h2>
    <div class="flex gap-2">
      <a href="{{ route('admin.products.export', ['type' => 'csv']) }}" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">Export CSV</a>
      <a href="{{ route('admin.products.export', ['type' => 'pdf']) }}" class="px-3 py-1 bg-gray-600 text-white text-xs rounded hover:bg-gray-700">Export PDF</a>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow mb-4">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 dark:bg-gray-800 text-left text-gray-600 dark:text-gray-300 uppercase text-xs">
        <tr>
          <th class="px-6 py-3">Image</th>
          <th class="px-6 py-3">Product Name</th>
          <th class="px-6 py-3">Store</th>
          <th class="px-6 py-3">Price</th>
          <th class="px-6 py-3">Stock</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3">Created At</th>
          <th class="px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 dark:text-gray-200">
        @forelse ($products as $product)
          <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
            <td class="px-6 py-4">
              <img src="{{ asset('storage/' . $product->image) }}" alt="" class="h-10 w-10 rounded object-cover">
            </td>
            <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
            <td class="px-6 py-4">{{ $product->store->store_name ?? 'N/A' }}</td>
            <td class="px-6 py-4">${{ $product->price }}</td>
            <td class="px-6 py-4">{{ $product->stock }}</td>
            <td class="px-6 py-4">
              @if($product->status === 'approved')
                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-600 rounded-full">Approved</span>
              @elseif($product->status === 'rejected')
                <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-600 rounded-full">Rejected</span>
              @else
                <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-600 rounded-full">Pending</span>
              @endif
            </td>
            <td class="px-6 py-4">{{ $product->created_at->format('Y-m-d') }}</td>
            <td class="px-6 py-4 space-x-2">
              @if($product->status !== 'approved')
                <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" class="inline">
                  @csrf @method('PUT')
                  <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">Approve</button>
                </form>
              @endif

              @if($product->status !== 'rejected')
                <form action="{{ route('admin.products.reject', $product->id) }}" method="POST" class="inline">
                  @csrf @method('PUT')
                  <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Reject</button>
                </form>
              @endif
              <button type="button" onclick="viewProduct('{{ $product->id }}')" class="px-3 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600">View</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center px-6 py-4 text-gray-500">No products found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $products->links() }}
  </div>
</div>

<!-- Modal template will be here -->
<div id="productModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-lg relative">
    <button onclick="toggleModal(false)" class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 dark:hover:text-white">✖</button>
    <div id="productModalContent">
      <!-- dynamic content -->
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function viewProduct(id) {
  fetch(`/admin/products/${id}`)
    .then(response => response.json())
    .then(data => {
      const product = data;
      const modalContent = `
        <div class="space-y-3">
          <h2 class="text-lg font-bold text-gray-800 dark:text-white">${product.name}</h2>
          <img src="/storage/${product.image}" alt="${product.name}" class="w-full max-h-64 object-cover rounded">
          <p><strong>Store:</strong> ${product.store?.store_name ?? 'N/A'}</p>
          <p><strong>Description:</strong> ${product.description}</p>
          <p><strong>Price:</strong> $${product.price}</p>
          <p><strong>Stock:</strong> ${product.stock}</p>
          <p><strong>Status:</strong> <span class="capitalize">${product.status}</span></p>
          <p><strong>Submitted on:</strong> ${new Date(product.created_at).toLocaleDateString()}</p>
        </div>
      `;
      document.getElementById('productModalContent').innerHTML = modalContent;
      toggleModal(true);
    });
}

function toggleModal(show) {
  document.getElementById('productModal').classList.toggle('hidden', !show);
}
</script>
@endpush

