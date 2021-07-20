<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getCategoryProducts($categoryId)
    {
        return Product::where('category_id', $categoryId)->get();
    }

    public function list ()
    {
        return view('products');
    }
    public function get ()
    {
        return Product::get();
    }
    public function create(Request $request) 
    {
        $name = $request['name'];
        $categoryId = $request['categoryId'];
        $price = $request['price'];
        $description = $request['description'];
        $categoryId = $request['categoryId'];

        $request->validate([
            'categoryId' => ['required'],
            'name' => ['required'],
            'price' => ['required'],
        ]);

        $file = $request->file('picture');
        if($file) {
            $filename = time() . $file->getClientOriginalName();
            $request->file('picture')->storeAs('public/img', $filename);
        } else {
            $filename = '';
        }
        Product::create([
            'title' => $name,
            'category_id' => $categoryId,
            'price' => $price,
            'description' => $description,
            'picture' => $filename
        ]);
    }
}
