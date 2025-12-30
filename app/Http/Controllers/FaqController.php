<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // Fetch all FAQs
    public function index()
    {
        $faqs = Faq::all();  // You can add pagination if needed
        return response()->json($faqs);
    }

    // Fetch FAQ by ID
    public function show($id)
    {
        $faq = Faq::find($id);
        if ($faq) {
            return response()->json($faq);
        } else {
            return response()->json(['message' => 'FAQ not found'], 404);
        }
    }

    // Store a new FAQ (Admin/Backend only)
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'nullable|string',
        ]);

        $faq = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
        ]);

        return response()->json($faq, 201);
    }
}
