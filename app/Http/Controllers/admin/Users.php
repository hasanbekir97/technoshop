<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Orders;
use App\Models\OrderInformations;
use App\Models\OrderProducts;
use App\Models\User;
use App\Models\UserInformations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Users extends Controller
{
    public function index(Request $request){
        return view('admin.users.users');
    }
    public function showUsers(Request $request){
        if($request->ajax()){
            $data = User::get();

            return DataTables::of($data)
                ->addColumn('transaction', function($row){
                    $viewButton = '<a class="viewButton" href="/admin/user-detail/'.$row->id.'" title="View User">' .
                        '              <i class="fal fa-eye"></i> View Profile' .
                        '          </a>';

                    return $viewButton;
                })
                ->addColumn('created_at', function($row){
                    $date = Carbon::parse($row->created_at)->format('d.m.Y');

                    return $date;
                })
                ->rawColumns(['transaction', 'created_at'])
                ->toJson();

        }
    }
    public function userDetail($id){
        $user = User::selectRaw('id, name, email, created_at')
                        ->where('id', $id)
                        ->get();

        $userInformation = UserInformations::selectRaw('id, phone, country, city, county, address')
                                    ->where('user_id', $id)
                                    ->get();

        return view('admin.users.user-detail', [
            'user' => $user[0],
            'userInformation' => $userInformation
        ]);
    }
    public function deleteUser(Request $request){
        $user_id = $request->user_id;

        Cart::where('user_id', $user_id)
            ->delete();

        Favorite::where('user_id', $user_id)
            ->delete();

        Orders::where('orders.user_id', $user_id)
                ->join('order_informations', function ($join){
                    $join->on('orders.id', '=', 'order_informations.order_id');
                })
                ->join('order_products', function ($join){
                    $join->on('orders.id', '=', 'order_products.order_id');
                })
                ->delete();

        User::where('id', $user_id)
            ->delete();

        UserInformations::where('user_id', $user_id)
            ->delete();

        return response()->json([
            'status' => 'successful'
        ]);
    }
}
