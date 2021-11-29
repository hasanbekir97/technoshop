<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Cart;
use App\Models\Categories;
use App\Models\Favorite;
use App\Models\Lang;
use App\Models\ProductImages;
use App\Models\ProductReviews;
use App\Models\Products;
use App\Models\ProductUrls;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class Product extends Controller
{
    public function index(Request $request){
        return view('admin.products.products');
    }
    public function showProducts(Request $request){
        if($request->ajax()){
            $langData = Lang::where('name', 'en')
                                ->get();

            $lang_id = $langData[0]->lang_id;

            $data = Products::selectRaw('products.id as id, products.sku, products.price as price,
                                        products.stock, products.created_at, product_urls.name, product_images.image_path')
                            ->join('product_urls', function ($join) use ($lang_id){
                                $join->on('products.id', '=', 'product_urls.product_id')
                                        ->where('product_urls.lang_id', $lang_id);
                            })
                            ->join('product_images', function($join){
                                $join->on('products.id', '=', 'product_images.product_id')
                                    ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                    FROM product_images
                                                                                    JOIN products
                                                                                    ON product_images.product_id = products.id
                                                                                    GROUP BY products.id)');
                            })
                            ->get();


            return DataTables::of($data)
                ->addColumn('transaction', function($row){
                    $editButton = '<a class="editButton" href="/admin/update-product/'.$row->id.'" title="Edit">' .
                        '              <i class="fal fa-edit"></i> Edit' .
                        '          </a>';

                    $deleteButton = '<button class="deleteButton" type=button data-id="'.$row->id.'" title="Delete">' .
                        '                <i class="far fa-trash-alt"></i> Delete' .
                        '            </button>';

                    $buttons = $editButton.$deleteButton;

                    return $buttons;
                })
                ->addColumn('image', function ($row) {
                    $image = '<div class="adminProductImgArea">'.
                        '         <img class="adminProductImage" src="/uploads/'.$row->image_path.'">'.
                        '     </div>';

                    return $image;
                })
                ->addColumn('created_at', function($row){
                    $date = Carbon::parse($row->created_at)->format('d.m.Y');

                    return $date;
                })
                ->addColumn('price', function($row){
                    $price = '$ '.strval(number_format($row->price, 2, ',', '.'));

                    return $price;
                })
                ->rawColumns(['transaction', 'created_at', 'image', 'price'])
                ->toJson();

        }
    }
    public function updateProduct($id){
        $lang_en = Lang::where('name', 'en')
                        ->get();
        $lang_tr = Lang::where('name', 'tr')
                        ->get();

        $lang_en_id = $lang_en[0]->lang_id;
        $lang_tr_id = $lang_tr[0]->lang_id;

        $product_urls_en = ProductUrls::query()
                                    ->selectRaw('product_id as product_en_id, name as name_en, description as description_en,
                                                            detail as detail_en')
                                    ->where('lang_id', $lang_en_id)
                                    ->where('product_id', $id);

        $product = Products::selectRaw('products.id, products.brand, products.cat_id, products.old_price,
                                        products.discount_rate, products.price, products.cargo_price,
                                        products.stock, product_images.id as product_images_id, product_images.image_path,
                                        product_urls.name as name_tr, product_urls.description as description_tr,
                                        product_urls.detail as detail_tr, product_en_urls.name_en,
                                        product_en_urls.description_en, product_en_urls.detail_en')
                            ->join('product_urls', function($join) use ($lang_tr_id){
                                $join->on('products.id', '=', 'product_urls.product_id')
                                        ->where('lang_id', $lang_tr_id);
                            })
                            ->join('product_images', function($join){
                                $join->on('products.id', '=', 'product_images.product_id');
                            })
                            ->joinSub($product_urls_en, 'product_en_urls', function ($join){
                                $join->on('products.id', '=', 'product_en_urls.product_en_id');
                            })
                            ->where('products.id', $id)
                            ->get();

        $categories = Categories::selectRaw('cat_id, name')
                                ->where('lang_id', $lang_en_id)
                                ->get();

        $brands = Brands::select('name')
                        ->orderBy('name')
                        ->get();


        return view('admin.products.updateProduct', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
    public function updateProductFormSubmit(Request $request){

        $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'discount_rate' => ['numeric', 'min:0', 'max:100'],
            'discounted_price' => ['numeric', 'min:0'],
            'cargo_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'numeric', 'min:0'],
            'brand' => 'required',
            'category' => 'required',
            'name_en' => 'required',
            'name_tr' => 'required',
            'images.*' => 'mimes:jpg,png,jpeg,gif,svg|max:2048'
        ],
            [
                'name_en' => 'english product name',
                'name_tr' => 'turkish product name',
                'name_en.required' => 'The english product name field is required.',
                'name_tr.required' => 'The turkish product name field is required.'
            ]
        );

        $id = $request->id;
        $price = $request->price;
        $discount_rate = $request->discount_rate;
        $discounted_price = $request->discounted_price;
        $cargo_price = $request->cargo_price;
        $stock = $request->stock;
        $brand = $request->brand;
        $category = $request->category;
        $product_name_en = $request->name_en;
        $description_en = $request->description_en;
        $detail_en = $request->detail_en;
        $product_name_tr = $request->name_tr;
        $description_tr = $request->description_tr;
        $detail_tr = $request->detail_tr;


        function crateSlug($productName, $id){

            // replace non letter or digits by divider
            $slug = preg_replace('~[^\pL\d]+~u', "-", $productName);

            // transliterate
            $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);

            // remove unwanted characters
            $slug = preg_replace('~[^-\w]+~', '', $slug);

            // trim
            $slug = trim($slug, "-");

            // remove duplicate divider
            $slug = preg_replace('~-+~', "-", $slug);

            // lowercase
            $slug = strtolower($slug);

            $slug .= "-";

            $slug .= strval($id);

            return $slug;
        }

        $slug_en = crateSlug($product_name_en, $id);
        $slug_tr = crateSlug($product_name_tr, $id);

        if($request->TotalImages > 0){
            for ($x = 0; $x < $request->TotalImages; $x++){

                if ($request->hasFile('images'.$x)){

                    $file = $request->file('images'.$x);

                    $name = $slug_en;
                    $name .= "-";
                    $name .= strval(time());
                    $name .= "-";
                    $name .= $x + 1;
                    $name .= ".jpg";

                    $file->move(public_path().'/uploads/', $name);

                    $product_image = new ProductImages();
                    $product_image->product_id = $id;
                    $product_image->image_path = $name;
                    $product_image->save();

                }
            }
        }

        Products::where('id', $id)
                ->update([
                    'brand' => $brand,
                    'cat_id' => $category,
                    'old_price' => $price,
                    'discount_rate' => $discount_rate,
                    'price' => $discounted_price,
                    'cargo_price' => $cargo_price,
                    'stock' => $stock
                ]);

        $lang_en_id = Lang::where('name', 'en')
                            ->get();

        $lang_tr_id = Lang::where('name', 'tr')
                            ->get();

        ProductUrls::where('product_id', $id)
                ->where('lang_id', $lang_en_id[0]->lang_id)
                ->update([
                    'slug' => $slug_en,
                    'name' => $product_name_en,
                    'description' => $description_en,
                    'detail' => $detail_en
                ]);

        ProductUrls::where('product_id', $id)
                ->where('lang_id', $lang_tr_id[0]->lang_id)
                ->update([
                    'slug' => $slug_tr,
                    'name' => $product_name_tr,
                    'description' => $description_tr,
                    'detail' => $detail_tr
                ]);

        return response()->json([
            'status' => 'successful'
        ]);

    }
    public function deleteImage(Request $request){
        $productImageId = $request->productImageId;

        $productImage = ProductImages::where('id', $productImageId)
                                    ->get();

        $productImageProductId = $productImage[0]['product_id'];

        $productImageNumber = ProductImages::where('product_id', $productImageProductId)
                                            ->count();

        if($productImageNumber === 1){
            return response()->json(['result' => 'failed']);
        }
        else {
            ProductImages::where('id', $productImageId)
                ->delete();

            $imagePath = 'uploads/' . strval($productImage[0]['image_path']);

            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }

            return response()->json(['result' => 'success']);
        }
    }
    public function deleteProduct(Request $request){
        $product_Id = $request->productId;

        //this area deletes images in product. (start)
        $productImage = ProductImages::where('product_id', $product_Id)
            ->get();

        for ($j=0; $j<count($productImage); $j++){

            $imagePath = 'uploads/'.strval($productImage[$j]['image_path']);

            if(file_exists(public_path($imagePath))){
                unlink(public_path($imagePath));
            }

        }
        //this area deletes images in product. (end)

        Products::where('id', $product_Id)
                ->delete();

        ProductUrls::where('product_id', $product_Id)
                    ->delete();

        ProductImages::where('product_id', $product_Id)
                    ->delete();

        ProductReviews::where('product_id', $product_Id)
                    ->delete();

        Cart::where('product_id', $product_Id)
            ->delete();

        Favorite::where('product_id', $product_Id)
                ->delete();

        return response()->json([
            'status' => 'successful'
        ]);

    }
    public function addProduct(){
        $langData = Lang::where('name', 'en')
                        ->get();

        $lang_id = $langData[0]->lang_id;

        $categories = Categories::selectRaw('cat_id, name')
                                ->where('lang_id', $lang_id)
                                ->get();

        $brands = Brands::select('name')
                        ->get();

        return view('admin.products.addProduct', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
    public function addProductFormSubmit(Request $request){

        $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'discount_rate' => ['numeric', 'min:0', 'max:100'],
            'discounted_price' => ['numeric', 'min:0'],
            'cargo_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'numeric', 'min:0'],
            'brand' => 'required',
            'category' => 'required',
            'name_en' => 'required',
            'name_tr' => 'required',
            'images' => 'required',
            'images.*' => 'mimes:jpg,png,jpeg,gif,svg|max:2048'
        ],
            [
                'name_en' => 'english product name',
                'name_tr' => 'turkish product name',
                'name_en.required' => 'The english product name field is required.',
                'name_tr.required' => 'The turkish product name field is required.'
            ]
        );

        $price = $request->price;
        $discount_rate = $request->discount_rate;
        $discounted_price = $request->discounted_price;
        $cargo_price = $request->cargo_price;
        $stock = $request->stock;
        $brand = $request->brand;
        $category = $request->category;
        $product_name_en = $request->name_en;
        $description_en = $request->description_en;
        $detail_en = $request->detail_en;
        $product_name_tr = $request->name_tr;
        $description_tr = $request->description_tr;
        $detail_tr = $request->detail_tr;


        $sku = strval(rand(10,99)).strval(time());

        $product = new Products();
        $product->sku = $sku;
        $product->brand = $brand;
        $product->cat_id = $category;
        $product->old_price = $price;
        $product->discount_rate = $discount_rate;
        $product->price = $discounted_price;
        $product->cargo_price = $cargo_price;
        $product->stock = $stock;
        $product->star_avg = 0.00;
        $product->star_number = 0;
        $product->save();

        $product_id = $product->id;

        function crateSlug($productName, $product_id){

            // replace non letter or digits by divider
            $slug = preg_replace('~[^\pL\d]+~u', "-", $productName);

            // transliterate
            $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);

            // remove unwanted characters
            $slug = preg_replace('~[^-\w]+~', '', $slug);

            // trim
            $slug = trim($slug, "-");

            // remove duplicate divider
            $slug = preg_replace('~-+~', "-", $slug);

            // lowercase
            $slug = strtolower($slug);

            $slug .= "-";

            $slug .= strval($product_id);

            return $slug;
        }

        $slug_en = crateSlug($product_name_en, $product_id);
        $slug_tr = crateSlug($product_name_tr, $product_id);

        $lang_en_id = Lang::where('name', 'en')
                        ->get();

        $lang_tr_id = Lang::where('name', 'tr')
                        ->get();

        //this store as english in database
        $product_urls = new ProductUrls();
        $product_urls->lang_id = $lang_en_id[0]->lang_id;
        $product_urls->product_id = $product_id;
        $product_urls->slug = $slug_en;
        $product_urls->name = $product_name_en;
        $product_urls->description = $description_en;
        $product_urls->detail = $detail_en;
        $product_urls->save();

        //this store as turkish in database
        $product_urls = new ProductUrls();
        $product_urls->lang_id = $lang_tr_id[0]->lang_id;
        $product_urls->product_id = $product_id;
        $product_urls->slug = $slug_tr;
        $product_urls->name = $product_name_tr;
        $product_urls->description = $description_tr;
        $product_urls->detail = $detail_tr;
        $product_urls->save();


        if($request->TotalImages > 0){
            for ($x = 0; $x < $request->TotalImages; $x++){

                if ($request->hasFile('images'.$x)){

                    $file = $request->file('images'.$x);

                    $name = $slug_en;
                    $name .= "-";
                    $name .= strval(time());
                    $name .= "-";
                    $name .= $x + 1;
                    $name .= ".jpg";

                    $file->move(public_path().'/uploads/', $name);

                    $product_image = new ProductImages();
                    $product_image->product_id = $product_id;
                    $product_image->image_path = $name;
                    $product_image->save();

                }
            }
        }

        return response()->json([
            'status' => 'successful'
        ]);

    }
}
