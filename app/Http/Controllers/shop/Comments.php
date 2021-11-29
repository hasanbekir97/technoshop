<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\ProductReviews;

class Comments extends Controller
{
    public function showComments(Request $request){

        $product_id = $request->productId;
        $pageNum = $request->pageNum;

        $skip = $pageNum * 10;

        $comments = ProductReviews::selectRaw('users.name as user_name, product_reviews.id as review_id, product_reviews.star, product_reviews.comment, product_reviews.created_at')
                                    ->where('product_id', $product_id)
                                    ->where('comment', '!=', '')
                                    ->join('users', function($join) {
                                        $join->on('product_reviews.user_id', '=', 'users.id');
                                    })
                                    ->orderByRaw('created_at DESC')
                                    ->offset($skip)
                                    ->limit(10)
                                    ->get();

        $uploadedCommentNumber = $skip + count($comments);
        $uploadLimitNumber = ProductReviews::where('comment', '!=', '')
                                            ->count();

        return response()->json([
            'comments' => $comments,
            'uploadLimitNumber' => $uploadLimitNumber,
            'uploadedCommentNumber' => $uploadedCommentNumber
        ], 200);
    }
    public function calculateStarAvg(Request $request){

        $product_id = $request->productId;

        $star_5_Number = ProductReviews::where('product_id', $product_id)
            ->where('star', 5)
            ->count();

        $star_4_Number = ProductReviews::where('product_id', $product_id)
            ->where('star', 4)
            ->count();

        $star_3_Number = ProductReviews::where('product_id', $product_id)
            ->where('star', 3)
            ->count();

        $star_2_Number = ProductReviews::where('product_id', $product_id)
            ->where('star', 2)
            ->count();

        $star_1_Number = ProductReviews::where('product_id', $product_id)
            ->where('star', 1)
            ->count();

        $totalStarNumber = $star_5_Number + $star_4_Number + $star_3_Number + $star_2_Number + $star_1_Number;

        if($totalStarNumber === 0)
            $starAvg = (($star_5_Number * 5) + ($star_4_Number * 4) + ($star_3_Number * 3) + ($star_2_Number * 2) + ($star_1_Number * 1));
        else
            $starAvg = (($star_5_Number * 5) + ($star_4_Number * 4) + ($star_3_Number * 3) + ($star_2_Number * 2) + ($star_1_Number * 1)) / $totalStarNumber;

        return response()->json([
            'starAvg' => round($starAvg, 1),
            'totalStarNumber' => $totalStarNumber
        ]);

    }
}
