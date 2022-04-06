<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $category = Category::with('products')->get();
            return $this->success(1,  $category);
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
            $category = new Category();

            $category->name = $request->name;

          
            if($category->save()){
                return $this->success(1,  $category);
            }else{
                return $this->error(0,'can not create category');
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $category =  Category::find($id);

            $category->name = $request->name;
           
            if($category->update()){
                return $this->success(1,  $category);
            }else{
                return $this->error(0,'can not update category');
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category =  Category::find($id);

            if($category->delete()){
                return $this->done(1,  'Successfully category deleted');
            }else{
                return $this->error(0,'Can\'t remove this category');
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }
}
