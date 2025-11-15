<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'type',             // entrada ou saída
        'quantity',
        'previous_stock',
        'final_stock',
    ];

    protected $casts = [
        'quantity'        => 'integer',
        'previous_stock'  => 'integer',
        'final_stock'     => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
