<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\ProductReviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\ProductUrls;
use App\Models\Favorite;
use App\Models\Cart;

class ProductDetail extends Controller
{
    public function index($slug){
        $lang = App::getLocale();

        $langData = Lang::where('name', $lang)
                        ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        $product = ProductUrls::where('slug', $slug)
                            ->join('products', function ($join) use ($lang_id){
                                $join->on('product_urls.product_id', '=', 'products.id')
                                    ->where('product_urls.lang_id', $lang_id);
                            })
                            ->join('product_images', function($join){
                                $join->on('product_urls.product_id', '=', 'product_images.product_id');
                            })
                            ->get();

        $product_id = $product[0]->product_id;


        $star_5_Number = ProductReviews::where('product_id', $product_id)
                                        ->where('star', 5)
                                        ->count();

        $star_4_Number = ProductReviews::where('product_id', $product_id)
                                        ->where('star', 4)
                                        ->count();

        $star_3_Number = ProductReviews::where('product_id', $product_id)
                                        ->where('star', 3)
                                        ->count();

        $star_2_Number = ProductReviews::where('product_id', $product_id)
                                        ->where('star', 2)
                                        ->count();

        $commentNumber = ProductReviews::where('product_id', $product_id)
                                        ->where('comment', '!=', '')
                                        ->count();

        $star_1_Number = ProductReviews::where('product_id', $product_id)
                                        ->where('star', 1)
                                        ->count();

        $totalStarNumber = $star_5_Number + $star_4_Number + $star_3_Number + $star_2_Number + $star_1_Number;

        if($totalStarNumber === 0)
            $starAvg = (($star_5_Number * 5) + ($star_4_Number * 4) + ($star_3_Number * 3) + ($star_2_Number * 2) + ($star_1_Number * 1));
        else
            $starAvg = (($star_5_Number * 5) + ($star_4_Number * 4) + ($star_3_Number * 3) + ($star_2_Number * 2) + ($star_1_Number * 1)) / $totalStarNumber;

        return view('shop.product-details', [
            'product' => $product,
            'star_5_Number' => $star_5_Number,
            'star_4_Number' => $star_4_Number,
            'star_3_Number' => $star_3_Number,
            'star_2_Number' => $star_2_Number,
            'star_1_Number' => $star_1_Number,
            'starAvg' => number_format($starAvg, 1, '.', '.'),
            'reviewNumber' => $totalStarNumber,
            'commentNumber' => $commentNumber
        ]);

    }
    public function stockControl(Request $request){
        $product_id = $request->productId;

        $stock = Products::select('stock')
                            ->where('id', $product_id)
                            ->get();

        $stockNumber = $stock[0]->stock;

        $stockStatus = 0;

        if($stockNumber > 0){
            $stockStatus = 1;
        }

        if($stockStatus === 0){
            Favorite::where('product_id', $product_id)
                        ->delete();
            Cart::where('product_id', $product_id)
                        ->delete();
        }

        return response()->json([
            'stockStatus' => $stockStatus
        ]);
    }
}
