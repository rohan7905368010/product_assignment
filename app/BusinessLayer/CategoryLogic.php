<?php

namespace App\BusinessLayer;

use App\Category;

class CategoryLogic
{
    public $requestData;
    public function __construct($_request) {
        $this->requestData = $_request;
    }

    public function index()
    {
        $category = Category::all();
        return $category;
    }

    public function store()
    {
        $category = new Category;

        $category->category = $this->requestData['category'];
        $category->description = $this->requestData['description'];

        $category->save();

        return $category;
    }

    public function show($id)
    {
        $category = Category::find($id);

        return $category;
    }

    public function update($id)
    {
        $category = Category::find($id);

        if( !$category ) {
            return null;
        }

        $category->category = $this->requestData['category'];
        $category->description = $this->requestData['description'];

        $category->update();

        return $category;
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if( $category ) {
            $category->delete();

            return true;
        }

        return false;
    }
}
