<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination_id',
        'booking_number',
        'travel_date',
        'travelers_count',
        'total_price',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'special_requests',
        'payment_details',
        'payment_date',
        'payment_method'
    ];

    protected $casts = [
        'travel_date' => 'date',
        'total_price' => 'decimal:2',
        'payment_details' => 'array',
        'payment_date' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (!$booking->booking_number) {
                $booking->booking_number = 'BK' . date('Y') . str_pad(static::count() + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('travel_date', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('travel_date', '<', now());
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Oczekująca',
            'confirmed' => 'Potwierdzona',
            'paid' => 'Opłacona',
            'completed' => 'Zakończona',
            'cancelled' => 'Anulowana',
            default => 'Nieznany'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'orange',
            'confirmed' => 'blue',
            'paid' => 'green',
            'completed' => 'gray',
            'cancelled' => 'red',
            default => 'gray'
        };
    }
}
