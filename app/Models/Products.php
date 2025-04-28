<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string  $name
 * @property integer $profit_margin
 */

class Products extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'products';
}
