<?php

namespace App\Http\Controllers; // ✅ ADD THIS

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $orderId = time();

        foreach ($request->products as $item) {

            $product = Product::find($item['product_id']);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'error' => "Not enough stock for product ID {$product->id}"
                ], 400);
            }

            Order::create([
                'order_id' => $orderId,
                'user_id' => $request->user_id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);

            $product->stock -= $item['quantity'];
            $product->save();
        }

        return response()->json([
            'message' => 'Order placed successfully',
            'order_id' => $orderId
        ]);
    }

    public function getByUser($user_id)
    {
        $orders = Order::where('user_id', $user_id)
            ->with('product:id,name,price')
            ->get();

        return response()->json($orders);
    }
}