<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'target_type',
        'target_value',
        'is_active',
        'is_campaign',
        'start_date',
        'end_date',
        'position',

    ];

    // Optional: Automatically hide expired or upcoming banners
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $now = Carbon::now();
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) {
                $now = Carbon::now();
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            });
    }

    // Optional: Is the banner currently visible?
    public function isVisible()
    {
        $now = now();
        return $this->is_active &&
               (!$this->start_date || $this->start_date <= $now) &&
               (!$this->end_date || $this->end_date >= $now);
    }
}
