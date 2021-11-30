<?php

use App\Http\Controllers\user\Api;
use Illuminate\Support\Facades\Route;

//shop
use App\Http\Controllers\shop\Filter;
use App\Http\Controllers\shop\AllProduct;
use App\Http\Controllers\shop\ProductDetail;
use App\Http\Controllers\shop\Carts;
use App\Http\Controllers\shop\Favorites;
use App\Http\Controllers\shop\Order;
use App\Http\Controllers\shop\Shop;

//user
use App\Http\Controllers\user\User;
use App\Http\Controllers\shop\Comments;
use App\Http\Controllers\user\ForgotPassword;
use App\Http\Controllers\user\VerifyEmail;
use Illuminate\Support\Facades\Auth;

//pages
use App\Http\Controllers\pages\Contacts;

//admin
use App\Http\Controllers\admin\Dashboard;
use App\Http\Controllers\admin\Login;
use App\Http\Controllers\admin\Product;
use App\Http\Controllers\admin\Category;
use App\Http\Controllers\admin\Brand;
use App\Http\Controllers\admin\Users;
use App\Http\Controllers\admin\ContactAdmin;
use App\Http\Controllers\admin\OrderAdmin;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localize']], function () {

    //index
    Route::get(LaravelLocalization::transRoute('routes./'), [Shop::class, "index"])->name('shop.products');

    //user product detail
    Route::get(LaravelLocalization::transRoute('routes.product-detail'), [ProductDetail::class, "index"]);

    //user cart processes
    Route::get(LaravelLocalization::transRoute('routes.cart'), [Carts::class, "index"])->name('cart');

    //user payment processes
    Route::middleware(['auth:sanctum', 'verified', 'isEmailVerified'])->group(function () {

        Route::get(LaravelLocalization::transRoute('routes.payment'), [Order::class, "index"])->name('payment');
        Route::get(LaravelLocalization::transRoute('routes.order-result'), [Order::class, "result"])->name('order-result');

    });

    //user account page
    Route::get(LaravelLocalization::transRoute('routes.my-account'), [User::class, "index"])->name('profile.user-account');

    //contact processes
    Route::get(LaravelLocalization::transRoute('routes.contact'), [Contacts::class, 'index'])->name('pages.contacts');

    //user forgot password processes
    Route::get(LaravelLocalization::transRoute('routes.forgot-password'), [ForgotPassword::class, 'forgotPassword'])->name('forgot-password');
    Route::get(LaravelLocalization::transRoute('routes.reset-password'), [ForgotPassword::class, 'resetPassword'])->name('reset-password');
    Route::post(LaravelLocalization::transRoute('routes.forgot-password'), [ForgotPassword::class, 'forgetPasswordFormSubmit'])->name('forgot-password.post');
    Route::post(LaravelLocalization::transRoute('routes.reset-password-submit'), [ForgotPassword::class, 'resetPasswordFormSubmit'])->name('reset-password.post');

    //user verify email processes
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {

        Route::get(LaravelLocalization::transRoute('routes.email-verify'), [VerifyEmail::class, 'index'])->name('email-verify');
        Route::post(LaravelLocalization::transRoute('routes.verification-notification'), [VerifyEmail::class, 'sendVerificationEmail'])->name('verification.send');
        Route::get(LaravelLocalization::transRoute('routes.verification-verify'), [VerifyEmail::class, 'verificationVerify'])->name('verification.verify');

    });
});

//search, category, filter and sorting processes
Route::post('ajax/search', [Filter::class, "search"]);
Route::post('ajax/brand', [Filter::class, "brand"]);
Route::post('ajax/price', [Filter::class, "price"]);
Route::post('ajax/sort', [Filter::class, "sort"]);
Route::post('ajax/category', [Filter::class, "category"]);

//list brands and products in shop page
Route::post('ajax/brands', [Filter::class, "brandAll"]);
Route::post('ajax/categories', [Filter::class, "categoryAll"]);
Route::post('ajax/products', [AllProduct::class, "productAll"]);

//user cart processes
Route::post('ajax/addCart', [Carts::class, "addCart"]);
Route::post('ajax/showCartNumber', [Carts::class, "showCartNumber"]);
Route::post('ajax/showCart', [Carts::class, "showCart"]);
Route::post('ajax/updateCart', [Carts::class, "updateCart"]);
Route::post('ajax/deleteCart', [Carts::class, "deleteCart"]);
Route::post('ajax/deleteAllCart', [Carts::class, "deleteAllCart"]);

//user payment processes
Route::middleware(['auth:sanctum', 'verified', 'isEmailVerified'])->group(function () {

    Route::post('ajax/paymentAddressFormSubmit', [Order::class, "paymentAddressSubmitForm"]);

});

//user favorite processes
Route::post('ajax/showFavoriteStatus', [Favorites::class, "showFavoriteStatus"]);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::post('ajax/addRemoveFavorite', [Favorites::class, "addRemoveFavorite"]);
    Route::post('ajax/showFavorite', [Favorites::class, "showFavorite"]);
    Route::post('ajax/deleteFavorite', [Favorites::class, "deleteFavorite"]);
    Route::post('ajax/deleteAllFavorite', [Favorites::class, "deleteAllFavorite"]);

});

//user comment processes
Route::post('ajax/comments', [Comments::class, "showComments"]);
Route::post('ajax/calculateStarAvg', [Comments::class, "calculateStarAvg"]);

//user account page
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::post('ajax/addressFormSubmit', [User::class, "addressFormSubmit"]);

    Route::post('ajax/showOrder', [User::class, "showOrder"]);
    Route::post('ajax/userOrderInformation', [User::class, "showOrderInformation"]);
    Route::post('ajax/reviewFormSubmit', [User::class, "reviewFormSubmit"]);

    Route::post('ajax/showReview', [User::class, "showReview"]);
    Route::post('ajax/userReview', [User::class, "userReview"]);

});

//api processes
Route::middleware(['isEmailVerified'])->group(function () {

    Route::post('ajax/generateApiKey', [Api::class, "generateApiKey"]);
    Route::post('ajax/showApiKey', [Api::class, "showApiKey"]);

});

//contact processes
Route::post('ajax/contactFormSubmit', [Contacts::class, 'contactFormSubmit']);

//user verify email processes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::post('ajax/showEmailVerificationResult', [VerifyEmail::class, 'showEmailVerificationResult']);

});

//user stock control process
Route::post('/ajax/stockControl', [ProductDetail::class, 'stockControl']);





//admin panel processes (start)
//#######################################################################################################################################

//admin login
Route::get('/admin', function (){ return redirect(route('admin.login')); });
Route::get('/admin/login', [Login::class, "index"])->name('admin.login');
Route::post('/admin/loginFormSubmit', [Login::class, "login"])->name('admin.loginSubmit');

//admin logout
Route::get('/admin/logoutSubmit', [Login::class, "logout"])->name('admin.logoutSubmit');


Route::middleware(['authAdmin'])->group( function () {

    //admin dashboard
    Route::get('/admin/dashboard', [Dashboard::class, "index"])->name('admin.dashboard');

    //admin products
    Route::get('/admin/products', [Product::class, "index"])->name('admin.products');
    Route::post('/admin/showProducts', [Product::class, "showProducts"]);
    Route::get('/admin/add-product', [Product::class, "addProduct"])->name('admin.addProduct');
    Route::post('/admin/addProductFormSubmit', [Product::class, "addProductFormSubmit"]);
    Route::get('/admin/update-product/{id}', [Product::class, "updateProduct"]);
    Route::post('/admin/updateProductFormSubmit', [Product::class, "updateProductFormSubmit"]);
    Route::post('/admin/deleteProduct', [Product::class, "deleteProduct"]);
    Route::post('/admin/deleteImage', [Product::class, "deleteImage"]);

    //admin categories
    Route::get('/admin/categories', [Category::class, "index"])->name('admin.categories');
    Route::post('/admin/showCategories', [Category::class, "showCategories"]);
    Route::get('/admin/add-category', [Category::class, "addCategory"])->name('admin.addCategory');
    Route::post('/admin/addCategoryFormSubmit', [Category::class, "addCategoryFormSubmit"]);
    Route::get('/admin/update-category/{id}', [Category::class, "updateCategory"]);
    Route::post('/admin/updateCategoryFormSubmit', [Category::class, "updateCategoryFormSubmit"]);
    Route::post('/admin/deleteCategory', [Category::class, "deleteCategory"]);

    //admin brands
    Route::get('/admin/brands', [Brand::class, "index"])->name('admin.brands');
    Route::post('/admin/showBrands', [Brand::class, "showBrands"]);
    Route::get('/admin/add-brand', [Brand::class, "addBrand"])->name('admin.addBrand');
    Route::post('/admin/addBrandFormSubmit', [Brand::class, "addBrandFormSubmit"]);
    Route::get('/admin/update-brand/{id}', [Brand::class, "updateBrand"]);
    Route::post('/admin/updateBrandFormSubmit', [Brand::class, "updateBrandFormSubmit"]);
    Route::post('/admin/deleteBrand', [Brand::class, "deleteBrand"]);

    //admin users
    Route::get('/admin/users', [Users::class, "index"])->name('admin.users');
    Route::post('/admin/showUsers', [Users::class, "showUsers"]);
    Route::get('/admin/user-detail/{id}', [Users::class, "userDetail"]);
    Route::post('/admin/deleteUser', [Users::class, "deleteUser"]);

    //admin contacts
    Route::get('/admin/contacts', [ContactAdmin::class, "index"])->name('admin.contacts');
    Route::post('/admin/showContacts', [ContactAdmin::class, "showContacts"]);
    Route::get('/admin/contact-detail/{id}', [ContactAdmin::class, "contactDetail"]);
    Route::post('/admin/deleteContact', [ContactAdmin::class, "deleteContact"]);

    //admin orders
    Route::get('/admin/orders', [OrderAdmin::class, "index"])->name('admin.orders');
    Route::post('/admin/showOrders', [OrderAdmin::class, "showOrders"]);
    Route::get('/admin/order-detail/{id}', [OrderAdmin::class, "orderDetail"]);
    Route::post('/admin/showOrderItems', [OrderAdmin::class, "showOrderItems"]);
    Route::post('/admin/orderStatusFormSubmit', [OrderAdmin::class, "orderStatusFormSubmit"]);

});

//#######################################################################################################################################
//admin panel processes (end)


