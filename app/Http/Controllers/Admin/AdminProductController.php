<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('store')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'approved';
        $product->save();

        // TODO: Push to Flutter app via event or API

        return back()->with('success', 'Product approved successfully.');
    }

    public function reject($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'rejected';
        $product->save();

        return back()->with('success', 'Product rejected successfully.');
    }

    public function show($id)
    {
        $product = Product::with('store')->findOrFail($id);
        return response()->json($product);
    }

    public function exportCsv()
    {
        $products = Product::with('store')->get();

        $csvHeader = ["ID", "Product Name", "Store", "Price", "Stock", "Status", "Created At"];
        $csvData = $products->map(function ($product) {
            return [
                $product->id,
                $product->name,
                $product->store->store_name ?? 'N/A',
                $product->price,
                $product->stock,
                $product->status,
                $product->created_at->format('Y-m-d H:i:s'),
            ];
        });

        $filename = 'products_export_' . now()->format('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csvHeader);
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $contents = stream_get_contents($handle);
        fclose($handle);

        return Response::make($contents, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function exportPdf()
    {
        $products = Product::with('store')->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.products.pdf', compact('products'));
        return $pdf->download('products_export.pdf');
    }
}
