<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowStockNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'current_stock',
        'sent',
    ];

    protected $casts = [
        'sent' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
