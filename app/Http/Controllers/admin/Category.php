<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
use Yajra\DataTables\Facades\DataTables;

class Category extends Controller
{
    public function index(Request $request){
        return view('admin.categories.categories');
    }
    public function showCategories(Request $request){
        if($request->ajax()){
            $langData = Lang::where('name', 'en')
                ->get();

            $lang_id = $langData[0]->lang_id;

            $data = Categories::where('lang_id', $lang_id)
                                ->get();

            return DataTables::of($data)
                ->addColumn('transaction', function($row){
                    $editButton = '<a class="editButton" href="/admin/update-category/'.$row->id.'" title="Edit">' .
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
    public function updateCategory($id){
        $lang_en = Lang::where('name', 'en')
                        ->get();
        $lang_tr = Lang::where('name', 'tr')
                        ->get();

        $lang_en_id = $lang_en[0]->lang_id;
        $lang_tr_id = $lang_tr[0]->lang_id;

        $category_en = Categories::selectRaw('id, name, created_at')
                            ->where('lang_id', $lang_en_id)
                            ->where('cat_id', $id)
                            ->get();

        $category_tr = Categories::selectRaw('id, name, created_at')
                            ->where('lang_id', $lang_tr_id)
                            ->where('cat_id', $id)
                            ->get();

        return view('admin.categories.updateCategory', [
            'cat_id' => $id,
            'category_en' => $category_en[0]->name,
            'category_tr' => $category_tr[0]->name
        ]);
    }
    public function updateCategoryFormSubmit(Request $request){

        $request->validate([
            'name_en' => 'required',
            'name_tr' => 'required',
        ],
            [
                'name_en' => 'english category name',
                'name_en.required' => 'English category name field is required.',
                'name_tr' => 'english category name',
                'name_tr.required' => 'English category name field is required.'
            ]
        );

        $id = $request->id;
        $category_en_name = $request->name_en;
        $category_tr_name = $request->name_tr;

        $lang_en = Lang::where('name', 'en')
                        ->get();
        $lang_tr = Lang::where('name', 'tr')
                        ->get();

        $lang_en_id = $lang_en[0]->lang_id;
        $lang_tr_id = $lang_tr[0]->lang_id;

        Categories::where('cat_id', $id)
                    ->where('lang_id', $lang_en_id)
                    ->update([
                        'name' => $category_en_name
                    ]);

        Categories::where('cat_id', $id)
                    ->where('lang_id', $lang_tr_id)
                    ->update([
                        'name' => $category_tr_name
                    ]);

        return response()->json([
            'status' => 'successful'
        ]);
    }
    public function deleteCategory(Request $request){
        $category_Id = $request->categoryId;

        Categories::where('cat_id', $category_Id)
                    ->delete();

        $products = Products::where('cat_id', $category_Id)
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

            ProductUrls::where('product_Id', $product_Id)
                ->delete();

            ProductImages::where('product_Id', $product_Id)
                ->delete();

            ProductReviews::where('product_Id', $product_Id)
                ->delete();

            Cart::where('product_Id', $product_Id)
                ->delete();

            Favorite::where('product_Id', $product_Id)
                ->delete();

        }

        return response()->json([
            'status' => 'successful'
        ]);
    }
    public function addCategory(){
        return view('admin.categories.addCategory');
    }
    public function addCategoryFormSubmit(Request $request){

        $request->validate([
            'name_en' => 'required',
            'name_tr' => 'required'
        ],
            [
                'name_en' => 'english product name',
                'name_en.required' => 'The english product name field is required.',
                'name_tr' => 'turkish product name',
                'name_tr.required' => 'The turkish product name field is required.'
            ]
        );

        $category_en_name = $request->name_en;
        $category_tr_name = $request->name_tr;

        $lang_en = Lang::where('name', 'en')
                    ->get();
        $lang_tr = Lang::where('name', 'tr')
                    ->get();

        $lang_en_id = $lang_en[0]->lang_id;
        $lang_tr_id = $lang_tr[0]->lang_id;

        $category = new Categories();
        $category->lang_id = $lang_en_id;
        $category->name = $category_en_name;
        $category->save();

        Categories::where('id', $category->id)
                    ->update([
                        'cat_id' => $category->id
                    ]);

        $cat_id = $category->id;

        $category = new Categories();
        $category->lang_id = $lang_tr_id;
        $category->cat_id = $cat_id;
        $category->name = $category_tr_name;
        $category->save();

        return response()->json([
            'status' => 'successful'
        ]);
    }
}
