<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Lang;
use App\Models\Orders;
use App\Models\OrderInformations;
use App\Models\OrderProducts;
use App\Models\User;
use App\Models\UserInformations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderAdmin extends Controller
{
    public function index(Request $request){
        return view('admin.orders.orders');
    }
    public function showOrders(Request $request){
        if($request->ajax()){
            $data = Orders::selectRaw('id, order_code, total_price, status, created_at')
                            ->get();

            return DataTables::of($data)
                ->addColumn('transaction', function($row){
                    $viewButton = '<a class="viewButton" href="/admin/order-detail/'.$row->id.'" title="View Order">' .
                        '              <i class="fal fa-eye"></i> View Order' .
                        '          </a>';

                    return $viewButton;
                })
                ->addColumn('created_at', function($row){
                    $date = Carbon::parse($row->created_at)->format('d.m.Y');

                    return $date;
                })
                ->addColumn('total_price', function($row){
                    $total_price = '$ '.strval(number_format($row->total_price, 2, ',', '.'));

                    return $total_price;
                })
                ->addColumn('status', function($row){
                    $status = '';

                    if($row->status === 0)
                        $status = 'On Hold';
                    else if($row->status === 1)
                        $status = 'Preparing';
                    else if($row->status === 2)
                        $status = 'In Cargo';
                    else if($row->status === 3)
                        $status = 'Completed';
                    else if($row->status === 4)
                        $status = 'Cancelled';

                    return $status;
                })
                ->rawColumns(['transaction', 'created_at', 'total_price', 'status'])
                ->toJson();

        }
    }
    public function orderDetail($id){
        $userInformation = Orders::selectRaw('users.name, users.email, user_informations.phone, user_informations.country, user_informations.city,
                                    user_informations.county, user_informations.address, orders.order_code, orders.created_at, orders.status')
                                    ->where('orders.id', $id)
                                    ->join('user_informations', 'orders.user_id', '=', 'user_informations.user_id')
                                    ->join('users', 'orders.user_id', '=', 'users.id')
                                    ->get();

        $orderInformation = Orders::selectRaw('users.name, users.email, order_informations.phone, order_informations.country, order_informations.city,
                                    order_informations.county, order_informations.address')
                                    ->where('orders.id', $id)
                                    ->join('order_informations', 'orders.id', '=', 'order_informations.order_id')
                                    ->join('users', 'orders.user_id', '=', 'users.id')
                                    ->get();

        $order_code = $userInformation[0]->order_code;
        $order_date = Carbon::parse($userInformation[0]->created_at)->format('d.m.Y');
        $order_status = $userInformation[0]->status;

        return view('admin.orders.order-detail',[
            'order_id' => $id,
            'userInformation' => $userInformation[0],
            'orderInformation' => $orderInformation[0],
            'order_code' => $order_code,
            'order_date' => $order_date,
            'order_status' => $order_status,
        ]);
    }
    public function showOrderItems(Request $request){
        $order_id = $request->order_id;

        $lang_en = Lang::where('name', 'en')
                        ->get();

        $lang_en_id = $lang_en[0]->lang_id;

        $data = OrderProducts::selectRaw('order_products.quantity, order_products.price as sub_total,
                                        order_products.cargo_price, order_products.unit_price as product_price,
                                        product_images.image_path, product_urls.name, products.sku')
                                ->where('order_products.order_id', $order_id)
                                ->join('products', 'order_products.product_id', '=', 'products.id')
                                ->join('product_images', function ($join){
                                    $join->on('order_products.product_id', '=', 'product_images.product_id')
                                            ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                      FROM product_images
                                                                         JOIN order_products
                                                                            ON order_products.product_id = product_images.product_id
                                                                            GROUP BY order_products.product_id)');
                                })
                                ->join('product_urls', function ($join) use ($lang_en_id){
                                    $join->on('order_products.product_id', '=', 'product_urls.product_id')
                                            ->where('lang_id', $lang_en_id);
                                })
                                ->get();

        $subTotal = $data->sum('sub_total');
        $totalCargoPrice = $data->sum('cargo_price');
        $total = $subTotal + $totalCargoPrice;

        return response()->json([
            'data' => $data,
            'subTotal' => number_format($subTotal, 2 ,',','.'),
            'totalCargoPrice' => number_format($totalCargoPrice, 2 ,',','.'),
            'total' => number_format($total, 2 ,',','.')
        ]);
    }
    public function orderStatusFormSubmit(Request $request){
        $order_status = $request->orderStatus;
        $order_id = $request->orderId;

        Orders::where('id', $order_id)
                ->update([
                    'status' => $order_status
                ]);

        return response()->json([
            'result' => 'Successful'
        ]);
    }
}
