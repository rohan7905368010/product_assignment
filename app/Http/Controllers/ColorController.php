<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessLayer\ColorLogic;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{

    public function index()
    {
        $getObj = new ColorLogic(null);
        return $getObj->index();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'color' => 'required',
            'color_code' => 'required|unique:colors'
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->errors(),400);
        }

        $colorObj = new ColorLogic($request->all());
        $response = $colorObj->store();
        return response()->json([
            'data' => $response
        ],201);
    }

    public function show($id)
    {
        $getObj = new ColorLogic(null);
        return $getObj->show($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'color' => 'required',
            'color_code' => 'required|unique:colors'
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->errors(),400);
        }

        $colorObj = new ColorLogic($request->all());
        $response = $colorObj->update($id);
        return response()->json([
            'data' => $response
        ],200);
    }

    public function destroy($id)
    {
        $colorObj = new ColorLogic(null);
        $response = $colorObj->destroy($id);
        return response()->json([
            'status' => $response
        ],200);
    }
}
