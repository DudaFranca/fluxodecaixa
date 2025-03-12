<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::with('paymentMethod')->get();
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
        $sales = new Sales();

        // $sales->user_id = $request->user_id;
        $sales->quantity = $request->quantity;
        $sales->product = $request->product;
        $sales->payment_method_id = $request->payment_method_id;
        $sales->price = $request->price;

        $sales->save();

        return response()->json([
            'status' => true,
            'message' => 'Venda cadastrada com sucesso!',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $sales = Sales::find($id);

        if (!$sales) {
            return response()->json([
                'status' => false,
                'message' => 'Venda não encontrada!',
            ]);
        }

        $sales->quantity = $request->quantity;
        $sales->product = $request->product;
        $sales->payment_method_id = $request->payment_method_id;
        $sales->price = $request->price;

        $sales->save();

        return response()->json([
            'status' => true,
            'message' => 'Venda atualizada com sucesso!',
        ]);
    }
}
