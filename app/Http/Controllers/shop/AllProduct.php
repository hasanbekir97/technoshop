<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\ProductUrls;
use App\Models\Cart;
use App\Models\ProductImages;
use App\Models\ProductReviews;
use App\Models\Brands;

class AllProduct extends Controller
{
    public function productAll(Request $request){
        $pageNum = $request->pageNum;
        $filter = $request->filter;
        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
                        ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        $skip = $pageNum * 40;

        if(isset($filter)){

            if(isset($filter['search']))
                $search_word = strval($filter['search']);
            else{
                $search_word = '';
            }

            if(isset($filter['cat']))
                $cat_id = $filter['cat'];
            else{
                $cat_id = '';
            }

            if(isset($filter['brand'])) {
                $search_brand = array();
                foreach(explode(',', $filter['brand']) as $row){
                    array_push($search_brand, $row);
                }
            }
            else{
                $search_brand = '';
            }

            if(isset($filter['sort'])) {
                $sort = $filter['sort'];
            }
            else{
                $sort = 'id';
            }

            if(isset($filter['price'])) {
                $priceInterval = array();
                foreach(explode('-', $filter['price']) as $row){
                    array_push($priceInterval, $row);
                }
            }

            //search query
            $search_in_key = array('products.brand', 'products.cat_id', 'product_urls.name', 'product_urls.description', 'product_urls.detail');
            $counter = 0;
            $productSearches = products::query()
                                        ->selectRaw('products.id as product_id2');
            if(isset($search_word) && $search_word !== '') {
                $productSearches = Products::query()
                                            ->selectRaw('products.id as product_id2, products.old_price as old_price2, products.price as price2,
                                                                    products.cat_id as cat_id2, products.discount_rate as discount_rate2,
                                                                    product_images.image_path as image_path2, product_urls.slug as slug2,
                                                                    product_urls.name as name2, products.star_avg as star_avg2,
                                                                    products.star_number as star_number2')
                                            ->join('product_urls', function ($join) use ($lang_id){
                                                $join->on('products.id', '=', 'product_urls.product_id')
                                                        ->where('product_urls.lang_id', $lang_id);
                                            })
                                            ->join('product_images', function ($join) {
                                                $join->on('products.id', '=', 'product_images.product_id')
                                                    ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                          FROM product_images
                                                                                             JOIN products
                                                                                                ON products.id = product_images.product_id
                                                                                                GROUP BY products.id)');
                                            });

                foreach ($search_in_key as $row) {
                    if ($counter === 0)
                        $productSearches = $productSearches->where($row, 'ILIKE', '%' . $search_word . '%');
                    else
                        $productSearches = $productSearches->orWhere($row, 'ILIKE', '%' . $search_word . '%');

                    $counter++;
                }
            }


            //brand query
            $counter = 0;
            $productBrands = products::query()
                                        ->selectRaw('products.id as product_id3');
            if(isset($search_brand) && $search_brand !== '') {
                $productBrands = Products::query()
                                        ->selectRaw('products.id as product_id3, products.old_price as old_price3, products.price as price3,
                                                    products.cat_id as cat_id3, products.discount_rate as discount_rate3, product_images.image_path as image_path3,
                                                    product_urls.slug as slug3, product_urls.name as name3, products.star_avg as star_avg3,
                                                    products.star_number as star_number3')
                                        ->join('product_urls', function ($join) use ($lang_id){
                                            $join->on('products.id', '=', 'product_urls.product_id')
                                                ->where('product_urls.lang_id', $lang_id);
                                        })
                                        ->join('product_images', function ($join) {
                                            $join->on('products.id', '=', 'product_images.product_id')
                                                ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                              FROM product_images
                                                                                                 JOIN products
                                                                                                    ON products.id = product_images.product_id
                                                                                                    GROUP BY products.id)');
                                        });

                foreach ($search_brand as $row) {
                    $brandName = Brands::where('id', (int)$row)->get();
                    if (isset($brandName[0])) {
                        if ($counter === 0)
                            $productBrands = $productBrands->where('products.brand', '=', $brandName[0]->name);
                        else
                            $productBrands = $productBrands->orWhere('products.brand', '=', $brandName[0]->name);

                        $counter++;
                    }
                }
            }


            $products = Products::query()
                                ->selectRaw('products.id as product_id, products.old_price, products.price,
                                                products.cat_id, products.discount_rate, product_images.image_path,
                                                product_urls.slug, product_urls.name, products.star_avg, products.star_number')
                                ->join('product_urls', function ($join) use ($lang_id){
                                    $join->on('products.id', '=', 'product_urls.product_id')
                                        ->where('product_urls.lang_id', $lang_id);
                                })
                                ->join('product_images', function ($join) {
                                    $join->on('products.id', '=', 'product_images.product_id')
                                        ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                          FROM product_images
                                                                                             JOIN products
                                                                                                ON products.id = product_images.product_id
                                                                                                GROUP BY products.id)');
                                })
                                ->joinSub($productSearches, 'product_search_results', function($join) {
                                    $join->on('products.id', '=', 'product_search_results.product_id2');
                                })
                                ->joinSub($productBrands, 'product_brand_results', function($join) {
                                    $join->on('products.id', '=', 'product_brand_results.product_id3');
                                });

            //price query
            if(isset($priceInterval) && $priceInterval !== '') {

                $products = $products->where('products.price', '>', (int)$priceInterval[0]);
                if($priceInterval[1] !== '*')
                    $products = $products->where('products.price', '<', (int)$priceInterval[1]);
            }

            //category query
            if(isset($cat_id) && $cat_id !== '') {
                $products = $products->where('products.cat_id', $cat_id);
            }

            //sort query
            if($sort === 'id' || $sort === 'featured'){
                $products = $products->orderByRaw('products.id ASC');
            }
            else if($sort === 'price_asc'){
                $products = $products->orderByRaw('products.price ASC');
            }
            else if($sort === 'price_desc'){
                $products = $products->orderByRaw('products.price DESC');
            }
            else if($sort === 'most_recent'){
                $products = $products->orderByRaw('products.created_at DESC');
            }
            else if($sort === 'most_rated'){
                $products = $products->orderByRaw('products.star_number DESC');
            }

            $uploadLimitNumber = $products->count();

            $products = $products->offset($skip)
                    ->limit(40)
                    ->get();


            $uploadedProductNumber = $skip + count($products);

        }
        else {
            $products = Products::selectRaw('products.id as product_id, products.old_price, products.price,
                                        products.discount_rate, products.price, product_images.image_path,
                                        product_urls.slug, product_urls.name, products.star_avg, products.star_number')
                                        ->join('product_urls', function ($join) use ($lang_id) {
                                            $join->on('products.id', '=', 'product_urls.product_id')
                                                ->where('product_urls.lang_id', $lang_id);
                                        })
                                        ->join('product_images', function ($join) {
                                            $join->on('products.id', '=', 'product_images.product_id')
                                                ->whereRaw('product_images.id IN (SELECT MIN(product_images.id)
                                                                                              FROM product_images
                                                                                                 JOIN products
                                                                                                    ON products.id = product_images.product_id
                                                                                                    GROUP BY products.id)');
                                        })
                                        ->offset($skip)
                                        ->limit(40)
                                        ->get();

            $uploadedProductNumber = $skip + count($products);
            $uploadLimitNumber = Products::count();
        }

        return response()->json([
            'products' => $products,
            'uploadLimitNumber' => $uploadLimitNumber,
            'uploadedProductNumber' => $uploadedProductNumber
        ], 200);

    }
}
