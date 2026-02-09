<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'medicine_id',
        'quantity',
        'unit_price',
        'total_price',
        'expiry_date',
        'batch_number',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
