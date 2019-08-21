<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicine;
use App\Category;

class MedicinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicines = Medicine::get();
        return view('admin.medicine.all_medicines',compact('medicines'));
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
            $medicine = new Medicine();

            $medicine->name = $data['name'];
            $medicine->parent_id = $data['parent_id'];
            $medicine->type = $data['type'];
            $medicine->v_name = $data['v_name'];
            $medicine->price = $data['price'];
            $medicine->type = $data['type'];
            $medicine->slug = str_slug($request->name);
            $medicine->save();
            return redirect()->route('all_medicines')->with('flash_message_success','Medicines Added Successfully');
        }
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.medicine.add_medicine',compact('levels'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Medicine::where(['id'=>$id])->update(['name'=>$data['name'],'v_name'=>$data['v_name'],'price'=>$data['price'],'type'=>$data['type']]); 
                       return redirect()->route('all_medicines')->with('flash_message_success','Medicines Updated Successfully');
        }
        $medicine = Medicine::find($id);
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.medicine.edit_medicine',compact('medicine','levels'));
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
            Medicine::where(['id'=>$id])->delete();
            return back()->with('flash_message_success','Medicine Deleted Successfully');
        }        
    }
}
