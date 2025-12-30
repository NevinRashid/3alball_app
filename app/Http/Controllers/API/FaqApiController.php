<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqApiController extends Controller
{
    public function index()
    {
        return Faq::all();
    }
}
