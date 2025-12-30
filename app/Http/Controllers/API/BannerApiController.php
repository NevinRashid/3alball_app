<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Carbon;

class BannerApiController extends Controller
{
    // 🏠 Home Page: All active banners + Max 3 campaigns
    public function home()
    {
        $now = now();

        // 🎯 Max 3 campaign banners
        $campaigns = Banner::where('is_active', true)
            ->where('is_campaign', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            })
            ->orderBy('position')
            ->limit(3)
            ->get();

        // 🟢 All regular (non-campaign) banners
        $regulars = Banner::where('is_active', true)
            ->where('is_campaign', false)
            ->orderBy('position')
            ->get();

        return response()->json([
            'banners'   => $this->formatBanners($regulars),
            'campaigns' => $this->formatBanners($campaigns),
        ]);
    }

    // 📣 Campaign Page: Show ALL active campaigns
    public function campaigns()
    {
        $now = now();

        $campaigns = Banner::where('is_active', true)
            ->where('is_campaign', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            })
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json($this->formatBanners($campaigns));
    }

    // 🧰 Shared formatter
    private function formatBanners($banners)
    {
        return $banners->map(function ($banner) {
            return [
                'id'           => $banner->id,
                'title'        => $banner->title,
                'image'        => asset('storage/' . $banner->image),
                'target_type'  => $banner->target_type,
                'target_value' => $banner->target_value,
                'start_date'   => $banner->start_date,
                'end_date'     => $banner->end_date,
            ];
        });
    }
}

