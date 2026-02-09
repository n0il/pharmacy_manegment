<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manufacturer',
        'barcode',
        'price',
        'quantity_in_stock',
        'min_quantity',
        'description',
        'prescription_required',
        'image_path',
        'expiry_date',
        'category',
        'active_substance',
        'dosage',
        'dosage_unit',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'dosage' => 'decimal:2',
        'expiry_date' => 'date',
        'prescription_required' => 'boolean',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function deliveryItems()
    {
        return $this->hasMany(DeliveryItem::class);
    }

    public function isLowStock()
    {
        return $this->quantity_in_stock <= $this->min_quantity;
    }

    public function isExpired()
    {
        return $this->expiry_date < now();
    }
}
