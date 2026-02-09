<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_number',
        'supplier_name',
        'expected_delivery_date',
        'actual_delivery_date',
        'status',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function deliveryItems()
    {
        return $this->hasMany(DeliveryItem::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    public function isOverdue()
    {
        return $this->status === 'pending' && $this->expected_delivery_date < now();
    }
}
