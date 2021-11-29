<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Brands;
use App\Models\Favorite;
use App\Models\ProductImages;
use App\Models\ProductReviews;
use App\Models\Products;
use App\Models\ProductUrls;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Brand extends Controller
{
    public function index(Request $request){
        return view('admin.brands.brands');
    }
    public function showBrands(Request $request){
        if($request->ajax()){
            $data = Brands::get();

            return DataTables::of($data)
                            ->addColumn('transaction', function($row){
                                $editButton = '<a class="editButton" href="/admin/update-brand/'.$row->id.'" title="Edit">' .
                                    '              <i class="fal fa-edit"></i> Edit' .
                                    '          </a>';

                                $deleteButton = '<button class="deleteButton" type=button data-id="'.$row->id.'" title="Delete">' .
                                    '                <i class="far fa-trash-alt"></i> Delete' .
                                    '            </button>';

                                $buttons = $editButton.$deleteButton;

                                return $buttons;
                            })
                            ->addColumn('created_at', function($row){
                                $date = Carbon::parse($row->created_at)->format('d.m.Y');

                                return $date;
                            })
                            ->rawColumns(['transaction', 'created_at'])
                            ->toJson();

        }
    }
    public function updateBrand($id){
        $brand = Brands::selectRaw('id, name, created_at')
                        ->where('id', $id)
                        ->get();

        return view('admin.brands.updateBrand', [
            'brand' => $brand[0]
        ]);
    }
    public function updateBrandFormSubmit(Request $request){

        $request->validate([
            'name' => 'required',
        ],
            [
                'name' => 'brand name',
                'name.required' => 'The brand name field is required.'
            ]
        );

        $id = $request->id;
        $brand_name = $request->name;

        $oldBrandName = Brands::where('id', $id)
                            ->get();

        Brands::where('id', $id)
            ->update([
                'name' => $brand_name
            ]);


        Products::where('brand', $oldBrandName[0]->name)
            ->update([
                'brand' => $brand_name
            ]);

        return response()->json([
            'status' => 'successful'
        ]);
    }
    public function deleteBrand(Request $request){
        $brand_Id = $request->brandId;

        $brandName = Brands::where('id', $brand_Id)
                                ->get();

        Brands::where('id', $brand_Id)
                ->delete();

        $products = Products::where('brand', $brandName[0]->name)
            ->get();

        foreach($products as $product) {

            $product_Id = $product['id'];

            //this area deletes images in product. (start)
            $productImage = ProductImages::where('product_id', $product_Id)
                ->get();

            for ($j = 0; $j < count($productImage); $j++) {

                $imagePath = 'uploads/' . strval($productImage[$j]['image_path']);

                if (file_exists(public_path($imagePath))) {
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

        }

        return response()->json([
            'status' => 'successful'
        ]);
    }
    public function addBrand(){
        return view('admin.brands.addBrand');
    }
    public function addBrandFormSubmit(Request $request){

        $request->validate([
            'name' => 'required'
        ],
            [
                'name' => 'brand name',
                'name.required' => 'The brand name field is required.'
            ]
        );

        $brand_name = $request->name;


        $product = new Brands();
        $product->name = $brand_name;
        $product->save();

        return response()->json([
            'status' => 'successful'
        ]);
    }
}
