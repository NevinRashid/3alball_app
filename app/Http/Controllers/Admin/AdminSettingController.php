<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalSetting;

class AdminSettingController extends Controller
{
    

public function edit()
{
    $settings = GlobalSetting::firstOrCreate([]);
    return view('admin.settings.global', compact('settings'));
}

public function update(Request $request)
{
    $settings = GlobalSetting::first();
    $settings->update($request->only([
        'site_name', 'support_email', 'theme_color', 'enable_reviews', 'enable_campaigns'
    ]) + [
        'delivery_days' => $request->delivery_days ?? [],
        'delivery_times' => $request->delivery_times ?? [],
    ]);

    return back()->with('success', 'Settings updated successfully!');
}

}
