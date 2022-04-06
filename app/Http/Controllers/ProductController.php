<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $product = Product::with(['category'])->get();
           
            return $this->success(1,  $product);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $product = new Product();

            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
           
            if($product->save()){
                return $this->success(1,  $product);
            }else{
                return $this->error(0,'can not create pro$product');
            }
        } catch (\Exception $e) {
            
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try {
            $product =  Product::find($id);

            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
           
            if($product->update()){
                return $this->success(1,  $product);
            }else{
                return $this->error(0,'can not update product');
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product =  Product::find($id);

            if($product->delete()){
                return $this->done(1,  'Successfully product deleted');
            }else{
                return $this->error(0,'Can\'t remove this product');
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }
}
