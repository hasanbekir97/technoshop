<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Lang;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;

class OrderApi extends Controller
{
    public function index(Request $request){

        $user_id = Auth()->user()->id;

        // orders summary
        $orders = Orders::selectRaw('orders.id as order_id, orders.order_code, orders.total_price,
                                        order_statuses.name as order_status, orders.created_at,
                                        order_informations.phone, order_informations.country, order_informations.city,
                                        order_informations.county, order_informations.address')
            ->where('user_id', $user_id)
            ->join('order_informations', function ($join) {
                $join->on('orders.id', '=', 'order_informations.order_id');
            })
            ->join('order_statuses', function ($join){
                $join->on('orders.status', '=', 'order_statuses.order_status_id');
            })
            ->orderBy('orders.created_at', 'DESC')
            ->get();


        // this information in english language (start)
        $langEnData = Lang::where('name', 'en')
            ->get('lang_id');

        $lang_en_id = $langEnData[0]->lang_id;

        // order products
        $orderEnProducts = Orders::selectRaw('order_products.order_id, order_products.product_id, order_products.quantity,
                                                order_products.price, order_products.cargo_price, products.brand,
                                                product_images.image_path, product_urls.slug, product_urls.name')
            ->where('user_id', $user_id)
            ->join('order_products', function ($join) {
                $join->on('orders.id', '=', 'order_products.order_id');
            })
            ->join('products', function ($join) {
                $join->on('products.id', '=', 'order_products.product_id');
            })
            ->join('product_images', function ($join) {
                $join->on('product_images.product_id', '=', 'order_products.product_id')
                    ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                    FROM product_images
                                                    JOIN order_products
                                                    ON product_images.product_id = order_products.product_id
                                                    GROUP BY order_products.product_id)');
            })
            ->join('product_urls', function ($join) use ($lang_en_id){
                $join->on('product_urls.product_id', '=', 'order_products.product_id')
                    ->where('lang_id', $lang_en_id);
            })
            ->get();
        // this information in english language (end)

        $responseArray = [];

        foreach($orders as $order){
            $products = [];
            foreach($orderEnProducts as $orderEnProduct){
                if($order->order_id === $orderEnProduct->order_id) {
                    array_push($products, [
                        'product_id' => $orderEnProduct->product_id,
                        'quantity' => $orderEnProduct->quantity,
                        'sub_total_price' => $orderEnProduct->price,
                        'cargo_price' => $orderEnProduct->cargo_price,
                        'brand' => $orderEnProduct->brand,
                        'image_path' => 'uploads/'.$orderEnProduct->image_path,
                        'slug' => $orderEnProduct->slug,
                        'name' => $orderEnProduct->name
                    ]);
                }
            }

            array_push($responseArray, [
                'id' => $order->order_id,
                'order_code' => $order->order_code,
                'total_price' => $order->total_price,
                'order_status' => $order->order_status,
                'created_at' => $order->created_at,
                'delivery_address' => [
                    'phone' => $order->phone,
                    'country' => $order->country,
                    'city' => $order->city,
                    'county' => $order->county,
                    'explicit_address' => $order->address
                ],
                'products' => $products
            ]);
        }

        return response()->json([
            'orders' => $responseArray
        ]);

    }
    public function show(Request $request, $id){

        $user_id = Auth()->user()->id;

        // orders summary
        $order = Orders::selectRaw('orders.id as order_id, orders.order_code, orders.total_price,
                                        order_statuses.name as order_status, orders.created_at,
                                        order_informations.phone, order_informations.country, order_informations.city,
                                        order_informations.county, order_informations.address')
            ->where('user_id', $user_id)
            ->where('orders.id', $id)
            ->join('order_informations', function ($join) {
                $join->on('orders.id', '=', 'order_informations.order_id');
            })
            ->join('order_statuses', function ($join){
                $join->on('orders.status', '=', 'order_statuses.order_status_id');
            })
            ->orderBy('orders.created_at', 'DESC')
            ->get();


        // this information in english language (start)
        $langEnData = Lang::where('name', 'en')
            ->get('lang_id');

        $lang_en_id = $langEnData[0]->lang_id;

        // order products
        $orderEnProducts = Orders::selectRaw('order_products.order_id, order_products.product_id, order_products.quantity,
                                                order_products.price, order_products.cargo_price, products.brand,
                                                product_images.image_path, product_urls.slug, product_urls.name')
            ->where('user_id', $user_id)
            ->where('orders.id', $id)
            ->join('order_products', function ($join) {
                $join->on('orders.id', '=', 'order_products.order_id');
            })
            ->join('products', function ($join) {
                $join->on('products.id', '=', 'order_products.product_id');
            })
            ->join('product_images', function ($join) {
                $join->on('product_images.product_id', '=', 'order_products.product_id')
                    ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                    FROM product_images
                                                    JOIN order_products
                                                    ON product_images.product_id = order_products.product_id
                                                    GROUP BY order_products.product_id)');
            })
            ->join('product_urls', function ($join) use ($lang_en_id){
                $join->on('product_urls.product_id', '=', 'order_products.product_id')
                    ->where('lang_id', $lang_en_id);
            })
            ->get();
        // this information in english language (end)

        $responseArray = [];
        $products = [];

        foreach($orderEnProducts as $orderEnProduct){
            array_push($products, [
                'product_id' => $orderEnProduct->product_id,
                'quantity' => $orderEnProduct->quantity,
                'sub_total_price' => $orderEnProduct->price,
                'cargo_price' => $orderEnProduct->cargo_price,
                'brand' => $orderEnProduct->brand,
                'image_path' => 'uploads/'.$orderEnProduct->image_path,
                'slug' => $orderEnProduct->slug,
                'name' => $orderEnProduct->name
            ]);
        }

        array_push($responseArray, [
            'id' => $order[0]->order_id,
            'order_code' => $order[0]->order_code,
            'total_price' => $order[0]->total_price,
            'order_status' => $order[0]->order_status,
            'created_at' => $order[0]->created_at,
            'delivery_address' => [
                'phone' => $order[0]->phone,
                'country' => $order[0]->country,
                'city' => $order[0]->city,
                'county' => $order[0]->county,
                'explicit_address' => $order[0]->address
            ],
            'products' => $products
        ]);

        return response()->json([
            'order' => $responseArray
        ]);

    }
}
