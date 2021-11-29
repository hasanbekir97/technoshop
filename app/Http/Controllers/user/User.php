<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\UserInformations;
use App\Models\Products;
use App\Models\OrderProducts;
use App\Models\Orders;
use App\Models\OrderInformations;
use App\Models\ProductImages;
use App\Models\ProductUrls;
use App\Models\ProductReviews;

class User extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;

        $data = UserInformations::where('user_id', $user_id)
                                ->get();

        return view('profile.user-account', [
            'addressInformation' => $data
        ]);
    }
    public function addressFormSubmit(Request $request){
        $lang = $request->lang;

        if ($lang === 'en') {
            $request->validate([
                'country' => 'required',
                'city' => 'required',
                'county' => 'required',
                'address' => 'required'
            ],
                [
                    'country.required' => 'Please enter your country.',
                    'city.required' => 'Please enter your city.',
                    'county.required' => 'Please enter your county.',
                    'address.required' => 'Please enter your address.'
                ]
            );
        }
        else {
            $request->validate([
                'country' => 'required',
                'city' => 'required',
                'county' => 'required',
                'address' => 'required'
            ],
                [
                    'country.required' => 'Lütfen ülkenizi giriniz.',
                    'city.required' => 'Lütfen şehrinizi giriniz.',
                    'county.required' => 'Lütfen ilçenizi giriniz.',
                    'address.required' => 'Lütfen adresinizi giriniz.'
                ]
            );
        }

        $country = $request->country;
        $city = $request->city;
        $county = $request->county;
        $address = $request->address;

        $user_id = auth()->user()->id;

        UserInformations::updateOrCreate(
            ['user_id' => $user_id],
            [
                'user_id' => $user_id,
                'country' => $country,
                'city' => $city,
                'county' => $county,
                'address' => $address
            ]
        );

        return response()->json([
            'status' => 'successful'
        ]);

    }
    public function showOrder(Request $request){

        $user_id = auth()->user()->id;

        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
            ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        $dataOrders = Orders::selectRaw('orders.id as order_id, orders.order_code, orders.total_price, orders.status, orders.created_at,
                                        order_informations.phone, order_informations.country, order_informations.city,
                                        order_informations.county, order_informations.address')
                            ->where('user_id', $user_id)
                            ->join('order_informations', function ($join) {
                                $join->on('orders.id', '=', 'order_informations.order_id');
                            })
                            ->orderBy('orders.created_at', 'DESC')
                            ->get();

        $dataOrderProducts = Orders::selectRaw('order_products.order_id, order_products.product_id, order_products.quantity,
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
                                ->join('product_urls', function ($join) use ($lang_id){
                                    $join->on('product_urls.product_id', '=', 'order_products.product_id')
                                        ->where('lang_id', $lang_id);
                                })
                                ->get();


        return response()->json([
            'ordersData' => $dataOrders,
            'orderProductsData' => $dataOrderProducts
        ]);

    }
    public function showOrderInformation(Request $request){

        $order_id = $request->orderId;

        $orderInformation = OrderInformations::selectRaw('phone, country, city, county, address')
                            ->where('order_id', $order_id)
                            ->get();


        return response()->json([
            'orderInformation' => $orderInformation
        ]);

    }
    public function showReview(Request $request){

        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
            ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        $pageNum = $request->pageNum;
        $user_id = auth()->user()->id;

        $skip = $pageNum * 10;


        $reviews = ProductReviews::selectRaw('users.name as user_name, product_reviews.id as review_id, product_reviews.star, product_reviews.comment,
                                            product_reviews.created_at, product_images.image_path, product_urls.slug')
                                    ->where('product_reviews.user_id', $user_id)
                                    ->join('users', function ($join) {
                                        $join->on('product_reviews.user_id', '=', 'users.id');
                                    })
                                    ->join('product_urls', function ($join) use ($lang_id){
                                        $join->on('product_reviews.product_id', '=', 'product_urls.product_id')
                                            ->where('lang_id', $lang_id);
                                    })
                                    ->join('product_images', function ($join){
                                        $join->on('product_reviews.product_id', '=', 'product_images.product_id')
                                            ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                              FROM product_images
                                                                                                 JOIN product_reviews
                                                                                                    ON product_reviews.product_id = product_images.product_id
                                                                                                    GROUP BY product_reviews.product_id)');
                                    })
                                    ->orderByRaw('product_reviews.created_at DESC')
                                    ->offset($skip)
                                    ->limit(10)
                                    ->get();

        $uploadedReviewNumber = $skip + count($reviews);
        $uploadLimitNumber = ProductReviews::where('user_id', $user_id)
                                            ->count();

        return response()->json([
            'reviews' => $reviews,
            'uploadLimitNumber' => $uploadLimitNumber,
            'uploadedReviewNumber' => $uploadedReviewNumber
        ]);

    }
    public function userReview(Request $request){

        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
            ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        $product_id = $request->productId;

        $data = Products::selectRaw('products.brand, product_images.image_path, product_urls.name')
                        ->where('products.id', $product_id)
                        ->join('product_urls', function ($join) use ($lang_id){
                            $join->on('products.id', '=', 'product_urls.product_id')
                                ->where('lang_id', $lang_id);
                        })
                        ->join('product_images', function ($join) {
                            $join->on('products.id', '=', 'product_images.product_id')
                                ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                        FROM product_images
                                                                        JOIN products
                                                                        ON product_images.product_id = products.id
                                                                        GROUP BY products.id)');
                        })
                        ->get();

        $user_id = auth()->user()->id;

        $reviewData = ProductReviews::where('user_id', $user_id)
                                    ->where('product_id', $product_id)
                                    ->get();

        $star = '';
        $comment = '';

        if(isset($reviewData[0])){
            $star = $reviewData[0]->star;
            $comment = $reviewData[0]->comment;
            if($comment === "null" || $comment === null)
                $comment = '';
        }

        return response()->json([
            'data' => $data,
            'star' => $star,
            'comment' => $comment
        ]);

    }
    public function reviewFormSubmit(Request $request){

        $request->validate([
            'ratingScore' => 'required'
        ]);

        $commentForm = $request->commentForm;
        $ratingScore = $request->ratingScore;
        $product_id = $request->productId;

        $user_id = auth()->user()->id;

        $productReview = ProductReviews::where('user_id', $user_id)
                                        ->where('product_id', $product_id)
                                        ->get();

        ProductReviews::updateOrCreate(
            [
                'user_id' => $user_id,
                'product_id' => $product_id
            ],
            [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'star' => $ratingScore,
                'comment' => $commentForm
            ]
        );


        $data = Products::where('id', $product_id)
                        ->get();

        $starAvgOld = $data[0]->star_avg;
        $starNumberOld = $data[0]->star_number;

        if(isset($productReview[0])){
            $ratingScoreOld = $productReview[0]->star;

            $starAvg = (($starAvgOld * $starNumberOld) - $ratingScoreOld) + $ratingScore;
            $starNumber = $starNumberOld;

            $starAvg /= $starNumber;
        }
        else {
            $starAvg = ($starAvgOld * $starNumberOld) + $ratingScore;
            $starNumber = $starNumberOld + 1;

            $starAvg /= $starNumber;
        }

        Products::where('id', $product_id)
                ->update([
                    'star_avg' => $starAvg,
                    'star_number' => $starNumber
                ]);

        return response()->json([
            'status' => 'successful'
        ]);

    }
}
