<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageHeroSlide extends Model
{
    protected $fillable = [
        'badge', 'title', 'title_accent', 'description',
        'primary_btn_label', 'primary_btn_url', 'secondary_btn_label', 'secondary_btn_url',
        'background_image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
