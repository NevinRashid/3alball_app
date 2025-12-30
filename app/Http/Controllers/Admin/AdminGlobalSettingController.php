<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GlobalSetting;

class AdminGlobalSettingController extends Controller
{
    /**
     * Display the settings form (GET /settings).
     */
    public function index()
    {
        $settings = GlobalSetting::firstOrCreate([]);
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Handle settings update (POST /settings).
     */
    public function update(Request $request)
    {
        $settings = GlobalSetting::firstOrNew([]);

        // Text fields
        $settings->site_name = $request->input('site_name');
        $settings->support_email = $request->input('support_email');
        $settings->delivery_times = array_map('trim', explode(',', $request->input('delivery_times', '')));
        $settings->delivery_days = range(1, intval($request->input('delivery_date_range', 7)));
        $settings->theme_color = $request->input('theme', 'auto');
        $settings->default_language = $request->input('default_language', 'en');
        $settings->footer_text = $request->input('footer_text');
        $settings->copyright = $request->input('copyright');

        // New: Default notification image URL
        $settings->default_fcm_image = $request->input('default_fcm_image');

        // Checkboxes
        $settings->enable_reviews = $request->has('enable_reviews');
        $settings->enable_campaigns = $request->has('enable_campaigns');
        $settings->enable_wallet = $request->has('enable_wallet');
        $settings->maintenance_mode = $request->has('maintenance_mode');

        // File uploads
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('uploads/logos', 'public');
            $settings->site_logo = $path;
        
            // 👇 Automatically use it as the FCM image
            $settings->default_fcm_image = asset('storage/' . $path);
        }

        if ($request->hasFile('site_favicon')) {
            $settings->site_favicon = $request->file('site_favicon')->store('uploads/favicons', 'public');
        }

        $settings->save();

        return redirect()->route('admin.settings.index')->with('success', 'Global settings updated successfully.');
    }
}
