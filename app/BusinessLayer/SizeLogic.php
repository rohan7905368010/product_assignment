<?php

namespace App\BusinessLayer;

use App\Size;

class SizeLogic
{
    public $requestData;
    public function __construct($_request) {
        $this->requestData = $_request;
    }
    public function index()
    {
        $size = Size::all();
        return $size;
    }

    public function store()
    {
        $size = new Size;

        $size->size = $this->requestData['size'];
        $size->size_code = $this->requestData['size_code'];

        $size->save();

        return $size;
    }

    public function show($id)
    {
        $size = Size::find($id);

        return $size;
    }

    public function update($id)
    {
        $size = Size::find($id);
                
        if( !$size ) {
            return null;
        }

        $size->size = $this->requestData['size'];
        $size->size_code = $this->requestData['size_code'];

        $size->update();

        return $size;
    }

    public function destroy($id)
    {
        $size = Size::find($id);
        if( $size ) {
            $size->delete();

            return true;
        }

        return false;
    }
}
