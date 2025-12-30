<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6">Add New Product</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/store-products" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Product Name</label>
                <input type="text" name="name" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Description</label>
                <textarea name="description" class="w-full border rounded px-4 py-2" rows="4" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Price ($)</label>
                <input type="number" step="0.01" name="price" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Stock</label>
                <input type="number" name="stock" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Image</label>
                <input type="file" name="image" class="w-full">
            </div>

            <div class="mb-6">
                <label class="block mb-1 font-semibold">Status</label>
                <select name="status" class="w-full border rounded px-4 py-2">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Add Product</button>
            <a href="/store-dashboard" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </form>
    </div>
</body>
</html>
