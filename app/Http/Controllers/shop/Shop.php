<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brands;

class Shop extends Controller
{
    public function index(Request $request){
        if(request()->has('search')){
            $search = request()->search;
        }else{
            $search = null;
        }

        if(request()->has('price')){
            $price = request()->price;
            $prices = explode('-', $price);
            $min_price = (int)$prices[0];
            $max_price = (int)$prices[1];
        }else{
            $min_price = '';
            $max_price = '';
        }

        if(request()->has('sort')){
            $sort = request()->sort;
        }else{
            $sort = '';
        }


        return view('index',[
            'search' => $search,
            'max_price' => $max_price,
            'min_price' => $min_price,
            'sort' => $sort
        ]);
    }
}
