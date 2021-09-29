<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessLayer\SizeLogic;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{

    public function index()
    {
        $getObj = new SizeLogic(null);
        return $getObj->index();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'size' => 'required',
            'size_code' => 'required|unique:sizes'
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->errors(),400);
        }

        $sizeObj = new SizeLogic($request->all());
        $response = $sizeObj->store();
        return response()->json([
            'data' => $response
        ],201);
    }

    public function show($id)
    {
        $getObj = new SizeLogic(null);
        return $getObj->show($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'size' => 'required',
            'size_code' => 'required|unique:sizes'
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->errors(),400);
        }

        $sizeObj = new SizeLogic($request->all());
        $response = $sizeObj->update($id);
        return response()->json([
            'data' => $response
        ],200);
    }

    public function destroy($id)
    {
        $sizeObj = new SizeLogic(null);
        $response = $sizeObj->destroy($id);
        return response()->json([
            'status' => $response
        ],200);
    }
}
