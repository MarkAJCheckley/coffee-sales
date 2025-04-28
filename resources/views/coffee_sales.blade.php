<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 h-100">
                    <form name="coffee-sale" id="coffee-sale" method="post" action="/sales">
                        @csrf
                        <div class="grid grid-cols-5 gap-5">
                            <div class="w-[1/5]">
                                <label for="product_id">{{ __('sales.product') }}</label><br>
                                <select class="w-full" name="product_id" id="product" onchange="updateSellingPrice()">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-profit-margin="{{ $product->profit_margin }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-[1/5]">
                                <label for="quantity">{{ __('sales.quantity') }}</label><br>
                                <input class="w-full" type="text" id="quantity" name="quantity" onkeyup="quantityInput()">
                            </div>
                            <div class="w-[1/5]">
                                <label for="unit-cost">{{ __('sales.unit_cost_£') }}</label><br>
                                <input class="w-full" type="text" id="unit-cost" name="unit_cost" onkeyup="unitCostInput()"><br>
                            </div>
                            <div class="w-[1/5]">
                                <label>{{ __('sales.selling_price') }}</label><br>
                                <div class="py-2">
                                    <label id="selling-price">£0.00</label>
                                </div>
                            </div>
                            <button id="record-sale" class="self-end border-none h-10 bg-indigo-500 text-white font-bold py-1 px-2 rounded" type="submit">{{ __('sales.record_sale') }}</button>
                        </div>
                    </form>
                    @if(count($previous_sales))
                        <h1 class="py-2 text-xl font-bold">{{ __('sales.previous_sales') }}</h1>
                        <div class="h-100">
                            <table class="pt-3 w-full text-left table-auto min-w-max border overflow-hidden border-black">
                                <thead>
                                    <tr class="bg-gray-300 px-2">
                                        <th>{{ __('sales.product') }}</th>
                                        <th class="border-l border-l-black">{{ __('sales.quantity') }}</th>
                                        <th class="border-l border-l-black">{{ __('sales.unit_cost') }}</th>
                                        <th class="border-l border-l-black">{{ __('sales.selling_price') }}</th>
                                        <th class="border-l border-l-black">{{ __('sales.sold_at') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="overflow-y-auto">
                                    @foreach($previous_sales as $previous_sale)
                                        <tr class="even:bg-gray-100 px-2">
                                            <td>{{ $previous_sale->product->name }}</td>
                                            <td class="border-l border-l-black">{{ $previous_sale->quantity }}</td>
                                            <td class="border-l border-l-black">{{ $previous_sale->unit_cost }}</td>
                                            <td class="border-l border-l-black">£{{ $previous_sale->selling_price }}</td>
                                            <td class="border-l border-l-black">{{ substr($previous_sale->created_at, 0, 16) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-2">{{ __('sales.no_previous_sales') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {updateSellingPrice()};
        function quantityInput()
        {
            let quantity = document.getElementById("quantity");
            quantity.value = quantity.value.replace(/\D/g, '')
            updateSellingPrice();
        }
        function unitCostInput()
        {
            let unitCost = document.getElementById("unit-cost");
            unitCost.value = unitCost.value.replace(/[^.\d]/g, '');
            unitCost.value = unitCost.value.indexOf(".") >= 0 ?
                unitCost.value.slice(0, unitCost.value.indexOf(".") + 3) :
                unitCost.value;
            updateSellingPrice();
        }
        function updateSellingPrice()
        {
            let product = document.getElementById('product');
            let profitMargin = product.options[product.selectedIndex].dataset.profitMargin;
            let quantity = document.getElementById("quantity");
            let unitCost = document.getElementById("unit-cost");
            let sellingPrice = document.getElementById("selling-price");
            if (quantity.value.length && unitCost.value.length) {
                let cost = Number(quantity.value) * Number(unitCost.value);
                let price = (cost / (1 - (profitMargin / 100))) + 10;
                sellingPrice.innerText = '£' + price.toFixed(2);
                recordSaleAllowed(true)
            } else {
                sellingPrice.innerText = '£0.00';
                recordSaleAllowed(false)
            }
        }
        function recordSaleAllowed(allowed)
        {
            let recordSale = document.getElementById("record-sale");
            if (allowed) {
                recordSale.disabled = false;
                recordSale.classList.add('hover:bg-indigo-700')
                recordSale.style.cursor = 'pointer';
            } else {
                recordSale.disabled = true;
                recordSale.classList.remove('hover:bg-indigo-700')
                recordSale.style.cursor = 'not-allowed';
            }
        }
    </script>
</x-app-layout>
