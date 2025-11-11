<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['client','products'])->paginate(15);
        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $payload = $request->validated();

        DB::beginTransaction();
        try {
            $order = Order::create(['client_id' => $payload['client_id']]);

            foreach ($payload['products'] as $p) {
                $product = Product::findOrFail($p['product_id']);
                $order->products()->attach($product->id, [
                    'quantity' => $p['quantity'],
                    'unit_price' => $product->price,
                ]);
            }

            // carregar relacionamentos
            $order->load('client','products');

            // disparar evento para envio de e-mail (listener deverá fazer o envio)
            event(new OrderCreated($order));

            DB::commit();

            return response()->json($order, 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Could not create order', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Order $order)
    {
        return response()->json($order->load('client','products'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
