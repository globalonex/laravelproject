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
    public function orders()
    {
        return Order::get();
    }

    public function products($orderId)
    {
        // TODO:: Получить модель из параметра
        $order = Order::find($orderId);
        return $order->products;
    }

    public function finish()
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        /*$ordersProduct = DB::table('orders_products as op')
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
        ->get();*/
        
        $ordersProduct = $order->products;

        // Умножаем ордерпродук на прайс и получаем общую сумму
        $sum = $ordersProduct->map(function($ordersProduct) use ($order) {
            $order->products()->updateExistingPivot($ordersProduct->id, [
                'price' => $ordersProduct->price
            ]);
            $ordersProduct->save();
            return $ordersProduct->pivot->quantity * $ordersProduct->price;
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
        return $order ? $order->products : collect();
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

        if ($order->products->contains($product)) {
            $orderProduct = $order->products()->where('product_id', $product->id)->first();
            $quantity = ++$orderProduct->pivot->quantity;
            $order->products()->updateExistingPivot($product->id, [
                'quantity' => $quantity
            ]);
            
        } else {
            $order->products()->attach($product, [
                'quantity' => 1,
                'price' => $product->price
            ]);
            $orderProduct = $order->products()->where('product_id', $product->id)->first();
        
        }
        return $order->products()->get();

        

        /*$ordersProduct = OrdersProduct::where('order_id', $order->id)
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
        }*/

    }
    public function removeProduct(Request $request)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        if(!$order) {
            $order = Order::create([
                'user_id' => $user->id
            ]);
        }

        $product = Product::find($request['productId']);
        $orderProduct = $order->products()->where('product_id', $product->id)->first();
        if($orderProduct->pivot->quantity == 1) {
            $order->products()->detach($product);
        } else {
            $quantity = --$orderProduct->pivot->quantity;
            $order->products()->updateExistingPivot($product->id, [
                'quantity' => $quantity
            ]);
            
        }
        return $order->products()->get();
        
    }
}
