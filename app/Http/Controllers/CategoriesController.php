<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        return view('admin.category.all_categories',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $category = new Category();

            $category->name = $data['name'];
            $category->parent_id = $data['parent_id'];
            $category->slug = str_slug($request->name);
            $category->save();
            return redirect()->route('all_categories')->with('flash_message_success','Category Added Successfully');
        }
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.category.add_category',compact('levels'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id= null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Category::where(['id'=>$id])->update(['name'=>$data['name'],'slug'=>str_slug($request->name)]);
            return redirect()->route('all_categories')->with('flash_message_success','Category Updated Successfully');
        }
        $category = Category::find($id);
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.category.edit_category',compact('category','levels'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id = null)
    {
        if (!empty($id)) {
            Category::where(['id'=>$id])->delete();
            return back()->with('flash_message_success','Category Deleted Successfully');
        }        
    }
}
