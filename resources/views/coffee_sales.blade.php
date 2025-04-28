<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form name="coffee-sale" id="coffee-sale" method="post" action="/sales">
                        @csrf
                        <div class="grid grid-cols-4 gap-2">
                            <div>
                                <label for="quantity">{{ __('sales.quantity') }}</label><br>
                                <input type="text" id="quantity" name="quantity" onkeyup="quantityInput()">
                            </div>
                            <div>
                                <label for="unit-cost">{{ __('sales.unit_cost_£') }}</label><br>
                                <input type="text" id="unit-cost" name="unit_cost" onkeyup="unitCostInput()"><br>
                            </div>
                            <div>
                                <label>{{ __('sales.selling_price') }}</label><br>
                                <div class="py-2">
                                    <label id="selling-price">£0.00</label>
                                </div>
                            </div>
                            <button id="record-sale" class="self-end border-none h-10 bg-indigo-500 text-white font-bold py-1 px-2 rounded" type="submit">{{ __('sales.record_sale') }}</button>
                        </div>
                    </form>
                    <h1 class="py-2 text-xl">{{ __('sales.previous_sales') }}</h1>
                    <div class="">
                        <table class="pt-3 w-full h-auto text-left table-auto min-w-max border border-black">
                            <thead>
                                <tr class="bg-gray-300 px-2">
                                    <th>{{ __('sales.quantity') }}</th>
                                    <th class="border-x border-x-black">{{ __('sales.unit_cost') }}</th>
                                    <th>{{ __('sales.selling_price') }}</th>
                                </tr>
                            </thead>
                            <tbody class="max-h-[330px] overflow-y-auto">
                                @foreach($previous_sales as $previous_sale)
                                    <tr class="even:bg-gray-100 px-2">
                                        <td>{{ $previous_sale->quantity }}</td>
                                        <td class="border-x border-x-black">{{ $previous_sale->unit_cost }}</td>
                                        <td>£{{ $previous_sale->selling_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
            let quantity = document.getElementById("quantity");
            let unitCost = document.getElementById("unit-cost");
            let sellingPrice = document.getElementById("selling-price");
            if (quantity.value.length && unitCost.value.length) {
                let cost = Number(quantity.value) * Number(unitCost.value);
                let price = (cost / 0.75) + 10;
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
