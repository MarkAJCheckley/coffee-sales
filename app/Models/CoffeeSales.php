<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $product_id
 * @property integer $quantity
 * @property float   $unit_cost
 *
 * @property Products $product
 */

class CoffeeSales extends Model
{
    use HasFactory;

    protected $table = 'coffee_sales';

    protected $fillable = ['quantity', 'unit_cost'];


    protected $appends = ['selling_price'];

    public function getSellingPriceAttribute(): string
    {
        info('$this->product()->profit_margin.....');
        info($this->product->profit_margin);
        $cost = $this->quantity * $this->unit_cost;
        return number_format(($cost / (1 - ($this->product->profit_margin / 100))) + 10, 2);
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
