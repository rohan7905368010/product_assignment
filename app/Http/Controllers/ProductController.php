<?php

namespace App\Http\Controllers;

use App\BusinessLayer\ProductLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index()
    {
        $getObj = new ProductLogic(null);
        return $getObj->index();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'product_code' => 'required|max:8',
            'size_id' => 'required|numeric',
            'color_id' => 'required|numeric',
            'category_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $productObj = new ProductLogic($request->all());
        $response = $productObj->store();
        return response()->json([
            'data' => $response,
        ], 201);
    }

    public function show($id)
    {
        $getObj = new ProductLogic(null);
        return $getObj->show($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'product_code' => 'required|max:8',
            'size_id' => 'required|numeric',
            'color_id' => 'required|numeric',
            'category_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $productObj = new ProductLogic($request->all());
        $response = $productObj->update($id);
        return response()->json([
            'data' => $response,
        ], 201);
    }

    public function destroy($id)
    {
        $productObj = new ProductLogic(null);
        $response = $productObj->destroy($id);
        return response()->json([
            'status' => $response,
        ], 200);
    }
}
