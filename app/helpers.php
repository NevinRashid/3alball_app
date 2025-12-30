<?php

use App\Models\GlobalSetting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = GlobalSetting::first();
        }

        return $settings->$key ?? $default;
    }
}
