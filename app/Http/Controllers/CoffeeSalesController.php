<?php

namespace App\Http\Controllers;

use App\Models\CoffeeSales;
use App\Models\Products;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CoffeeSalesController extends Controller
{
    function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('coffee_sales', [
            'previous_sales' => CoffeeSales::with('product')->get(),
//            'previous_sales' => CoffeeSales::all(),
            'products' => Products::all()
        ]);
    }

    function recordSale(Request $saleDetails): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {

        $validated = $saleDetails->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric',
        ]);

        $sale = new CoffeeSales();
        $sale->product_id = $validated['product_id'];
        $sale->quantity = $validated['quantity'];
        $sale->unit_cost = $validated['unit_cost'];
        $sale->save();

        return view('coffee_sales', [
            'previous_sales' => CoffeeSales::with('product')->get(),
            'products' => Products::all()
        ]);
    }
}
