<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'long_description',
        'image',
        'price',
        'original_price',
        'type',
        'duration',
        'rating',
        'activities',
        'highlights',
        'category',
        'difficulty',
        'season',
        'gallery',
        'included',
        'not_included',
        'city',
        'region',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'activities' => 'array',
        'highlights' => 'array',
        'gallery' => 'array',
        'included' => 'array',
        'not_included' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->original_price || $this->original_price <= $this->price) {
            return null;
        }

        return round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
