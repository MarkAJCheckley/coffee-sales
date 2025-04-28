<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->dataToCreate() as $item) {
            Products::create([
                'name' => $item['name'],
                'profit_margin' => $item['profit_margin'],
            ]);
        }
    }

    private function dataToCreate(): array
    {
        return [
            [
                'name' => 'Gold Coffee',
                'profit_margin' => '25',
            ],
            [
                'name' => 'Arabic Coffee',
                'profit_margin' => '15',
            ],
        ];
    }
}
