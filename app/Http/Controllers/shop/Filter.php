<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brands;

class Filter extends Controller
{
    public function brandAll(Request $request){
        $data = $request->all();

        $lang = $data['lang'];
        $brands = Brands::selectRaw('id, name')
                        ->orderBy('name', 'ASC')
                        ->get();

        return response()->json([
            'lang' => $lang,
            'filter' => $brands
        ], 200);

    }
    public function categoryAll(Request $request){
        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
                        ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        $data = Categories::selectRaw('id, name')
                        ->where('lang_id', $lang_id)
                        ->orderBy('id', 'ASC')
                        ->get();

        return response()->json([
            'data' => $data
        ], 200);

    }
    public function search(Request $request){
        $search = $request->search;
        $lang = $request->lang;

        if($lang === 'en')
            $url = '/';
        else
            $url = '/tr';

        if(isset($search))
            $url .= '?search='.$search;

        return response()->json([
            'url' => $url
        ],200);
    }
    public function category(Request $request){
        $category_id = $request->categoryId;
        $lang = $request->lang;

        $langData = Lang::where('name', $lang)
                            ->get('lang_id');

        $lang_id = $langData[0]->lang_id;

        if($lang === 'en')
            $url = '/';
        else
            $url = '/tr';

        $data = Categories::where('cat_id', $category_id)
                            ->where('lang_id', $lang_id)
                            ->get();

        $url .= '?cat='.$data[0]->cat_id;

        return response()->json([
            'url' => $url
        ],200);
    }
    public function brand(Request $request){
        $brand_id = $request->brandId;
        $brand_status = $request->brandStatus;
        $filter = $request->filter;
        $lang = $request->lang;

        if($lang === 'en')
            $url = '/';
        else
            $url = '/tr';

        if(empty($filter))
            $url .= '?brand='.$brand_id;

        if(isset($filter['search']))
            $url .= '?search='.$filter['search'];
        else if(isset($filter['cat']))
            $url .= '?cat='.$filter['cat'];

        $brandIssetControl = false;
        if(isset($filter)) {
            if (isset($filter['brand'])) {
                if($brand_status === "true") {
                    if (isset($filter['search']) || isset($filter['cat']))
                        $url .= '&brand=' . $filter['brand'] . ',' . $brand_id;
                    else {
                        $url .= '?brand=' . $filter['brand'] . ',' . $brand_id;
                    }
                }
                else if($brand_status === "false") {
                    $tempUrl = $url;
                    if (isset($filter['search']) || isset($filter['cat']))
                        $tempUrl .= '&brand=';
                    else {
                        $tempUrl .= '?brand=';
                    }
                    $cnt = 0;
                    foreach(explode(',', $filter['brand']) as $row){
                        if($row !== strval($brand_id)) {
                            if($cnt === 0)
                                $tempUrl .= $row;
                            else
                                $tempUrl .= ','.$row;
                            $cnt ++;
                        }
                    }
                    if($cnt !== 0){
                        $url = $tempUrl;
                    }
                    else{
                        $brandIssetControl = true;
                    }
                }
            }
            else if (empty($filter['brand'])) {
                if(empty($filter) || (empty($filter['search']) && empty($filter['cat'])))
                    $url .= '?brand=' . $brand_id;
                else
                    $url .= '&brand=' . $brand_id;
            }
        }

        if(isset($filter['sort'])) {
            if (empty($filter['search']) && empty($filter['cat']) && (empty($filter['brand']) || $brandIssetControl === true) && $brand_status === 'false')
                $url .= '?sort=' . $filter['sort'];
            else
                $url .= '&sort=' . $filter['sort'];
        }
        if(isset($filter['price'])) {
            if(empty($filter['search']) && empty($filter['cat']) && (empty($filter['brand']) || $brandIssetControl === true) && empty($filter['sort']) && $brand_status === false)
                $url .= '?price=' . $filter['price'];
            else
                $url .= '&price=' . $filter['price'];
        }

        return response()->json([
            'url' => $url
        ],200);
    }
    public function sort(Request $request){
        $filter = $request->filter;
        $sortOption = $request->sortOption;
        $lang = $request->lang;

        if($lang === 'en')
            $url = '/';
        else
            $url = '/tr';

        if(empty($filter))
            $url .= '?sort='.$sortOption;

        if(isset($filter['search']))
            $url .= '?search='.$filter['search'];
        else if(isset($filter['cat']))
            $url .= '?cat='.$filter['cat'];

        if(isset($filter['brand'])) {
            if(isset($filter['search']) || isset($filter['cat']))
                $url .= '&brand=' . $filter['brand'];
            else
                $url .= '?brand=' . $filter['brand'];
        }

        if(isset($filter)) {
            if (isset($filter['search']) || isset($filter['cat']) || isset($filter['brand']))
                $url .= '&sort='.$sortOption;
            else {
                $url .= '?sort='.$sortOption;
            }
        }

        if(isset($filter['price']))
            $url .= '&price='.$filter['price'];

        return response()->json([
            'url' => $url
        ],200);
    }
    public function price(Request $request){
        $filter = $request->filter;
        $min_price = $request->minPrice;
        $max_price = $request->maxPrice;
        $lang = $request->lang;

        if($min_price === null)
            $min_price = '0';
        if($max_price === null)
            $max_price = '*';

        if($lang === 'en')
            $url = '/';
        else
            $url = '/tr';

        if(empty($filter))
            $url .= '?price='.$min_price.'-'.$max_price;

        if(isset($filter['search']))
            $url .= '?search='.$filter['search'];
        else if(isset($filter['cat']))
            $url .= '?cat='.$filter['cat'];

        if(isset($filter['brand'])) {
            if(isset($filter['search']) || isset($filter['cat']))
                $url .= '&brand=' . $filter['brand'];
            else
                $url .= '?brand=' . $filter['brand'];
        }

        if(isset($filter['sort'])) {
            if(isset($filter['search']) || isset($filter['cat']) || isset($filter['brand']))
                $url .= '&sort='.$filter['sort'];
            else
                $url .= '?sort='.$filter['sort'];
        }

        if(isset($filter)) {
            if (isset($filter['search']) || isset($filter['cat']) || isset($filter['brand']) || isset($filter['sort']))
                $url .= '&price='.$min_price.'-'.$max_price;
            else {
                $url .= '?price='.$min_price.'-'.$max_price;;
            }
        }


        return response()->json([
            'url' => $url
        ],200);
    }
}
