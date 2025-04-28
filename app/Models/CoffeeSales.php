<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $quantity
 * @property float   $unit_cost
 */

class CoffeeSales extends Model
{
    use HasFactory;

    protected $table = 'coffee_sales';

    protected $fillable = ['quantity', 'unit_cost'];


    protected $appends = ['selling_price'];

    public function getSellingPriceAttribute(): string
    {
        $cost = $this->quantity * $this->unit_cost;
        return number_format(($cost / 0.75) + 10, 2);
    }
}
