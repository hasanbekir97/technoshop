<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Products;
use App\Models\Cart;

class Carts extends Controller
{
    public function index(){
        return view('shop.cart');
    }
    public function addCart(Request $request){
        session_start();

        $productId = $request->productId;
        $itemNumber = $request->productNumber;

        $product = Products::where('id', $productId)->get();

        $price = $product[0]['price'];
        $stock = $product[0]->stock;

        if(auth()->user()) {
            // if user login

            $userId = auth()->user()->id;

            $cartProduct = Cart::where('product_id', $productId)
                                ->where('user_id', $userId)
                                ->get();

            if (isset($cartProduct[0])) {

                $newProductNum = $cartProduct[0]->quantity + $itemNumber;

                if($newProductNum > $stock){
                    $newProductNum = $stock;
                }

                $totalPrice = $price * $newProductNum;

                Cart::where('product_id', $productId)
                    ->where('user_id', $userId)
                    ->update([
                        'product_id' => $productId,
                        'quantity' => $newProductNum,
                        'price' => $totalPrice,
                    ]);
            } else {
                $stock = $product[0]->stock;
                if($itemNumber > $stock){
                    $itemNumber = $stock;
                }

                $totalPrice = $price * $itemNumber;

                $cart = new Cart;
                $cart->user_id = $userId;
                $cart->product_id = $productId;
                $cart->quantity = $itemNumber;
                $cart->price = $totalPrice;
                $cart->save();
            }
        }
        else{
            // if user don't login

            $productIndex = 0;
            $cartProductNumber = 0;

            foreach(session('cart') as $key=>$value){
                if($value['productId'] === $productId) {
                    $cartProductNumber = $value['productNumber'];
                    $productIndex = $key;
                }
            }

            if ($cartProductNumber !== 0) {

                $newProductNum = $cartProductNumber + $itemNumber;

                if($newProductNum > $stock){
                    $newProductNum = $stock;
                }

                $totalPrice = $price * $newProductNum;

                session()->put('cart.'.$productIndex.'.productNumber', $newProductNum);
                session()->put('cart.'.$productIndex.'.totalPrice', $totalPrice);

            } else {
                $stock = $product[0]->stock;

                if($itemNumber > $stock){
                    $itemNumber = $stock;
                }

                $totalPrice = $price * $itemNumber;

                session()->push('cart',
                    [
                        'productId' => $productId,
                        'productNumber' => $itemNumber,
                        'totalPrice' => $totalPrice,
                    ]
                );
            }
        }

        return response()->json([
            'status' => 'successful'
        ]);
    }
    public function showCartNumber(Request $request){
        session_start();

        $cartNumber = 0;

        if(auth()->user()) {
            $userId = auth()->user()->id;

            $guestProductNum = count(session('cart'));

            if ($guestProductNum >= 1) {
                foreach(session('cart') as $key=>$value){
                    $productId = $value['productId'];

                    $productUser = Cart::where('product_id', $productId)
                                        ->where('user_id', $userId)
                                        ->get();

                    $product = Products::where('id', $productId)
                        ->get();

                    if(isset($productUser[0])){

                        $price = $product[0]->price;

                        $guestProductNumber = $value['productNumber'];

                        $userProductNumber = $productUser[0]->quantity;
                        $newProductNum = $guestProductNumber + $userProductNumber;
                        $totalPrice = $price * $newProductNum;

                        Cart::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->update([
                                'quantity' => $newProductNum,
                                'price' => $totalPrice,
                            ]);

                        session()->forget('cart.'.$key);

                    }
                    else{
                        $itemNumber = $value['productNumber'];
                        $totalPrice = $value['totalPrice'];

                        $cart = new Cart;
                        $cart->user_id = $userId;
                        $cart->product_id = $productId;
                        $cart->quantity = $itemNumber;
                        $cart->price = $totalPrice;
                        $cart->save();

                        session()->forget('cart.'.$key);
                    }
                }
                $cartNumber = Cart::where('user_id', $userId)
                                    ->count();
            }
            else{
                $userId = auth()->user()->id;
                $cartNumber = Cart::where('user_id', $userId)
                                    ->count();
            }
        }
        else{
            $cartNumber = count(session('cart'));
        }

        return response()->json([
            'cartNumber' => $cartNumber
        ], 200);
    }
    public function showCart(Request $request){
        session_start();
        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
                        ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        if(auth()->user()) {
            $userId = auth()->user()->id;

            $cartProductsAll = Cart::selectRaw('carts.price as cart_price, carts.quantity, products.id as product_id,
                                                products.brand, products.stock, products.cargo_price, product_urls.slug,
                                                product_urls.name, product_images.image_path')
                                    ->where('carts.user_id', $userId)
                                    ->join('products', function ($join){
                                        $join->on('carts.product_id', '=', 'products.id');
                                    })
                                    ->join('product_urls', function ($join) use($lang_id){
                                        $join->on('carts.product_id', '=', 'product_urls.product_id')
                                            ->where('lang_id', $lang_id);
                                    })
                                    ->join('product_images', function ($join){
                                        $join->on('carts.product_id', '=', 'product_images.product_id')
                                            ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                          FROM product_images
                                                                                             JOIN carts
                                                                                                ON carts.product_id = product_images.product_id
                                                                                                GROUP BY carts.product_id)');
                                    })
                                    ->get();

            $totalProductPrice = $cartProductsAll->sum('cart_price');
            $totalProductCargoPrice = $cartProductsAll->sum('cargo_price');
            $totalProductNumber = count($cartProductsAll);
            $totalFinalPrice = $totalProductPrice + $totalProductCargoPrice;
        }
        else{
            $cartProductsAll = array();
            $totalProductNumber = count(session('cart'));
            $totalProductPrice = 0;
            $totalProductCargoPrice = 0;
            $totalFinalPrice = 0;

            foreach(session('cart') as $key=>$value){

                $productId = $value['productId'];

                $product = Products::selectRaw('products.brand, products.stock, products.price,
                                                products.cargo_price, product_urls.slug, product_urls.name,
                                                product_images.image_path')
                                    ->where('products.id', $productId)
                                    ->join('product_urls', function ($join) use($lang_id){
                                        $join->on('products.id', '=', 'product_urls.product_id')
                                            ->where('lang_id', $lang_id);
                                    })
                                    ->join('product_images', function ($join){
                                        $join->on('products.id', '=', 'product_images.product_id')
                                            ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                      FROM product_images
                                                                                         JOIN products
                                                                                            ON products.id = product_images.product_id
                                                                                            GROUP BY products.id)');
                                    })
                                    ->get();

                $cartId = $key;
                $productNumber = $value['productNumber'];
                $totalPrice = $value['totalPrice'];
                $brand = $product[0]['brand'];
                $name = $product[0]['name'];
                $cargoPrice = $product[0]['cargo_price'];
                $price = $product[0]['price'];
                $image = $product[0]['image_path'];
                $slug = $product[0]['slug'];
                $stock = $product[0]['stock'];

                if($productNumber > $stock)
                    $productNumber = $stock;

                $totalPrice = $productNumber * $price;

                $totalProductPrice += $totalPrice;
                $totalProductCargoPrice += $cargoPrice;


                array_push($cartProductsAll, [
                    'cart_id' => $cartId,
                    'product_id' => $productId,
                    'quantity' => $productNumber,
                    'cart_price' => $totalPrice,
                    'brand' => $brand,
                    'name' => $name,
                    'cargo_price' => $cargoPrice,
                    'image_path' => $image,
                    'slug' => $slug,
                    'stock' => $stock,
                ]);
            }

            $totalFinalPrice = $totalProductPrice + $totalProductCargoPrice;
        }


        return response()->json([
            'cartAllProducts' => $cartProductsAll,
            'totalProductNumber' => $totalProductNumber,
            'totalProductPrice' => $totalProductPrice,
            'totalProductCargoPrice' => $totalProductCargoPrice,
            'totalFinalPrice' => $totalFinalPrice,
        ], 200);
    }
    public function updateCart(Request $request){
        session_start();
        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
            ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        $productId = $request->productId;
        $itemNumber = $request->itemNumber;
        $finalStock = false;

        if($itemNumber === null || $itemNumber <= 1){
            $itemNumber = 1;
        }

        $product = Products::where('products.id', $productId)
                            ->join('product_urls', function ($join) use ($lang_id){
                                $join->on('products.id', '=', 'product_urls.product_id')
                                    ->where('lang_id', $lang_id);
                            })
                            ->get();

        $price = $product[0]->price;
        $stock = $product[0]->stock;
        $productName = $product[0]->name;

        if($itemNumber >= $stock) {
            $itemNumber = $stock;
            $finalStock = true;
        }

        $totalPrice = $itemNumber * $price;


        if(auth()->user()) {
            $userId = auth()->user()->id;

            Cart::where('carts.user_id', $userId)
                ->where('product_id', $productId)
                ->update([
                    'quantity' => $itemNumber,
                    'price' => $totalPrice
                ]);
        }
        else{
            $productIndex = 0;

            foreach(session('cart') as $key=>$value){
                $sessionProductId = $value['productId'];

                if($sessionProductId === $productId){
                    $productIndex = $key;
                    break;
                }
            }

            session()->put('cart.'.$productIndex.'.productNumber', $itemNumber);
            session()->put('cart.'.$productIndex.'.totalPrice', $totalPrice);
        }


        return response()->json([
            'itemNumber' => $itemNumber,
            'totalPrice' => $totalPrice,
            'finalStock' => $finalStock,
            'productName' => $productName,
        ]);
    }
    public function deleteCart(Request $request){
        session_start();

        $productId = $request->productId;

        if(auth()->user()) {
            $userId = auth()->user()->id;

            Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->delete();
        }
        else{
            $productIndex = 0;

            foreach(session('cart') as $key=>$value){

                $sessionProductId = $value['productId'];

                if($sessionProductId === $productId){
                    $productIndex = $key;
                    break;
                }
            }

            session()->forget('cart.'.$productIndex);
        }

        return response()->json([
            'status' => 'successful'
        ]);
    }
    public function deleteAllCart(Request $request){
        session_start();

        if(auth()->user()) {
            $userId = auth()->user()->id;

            Cart::where('user_id', $userId)
                ->delete();
        }
        else{
            foreach(session('cart') as $key=>$value){
                session()->forget('cart.'.$key);
            }

        }

        return response()->json([
            'status' => 'successful'
        ]);
    }
}
