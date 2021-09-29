<?php

namespace App\Http\Controllers;

use App\BusinessLayer\CategoryLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $getObj = new CategoryLogic(null);
        return $getObj->index();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $catObj = new CategoryLogic($request->all());
        $response = $catObj->store();
        return response()->json([
            'data' => $response,
        ], 201);
    }

    public function show($id)
    {
        $getObj = new CategoryLogic(null);
        return $getObj->show($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $catObj = new CategoryLogic($request->all());
        $response = $catObj->update($id);
        return response()->json([
            'data' => $response,
        ], 200);
    }

    public function destroy($id)
    {
        $catObj = new CategoryLogic(null);
        $response = $catObj->destroy($id);
        return response()->json([
            'status' => $response,
        ], 200);
    }
}
