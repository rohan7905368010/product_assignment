<?php

namespace App\BusinessLayer;

use App\Size;
use App\Color;
use App\Product;
use App\Category;
use App\ProductSize;
use App\ProductColor;
use App\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductLogic
{
    public $requestData;
    public function __construct($_request) {
        $this->requestData = $_request;
    }

    public function index()
    {
        $product = Product::all();
        return $product;
    }

    public function store()
    {
        DB::beginTransaction();

        $product = new Product;

        $product->name = $this->requestData['name'];
        $product->product_code = $this->requestData['product_code'];
        $product->description = $this->requestData['description'];

        $product->save();

        $size = Size::find($this->requestData['size_id']);

        //if size not found
        if( !$size ) {
            DB::rollback();
        }

        //add data to product size
        $this->AddProductSize($product->id);

        $category = Category::find($this->requestData['category_id']);
        //if not found
        if( !$category ) {
            DB::rollback();
        }
        //add data to product category
        $this->AddProductCategory($product->id);

        $color = Color::find($this->requestData['color_id']);
        //if color not found
        if( !$color ) {
            DB::rollback();
        }
        //add data to product size
        $this->AddProductColor($product->id);

        DB::commit();
        
        return $product;
    }

    public function show($id)
    {
        $product = Product::find($id);
        if( !$product ) {
            return [];
        }

        $product->size = $this->GetProductSize($product->id);
        $product->category = $this->GetProductCategory($product->id);
        $product->color = $this->GetProductColor($product->id);

        return $product;
    }

    public function update($id)
    {
        DB::beginTransaction();

        $product = Product::find($id);

        if( !$product ) {
            return null;
        }

        $product->name = $this->requestData['name'];
        $product->product_code = $this->requestData['product_code'];
        $product->description = $this->requestData['description'];

        $product->update();

        $size = Size::find($this->requestData['size_id']);
        //if size not found
        if( !$size ) {
            DB::rollback();
        }

        //add data to product size
        $this->AddProductSize($product->id);

        $category = Category::find($this->requestData['category_id']);
        //if not found
        if( !$category ) {
            DB::rollback();
        }
        //add data to product category
        $this->AddProductCategory($product->id);

        $color = Color::find($this->requestData['color_id']);
        //if color not found
        if( !$color ) {
            DB::rollback();
        }
        //add data to product size
        $this->AddProductColor($product->id);

        DB::commit();
        
        return $product;
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if( $product ) {
            //delete categories
            ProductCategory::where('product_id',$product->id)->delete();
            //delete colors
            ProductColor::where('product_id',$product->id)->delete();
            //delete sizes
            ProductSize::where('product_id',$product->id)->delete();

            $product->delete();

            return true;
        }

        return false;
    }

    //private functions
    private function AddProductSize($_productId) 
    {        
        $productSize = new ProductSize;
        $productSize->product_id = $_productId;
        $productSize->size_id = $this->requestData['size_id'];

        $productSize->save();

        return;
    }

    private function AddProductCategory($_productId) 
    {        
        $productCategory = new ProductCategory;
        $productCategory->product_id = $_productId;
        $productCategory->category_id = $this->requestData['category_id'];

        $productCategory->save();

        return;
    }

    private function AddProductColor($_productId) 
    {        
        $productColor = new ProductColor;
        $productColor->product_id = $_productId;
        $productColor->color_id = $this->requestData['color_id'];

        $productColor->save();

        return;
    }

    private function GetProductSize($_productId) 
    {        
        $productSize = DB::table('product_sizes as t')
        ->join('sizes as t1','t.size_id','=','t1.id')
        ->where([
            't.product_id' => $_productId
        ])->select([
            't1.size',
            't1.size_code'
        ])->get();

        return $productSize;
    }

    private function GetProductCategory($_productId) 
    {        
        $productColor = DB::table('product_categories as t')
        ->join('categories as t1','t.category_id','=','t1.id')
        ->where([
            't.product_id' => $_productId
        ])->select([
            't1.category',
            't1.description'
        ])->get();

        return $productColor;
    }

    private function GetProductColor($_productId) 
    {        
        $productColor = DB::table('product_colors as t')
        ->join('colors as t1','t.color_id','=','t1.id')
        ->where([
            't.product_id' => $_productId,
        ])->select([
            't1.color',
            't1.color_code'
        ])->get();

        return $productColor;
    }
}
