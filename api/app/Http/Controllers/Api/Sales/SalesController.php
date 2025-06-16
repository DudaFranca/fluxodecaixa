<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {

        $sales = Sales::with('paymentMethod')->with('products')->orderBy('created_at', 'desc')->get();
        // $productsSale = Sales::with('products')->get();
        $pix = $sales->where('payment_method_id', 1)->count();
        $creditCard = $sales->where('payment_method_id', 2)->count();
        $debitCard = $sales->where('payment_method_id', 3)->count();
        $cash = $sales->where('payment_method_id', 4)->count();

        return response()->json([
            'sales' => $sales,
            'payment_methods_count' => [
                'pix' => $pix,
                'credit_card' => $creditCard,
                'debit_card' => $debitCard,
                'cash' => $cash,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
            'paymentMethod' => 'required|exists:payment_method,id',
            'totalPrice' => 'required|numeric|min:0',
        ]);

        $sales = new Sales();

        // $sales->user_id = $request->user_id;
        $sales->payment_method_id = $validated['paymentMethod'];
        $sales->total_price = $validated['totalPrice'];
        $sales->total_quantity = count($validated['products']);
        $sales->sale_date = now();

        $sales->save();

        // Preenche a tabela pivot com os produtos vendidos
        $pivotData = [];
        foreach ($validated['products'] as $product) {
            if (isset($pivotData[$product['id']])) {
                // Se o produto já existe, apenas incrementa a quantidade
                $pivotData[$product['id']]['quantity'] += 1;
            } else {
                // Se o produto não existe, adiciona um novo registro
                $pivotData[$product['id']] = [
                    'quantity' => 1,
                    'total_price' => $product['price'],
                ];
            }
        }

        $sales->products()->attach($pivotData);

        return response()->json([
            'status' => true,
            'message' => 'Venda cadastrada com sucesso!',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $sales = Sales::find($id);
        $productSale = ProductSale::where('sales_id', $id)->first();
        $product = Product::where('id', $productSale->product_id)->first();

        if (!$sales || !$productSale || !$product) {
            return response()->json([
                'status' => false,
                'message' => 'Venda não encontrada!',
            ]);
        }
        if (empty($request->products)) {
            $sales->products()->detach();
            $sales->delete();
            return response()->json([
                'status' => true,
                'message' => 'Venda deletada pois não há produtos.',
            ]);
        }

        $sales->payment_method_id = $request->payment_method_id;
        $sales->total_price = $request->total_price;
        $sales->total_quantity = count($request->products);
        $sales->sale_date = now();

        $sales->save();

        // Preenche a tabela pivot com os produtos vendidos
        $pivotData = [];
        foreach ($request->products as $product) {
            if (isset($pivotData[$product['id']])) {
                // Se o produto já existe, apenas incrementa a quantidade
                $pivotData[$product['id']]['quantity'] += 1;
            } else {
                // Se o produto não existe, adiciona um novo registro
                $pivotData[$product['id']] = [
                    'quantity' => 1,
                    'total_price' => $product['price'],
                ];
            }
        }

        $sales->products()->sync($pivotData);

        return response()->json([
            'status' => true,
            'message' => 'Venda atualizada com sucesso!',
        ]);
    }

    public function sale($id)
    {
        $sale = Sales::with('products')->find($id);

        if (!$sale) {
            return response()->json([
                'status' => false,
                'message' => 'Venda não encontrada!',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'sale' => $sale,
        ]);
    }
}
