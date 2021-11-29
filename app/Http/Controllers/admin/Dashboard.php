<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Lang;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index(){
        $orderNumber = Orders::count();
        $productNumber = Products::count();
        $contactNumber = Contact::count();
        $userNumber = User::count();

        return view('admin.dashboard', [
            'order_number' => $orderNumber,
            'product_number' => $productNumber,
            'contact_number' => $contactNumber,
            'user_number' => $userNumber
        ]);
    }
}
