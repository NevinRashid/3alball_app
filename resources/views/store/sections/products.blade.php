<!-- 🏭 Products Section -->
<div id="products-section" class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 mb-8">
  <div class="flex justify-between items-center mb-4">
    <button onclick="toggleAddProductModal(true)" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
      + Add Product
    </button>
  </div>

  <div class="mb-4 flex items-center justify-between gap-4 flex-wrap">
    <input type="text" id="searchInput" placeholder="Search products..." class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    <select id="categoryFilter" class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none">
      <option value="">All Categories</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="overflow-x-auto">
    <table class="dark-table w-full text-sm text-left text-gray-700 dark:text-gray-200">
      <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-xs uppercase">
        <tr>
          <th class="p-3">Image</th>
          <th class="p-3">Name</th>
          <th class="p-3">Price</th>
          <th class="p-3">Stock</th>
          <th class="p-3">Status</th>
          <th class="p-3">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
        @foreach ($products as $product)
          @php
            $productData = json_encode([
              'id' => $product->id,
              'name' => $product->name,
              'category_id' => $product->category_id,
              'description' => $product->description,
              'price' => $product->price,
              'stock' => $product->stock,
            ], JSON_HEX_APOS | JSON_HEX_QUOT);
          @endphp

          <tr class="hover:bg-gray-50 dark:hover:bg-gray-700"
              data-name="{{ strtolower($product->name) }}"
              data-category-id="{{ $product->category_id }}">
            <td class="p-3">
              <img src="{{ asset('storage/' . $product->image) }}"
                   class="w-12 h-12 rounded border object-cover" alt="Product">
            </td>
            <td class="p-3">{{ $product->name }}</td>
            <td class="p-3 font-semibold text-green-600">${{ number_format($product->price, 2) }}</td>
            <td class="p-3">{{ $product->stock }}</td>
            <td class="p-3">
              <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                {{ $product->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ ucfirst($product->status) }}
              </span>
            </td>
            <td class="p-3 space-x-2">
              <button 
                class="text-blue-600 hover:underline text-sm"
                data-product='{{ $productData }}'
                onclick="toggleEditProductModal(true, JSON.parse(this.getAttribute('data-product')))"
              >
                Edit
              </button>

              <form method="POST" action="{{ route('store-products.destroy', $product->id) }}"
                    class="inline-block"
                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline text-sm">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Add Product -->
<div id="addProductModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-2xl w-full p-6">
    <div class="flex justify-between items-center border-b pb-3 mb-4">
      <h2 class="text-xl font-bold text-gray-800 dark:text-white">➕ Add New Product</h2>
      <button onclick="toggleAddProductModal(false)" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
    </div>

    <form action="{{ route('store-products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div>
        <label class="block font-semibold mb-1">Product Name</label>
        <input type="text" name="name" class="w-full border rounded px-4 py-2" required>
      </div>

      <div>
        <label class="block font-semibold mb-1">Category</label>
        <select name="category_id" class="w-full border rounded px-4 py-2" required>
          <option value="">Select Category</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block font-semibold mb-1">Description</label>
        <textarea name="description" class="w-full border rounded px-4 py-2" rows="3" required></textarea>
      </div>

      <div class="flex gap-4">
        <div class="flex-1">
          <label class="block font-semibold mb-1">Price ($)</label>
          <input type="number" step="0.01" name="price" class="w-full border rounded px-4 py-2" required>
        </div>
        <div class="flex-1">
          <label class="block font-semibold mb-1">Stock</label>
          <input type="number" name="stock" class="w-full border rounded px-4 py-2" required>
        </div>
      </div>

      <div>
        <label class="block font-semibold mb-1">Product Image <span class="text-red-600">*</span></label>
        <input type="file" name="image" class="w-full" required>
      </div>

      

      <div class="flex justify-end gap-4 mt-6">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">Add Product</button>
        <button type="button" onclick="toggleAddProductModal(false)" class="text-gray-600 hover:underline">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Product -->
<div id="editProductModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-2xl w-full p-6">
    <div class="flex justify-between items-center border-b pb-3 mb-4">
      <h2 class="text-xl font-bold text-gray-800 dark:text-white">✏️ Edit Product</h2>
      <button onclick="toggleEditProductModal(false)" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
    </div>

    <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      @method('PUT')

      <input type="hidden" name="id" id="edit_product_id">

      <div>
        <label class="block font-semibold mb-1">Product Name</label>
        <input type="text" name="name" id="edit_product_name" class="w-full border rounded px-4 py-2" required>
      </div>

      <div>
        <label class="block font-semibold mb-1">Category</label>
        <select name="category_id" id="edit_category_id" class="w-full border rounded px-4 py-2" required>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block font-semibold mb-1">Description</label>
        <textarea name="description" id="edit_description" class="w-full border rounded px-4 py-2" rows="3" required></textarea>
      </div>

      <div class="flex gap-4">
        <div class="flex-1">
          <label class="block font-semibold mb-1">Price ($)</label>
          <input type="number" step="0.01" name="price" id="edit_price" class="w-full border rounded px-4 py-2" required>
        </div>
        <div class="flex-1">
          <label class="block font-semibold mb-1">Stock</label>
          <input type="number" name="stock" id="edit_stock" class="w-full border rounded px-4 py-2" required>
        </div>
      </div>

      <div>
        <label class="block font-semibold mb-1">Change Main Image</label>
        <input type="file" name="image" class="w-full">
      </div>

      <div>
        <label class="block font-semibold mb-1">Add Gallery Images</label>
        <input type="file" name="gallery[]" class="w-full" multiple>
      </div>

      <div class="flex justify-end gap-4 mt-6">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">Update Product</button>
        <button type="button" onclick="toggleEditProductModal(false)" class="text-gray-600 hover:underline">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleAddProductModal(show) {
    const modal = document.getElementById('addProductModal');
    show ? modal.classList.remove('hidden') : modal.classList.add('hidden');
  }

  function toggleEditProductModal(show, product = null) {
    const modal = document.getElementById('editProductModal');
    if (show && product) {
      document.getElementById('edit_product_id').value = product.id;
      document.getElementById('edit_product_name').value = product.name;
      document.getElementById('edit_category_id').value = product.category_id;
      document.getElementById('edit_description').value = product.description;
      document.getElementById('edit_price').value = product.price;
      document.getElementById('edit_stock').value = product.stock;
      const form = document.getElementById('editProductForm');
      form.action = `/store-products/${product.id}`;
    }
    show ? modal.classList.remove('hidden') : modal.classList.add('hidden');
  }

  const searchInput = document.getElementById('searchInput');
  const categoryFilter = document.getElementById('categoryFilter');
  const productRows = document.querySelectorAll('tbody tr');

  function filterProducts() {
    const search = searchInput.value.toLowerCase();
    const selectedCategory = categoryFilter.value;

    productRows.forEach(row => {
      const name = row.getAttribute('data-name');
      const categoryId = row.getAttribute('data-category-id');
      const matchesSearch = !search || name.includes(search);
      const matchesCategory = !selectedCategory || categoryId === selectedCategory;
      row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
    });
  }

  searchInput.addEventListener('input', filterProducts);
  categoryFilter.addEventListener('change', filterProducts);
</script>
