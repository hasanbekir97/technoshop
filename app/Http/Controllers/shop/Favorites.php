<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Favorite;

class Favorites extends Controller
{
    public function addRemoveFavorite(Request $request){
        $productId = $request->productId;
        $favStatus = '';
        $authStatus = '';

        if(auth()->user()) {
            // if user login

            $userId = auth()->user()->id;

            $productNumber = Favorite::where('product_id', $productId)
                                    ->where('user_id', $userId)
                                    ->count();

            if ($productNumber >= 1) {

                Favorite::where('product_id', $productId)
                        ->where('user_id', $userId)
                        ->delete();

                $favStatus = 'removed';
            } else {
                $favorite = new Favorite;
                $favorite->user_id = $userId;
                $favorite->product_id = $productId;
                $favorite->save();

                $favStatus = 'added';
            }

            $authStatus = 'logged in';
        }
        else{
            // if user don't login

            $authStatus = 'logged out';
        }

        return response()->json([
            'favStatus' => $favStatus,
            'authStatus' => $authStatus
        ],200);
    }
    public function showFavoriteStatus(Request $request){

        if(auth()->user()) {
            // if user login

            $productId = $request->productId;

            $favStatus = '';

            $userId = auth()->user()->id;

            $productNumber = Favorite::where('product_id', $productId)
                                    ->where('user_id', $userId)
                                    ->count();

            if ($productNumber >= 1)
                $favStatus = 'added';
            else
                $favStatus = 'removed';


            return response()->json([
                'favStatus' => $favStatus
            ],200);
        }
        else{
            return response()->json([
                'favStatus' => 'not logged in'
            ],200);
        }
    }
    public function showFavorite(Request $request){
        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
            ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        if(auth()->user()) {
            $userId = auth()->user()->id;

            $favProducts = Favorite::selectRaw('favorites.id as favorite_id, favorites.product_id, products.old_price,
                                                products.price, products.discount_rate, product_urls.name,
                                                product_urls.slug, product_images.image_path')
                                    ->where('favorites.user_id', '=', $userId)
                                    ->join('products', function ($join) {
                                        $join->on('favorites.product_id', '=', 'products.id');
                                    })
                                    ->join('product_urls', function ($join) use($lang_id){
                                        $join->on('favorites.product_id', '=', 'product_urls.product_id')
                                            ->where('product_urls.lang_id', $lang_id);
                                    })
                                    ->join('product_images', function ($join){
                                        $join->on('favorites.product_id', '=', 'product_images.product_id')
                                            ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                              FROM product_images
                                                                                 JOIN favorites
                                                                                    ON favorites.product_id = product_images.product_id
                                                                                    GROUP BY favorites.product_id)');
                                    })
                                    ->get();

            return response()->json([
                'favAllProducts' => $favProducts
            ], 200);
        }
    }
    public function deleteFavorite(Request $request){
        $productId = $request->productId;

        if(auth()->user()) {

            $userId = auth()->user()->id;

            Favorite::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->delete();
        }

        return response()->json([
            'status' => 'successful'
        ]);
    }
    public function deleteAllFavorite(Request $request){
        if(auth()->user()) {
            $userId = auth()->user()->id;

            Favorite::where('user_id', $userId)
                    ->delete();
        }

        return response()->json([
            'status' => 'successful'
        ]);
    }
}
