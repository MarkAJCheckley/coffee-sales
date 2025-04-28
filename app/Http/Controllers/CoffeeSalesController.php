<?php

namespace App\Http\Controllers;

use App\Models\CoffeeSales;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CoffeeSalesController extends Controller
{
    function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('coffee_sales', ['previous_sales' => CoffeeSales::all(), 'majc' => 'MAJC was ere']);
    }

    function recordSale(Request $saleDetails): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {

        $validated = $saleDetails->validate([
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric',
        ]);

        $sale = new CoffeeSales();
        $sale->quantity = $validated['quantity'];
        $sale->unit_cost = $validated['unit_cost'];
        $sale->save();

        return view('coffee_sales', ['previous_sales' => CoffeeSales::all(), 'majc' => 'Sale got!']);
    }
}
