<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrdersProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function welcome ()
    {
       
        $categories = Category::get();
        return view('welcome', [
            'categories' => $categories,
            ]);
    }

    public function show ($categoryId)
    {        
        $products = DB::table('products')
            ->where('category_id', '=', $categoryId)
            ->get();

        $user = Auth::user();
        if($user) {
            $order = Order::where('user_id', $user->id)
            ->where('status', 0)
            ->first();
        }
        

        $ordersProduct = collect();
        if (isset($order)) {
            $ordersProduct = OrdersProduct::where('order_id', $order->id)->get();
        }

        return view('categoryProducts', [
                'products' => $products,
                'ordersProducts' => $ordersProduct
            ]);
    }


    public function list ()
    {
        $categories = Category::get();
        return view('categories', [
            'categories' => $categories,
            'title' => 'Категории'
            ]);
    }

    public function create(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'max:255'],
            'desc' => ['required', 'max:255']
        ]);

        sleep(1);
        Category::create([
            'title' => $request['name'],
            'description' => $request['desc']
        ]);
    }

    public function get()
    {
        return Category::get();
    }
    public function deleteCategory($id)
    {
        Category::find($id)->delete();
    }
}
