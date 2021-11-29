<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;

class BrandApi extends Controller
{
    public function index(Request $request){
        $data = Brands::all();

        return response()->json($data);
    }
    public function show($id){
        $data = Brands::find($id);

        return response()->json($data);
    }
    public function store(Request $request){
        $data = Brands::create($request->all());

        return response()->json($data);
    }
    public function update(Request $request, $id){
        $brands = Brands::findOrFail($id);
        $brands->update($request->all());

        return response()->json($brands);
    }
    public function delete(Request $request, $id){
        $brands = Brands::findOrFail($id);
        $brands->delete();

        return response()->json(204);
    }
}
