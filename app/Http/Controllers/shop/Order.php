<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Http\Controllers\user\User;
use App\Mail\OrderMail;
use App\Models\Lang;
use App\Models\UserInformations;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Products;
use App\Models\Orders;
use App\Models\OrderProducts;
use App\Models\OrderInformations;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class Order extends Controller
{
    public function index(){
        if(auth()->user()){

            $user_id = auth()->user()->id;

            $cartTemp = Cart::where('user_id', $user_id)->get();
            if(empty($cartTemp[0])){
                return redirect('/');
            }

            $data = Cart::selectRaw('carts.quantity, carts.price, products.cargo_price')
                            ->where('user_id', $user_id)
                            ->join('products', function($join){
                                $join->on('carts.product_id', '=', 'products.id');
                            })
                            ->get();

            $totalItem = count($data);
            $totalProductPrice = $data->sum('price');
            $totalCargoPrice = $data->sum('cargo_price');

            $summaryPrice = $totalProductPrice + $totalCargoPrice;

            $userInformation = UserInformations::selectRaw('country, city, county, phone, address')
                                                ->where('user_id', $user_id)
                                                ->get();

            return view('shop.payment', [
                'userInformation' => $userInformation,
                'totalItem' => $totalItem,
                'totalProductPrice' => $totalProductPrice,
                'totalCargoPrice' => $totalCargoPrice,
                'summaryPrice' => $summaryPrice,
            ]);
        }
        else{
            return redirect('/login');
        }
    }
    public function result(){
        return view('shop.order-result');
    }
    public function paymentAddressSubmitForm(Request $request){
        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
            ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        $cartTemp = Cart::where('user_id', auth()->user()->id)->get();

        if(empty($cartTemp[0])){
            if($lang === 'en') {
                return response()->json([
                    'result' => 'not found product in cart'
                ]);
            }
            else {
                return response()->json([
                    'result' => 'Ürün sepette bulunamadı'
                ]);
            }
        }
        else{
            if($lang === 'en') {
                $request->validate([
                    'country' => 'required',
                    'city' => 'required',
                    'county' => 'required',
                    'phone' => 'required',
                    'address' => 'required'
                ],
                    [
                        'country.required' => 'Please enter your country.',
                        'city.required' => 'Please enter your city.',
                        'county.required' => 'Please enter your county.',
                        'phone.required' => 'Please enter your phone number.',
                        'address.required' => 'Please enter your address.'
                    ]
                );
            }
            else{
                $request->validate([
                    'country' => 'required',
                    'city' => 'required',
                    'county' => 'required',
                    'phone' => 'required',
                    'address' => 'required'
                ],
                    [
                        'country.required' => 'Lütfen ülkenizi giriniz.',
                        'city.required' => 'Lütfen şehrini giriniz.',
                        'county.required' => 'Lütfen ilçenizi giriniz.',
                        'phone.required' => 'Lütfen telefon numaranızı giriniz.',
                        'address.required' => 'Lütfen adresinizi giriniz.'
                    ]
                );
            }

            $country = $request->country;
            $city = $request->city;
            $county = $request->county;
            $phone = $request->phone;
            $address = $request->address;

            $user_id = auth()->user()->id;

            UserInformations::updateOrCreate(
                ['user_id' => $user_id],
                [
                    'user_id' => $user_id,
                    'country' => $country,
                    'city' => $city,
                    'county' => $county,
                    'phone' => $phone,
                    'address' => $address
                ]
            );



            //save to orders the products that is in cart.(start)
            $cart = Cart::selectRaw('carts.product_id, carts.quantity, carts.price, products.cargo_price, products.price as unit_price')
                ->where('user_id', $user_id)
                ->join('products', function($join){
                    $join->on('carts.product_id', '=', 'products.id');
                })
                ->get();



            $totalProductPrice = $cart->sum('price');
            $totalCargoPrice = $cart->sum('cargo_price');

            $summaryPrice = $totalProductPrice + $totalCargoPrice;



            $order_code = rand(10, 99).time().rand(0, 9);

            $order = new Orders();
            $order->order_code = $order_code;
            $order->user_id = $user_id;
            $order->total_price = $summaryPrice;
            $order->status = 0;
            $order->save();
            //save to orders the products that is in cart.(end)




            //save to order information the information that is in user information.(start)
            $orderInformation = new OrderInformations();
            $orderInformation->order_id = $order->id;
            $orderInformation->phone = $phone;
            $orderInformation->country = $country;
            $orderInformation->city = $city;
            $orderInformation->county = $county;
            $orderInformation->address = $address;
            $orderInformation->save();
            //save to order information the information that is in user information.(end)



            //move to order products the products that is in cart and these products are deleted from cart.(start)
            foreach($cart as $row){
                $orderProducts = new OrderProducts();
                $orderProducts->order_id = $order->id;
                $orderProducts->product_id = $row['product_id'];
                $orderProducts->unit_price = $row['unit_price'];
                $orderProducts->quantity = $row['quantity'];
                $orderProducts->price = $row['price'];
                $orderProducts->cargo_price = $row['cargo_price'];
                $orderProducts->save();
            }

            Cart::where('user_id', $user_id)
                ->delete();
            //move to orders the products that is in cart and these products are deleted from cart.(end)


            $emailAdmin = Admin::select('email')
                ->get();

            $orderProducts = OrderProducts::selectRaw('product_urls.name, products.sku, order_products.unit_price,
                                                    order_products.quantity, order_products.price, product_images.image_path,
                                                    order_products.cargo_price')
                ->where('order_id', $order->id)
                ->join('products', 'order_products.product_id', '=', 'products.id')
                ->join('product_urls', function ($join) use ($lang_id) {
                    $join->on('order_products.product_id', '=', 'product_urls.product_id')
                        ->where('product_urls.lang_id', $lang_id);
                })
                ->join('product_images', function ($join){
                    $join->on('order_products.product_id', '=', 'product_images.product_id')
                        ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                      FROM product_images
                                                                                         JOIN order_products
                                                                                            ON order_products.product_id = product_images.product_id
                                                                                            GROUP BY order_products.product_id)');
                })
                ->get();

            $subTotalPrice = $orderProducts->sum('price');
            $cargoPrice = $orderProducts->sum('cargo_price');
            $totalPrice = $subTotalPrice + $cargoPrice;

            $subTotalPrice = number_format($subTotalPrice, 2,',','.');
            $cargoPrice = number_format($cargoPrice, 2,',','.');
            $totalPrice = number_format($totalPrice, 2,',','.');

            $order_date = Carbon::parse($order->created_at)->format('d.m.Y');

            $orderInformation = OrderInformations::selectRaw('order_informations.phone, order_informations.country,
                                                        order_informations.city, order_informations.county,
                                                        order_informations.address, users.name, users.email')
                ->where('order_informations.order_id', $order->id)
                ->join('users', function($join) use($user_id){
                    $join->where('users.id', '=', $user_id);
                })
                ->get();

            Mail::to($emailAdmin[0]->email)->send(new OrderMail(
                $orderInformation,
                $order_date,
                $order_code,
                $orderProducts,
                $subTotalPrice,
                $cargoPrice,
                $totalPrice
            ));

            return response()->json([
                'result' => 'successful'
            ]);
        }

    }
}
