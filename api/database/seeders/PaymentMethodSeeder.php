<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $paymentMethods = ['PIX', 'Crédito', 'Débito', 'Dinheiro'];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create(['type' => $method]);
        }
    }
}
