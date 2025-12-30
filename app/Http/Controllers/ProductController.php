<?

// ProductController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products for the store owner
    public function index()
    {
        // Fetch products by tenant_id (store owner)
        $products = Product::where('tenant_id', auth()->user()->tenant_id)->paginate(10);
        
        return view('store.product.index', compact('products'));
    }

    // Add a new product
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',  // Handle image upload
            'category_id' => 'required|exists:categories,id',
        ]);

        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create the product and store it in the database
        $product = Product::create([
            'tenant_id' => auth()->user()->tenant_id, // Get tenant_id from logged-in user
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => 'pending',  // Default status
            'category_id' => $request->category_id, // Link to the category
            'image_url' => $imagePath,  // Store image URL path if image uploaded
        ]);

        return redirect()->route('store-products.index')->with('success', 'Product added successfully!');
    }
    
    // Edit an existing product
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Fetch the product by tenant_id to ensure only store owners can update their own products
        $product = Product::where('tenant_id', auth()->user()->tenant_id)->findOrFail($id);
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image_url = $imagePath;  // Update image if new image uploaded
        }

        // Update the product details
        $product->update($request->all());

        return redirect()->route('store-products.index')->with('success', 'Product updated successfully!');
    }

    // Delete a product
    public function destroy($id)
    {
        // Fetch the product by tenant_id to ensure the store owner can delete their own products
        $product = Product::where('tenant_id', auth()->user()->tenant_id)->findOrFail($id);
        
        // Delete the product
        $product->delete();

        return redirect()->route('store-products.index')->with('success', 'Product deleted successfully!');
    }
}
