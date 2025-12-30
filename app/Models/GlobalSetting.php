<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{
    protected $fillable = [
        'site_name',
        'support_email',
        'delivery_days',
        'delivery_times',
        'theme_color',
        'enable_reviews',
        'enable_campaigns',
        'enable_wallet',
        'maintenance_mode',
        'default_language',
        'footer_text',
        'copyright',
        'site_logo',
        'site_favicon',

        // payment system
        'enable_cliq',
        'enable_credit',
        'enable_apple',
        'enable_google',
        'bank_name',
        'iban',
        'payment_note',
        'cliq_name',
        'cliq_alias',
        'credit_fee',
        'apple_note',
        'apple_merchant_id',
        'google_note',
        'google_merchant_id',
    ];

    protected $casts = [
        'delivery_days' => 'array',
        'delivery_times' => 'array',
        'enable_reviews' => 'boolean',
        'enable_campaigns' => 'boolean',
        'enable_wallet' => 'boolean',
        'maintenance_mode' => 'boolean',

        // 🔥 Add boolean casts for toggles
        'enable_cliq' => 'boolean',
        'enable_credit' => 'boolean',
        'enable_apple' => 'boolean',
        'enable_google' => 'boolean',
        'credit_fee' => 'decimal:2',
    ];
}
