<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalSetting;

class SettingApiController extends Controller
{
    public function status()
    {
        $settings = GlobalSetting::first();
        return response()->json([
            'maintenance_mode' => $settings->maintenance_mode ?? false,
        ]);
    }
}
