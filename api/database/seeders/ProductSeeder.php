<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Product 1',
                'description' => 'Description of product 1',
                'price' => 100.00,
                'quantity' => 10,
                'image' => 'product1.jpg',
                'active' => true,
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description of product 2',
                'price' => 200.00,
                'quantity' => 20,
                'image' => 'product2.jpg',
                'active' => true,
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description of product 3',
                'price' => 300.00,
                'quantity' => 30,
                'image' => 'product3.jpg',
                'active' => true,
            ],
        ]);
    }
}
