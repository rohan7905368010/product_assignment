<?php

namespace App\BusinessLayer;

use App\Color;

class ColorLogic
{
    public $requestData;
    public function __construct($_request) {
        $this->requestData = $_request;
    }
    public function index()
    {
        $color = Color::all();
        return $color;
    }

    public function store()
    {
        $color = new Color;

        $color->color = $this->requestData['color'];
        $color->color_code = $this->requestData['color_code'];

        $color->save();

        return $color;
    }

    public function show($id)
    {
        $color = Color::find($id);

        return $color;
    }

    public function update($id)
    {
        $color = Color::find($id);
        
        if( !$color ) {
            return null;
        }

        $color->color = $this->requestData['color'];
        $color->color_code = $this->requestData['color_code'];

        $color->update();

        return $color;
    }

    public function destroy($id)
    {
        $color = Color::find($id);
        if( $color ) {
            $color->delete();

            return true;
        }

        return false;
    }
}
