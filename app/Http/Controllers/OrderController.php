<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function products(Order $orderId)
    {
        // TODO:: Получить модель из параметра
        $order = Order::find($orderId);
        return DB::table('orders_products as op')
        ->select(
            'op.id',
            'op.quantity',
            'op.product_id',
            'p.title',
            'p.price',
            'p.picture'
            
        )
        ->join('products as p', 'p.id', 'op.product_id')
        ->where('op.order_id', $order->first()->id)
        ->get();
    }

    public function finish()
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        $ordersProduct = DB::table('orders_products as op')
        ->select(
            'op.id',
            'op.quantity',
            'op.product_id',
            'p.title',
            'p.price',
            'p.picture'
            
        )
        ->join('products as p', 'p.id', 'op.product_id')
        ->where('op.order_id', $order->id)
        ->get();
        // Умножаем ордерпродук на прайс и получаем общую сумму
        $sum = $ordersProduct->map(function($ordersProduct) {
            return $ordersProduct->quantity * $ordersProduct->price;
        })->sum();
        // дата
        $data = [
            'orderProducts' => $ordersProduct,
            'sum' => $sum
        ];
        // отправка
        try {
            $res = Mail::send('mail.orderFinish', $data, function($message) use ($user) {
                $message->subject('Новый заказ');
                $message->to($user->email);
            });
        } catch (Exception $e) {

        }

        $order->status = 1;
        $order->save();
    }
    public function cart() 
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        $ordersProduct = collect();
        if(isset($order)) {
            $ordersProduct = DB::table('orders_products as op')
            ->select(
                'op.id',
                'op.quantity',
                'op.product_id',
                'p.title',
                'p.price',
                'p.picture'
                
            )
            ->join('products as p', 'p.id', 'op.product_id')
            ->where('op.order_id', $order->id)
            ->get();
        }
        return view('cart', ['ordersProduct' => $ordersProduct]);
    }

    public function addProduct(Request $request)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        if(!$order) {
            $order = Order::create([
                'user_id' => $user->id
            ]);
        }

        $product = Product::find($request['productId']);

        $ordersProduct = OrdersProduct::where('order_id', $order->id)
        ->where('product_id', $product->id)
        ->first();

        if($ordersProduct) {
            $ordersProduct->quantity += $request['quantityChange'];
            if($ordersProduct->quantity == 0) {
                $ordersProduct->delete();
            } else {
                $ordersProduct->save();
            }
            
        } else {
            $ordersProduct = OrdersProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }
        return $ordersProduct;

         

    }
}
