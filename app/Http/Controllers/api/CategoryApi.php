<?php

namespace App\Http\Controllers\api;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryApi extends Controller
{
    public function index(){
        $data = Categories::all();

        return response()->json($data);
    }
    public function show($id){
        $data = Categories::find($id);

        return response()->json($data);
    }
    public function store(Request $request){
        $data = Categories::create($request->all());

        return response()->json($data);
    }
    public function update(Request $request, $id){
        $brands = Categories::findOrFail($id);
        $brands->update($request->all());

        return response()->json($brands);
    }
    public function delete(Request $request, $id){
        $brands = Categories::findOrFail($id);
        $brands->delete();

        return response()->json(204);
    }
}
