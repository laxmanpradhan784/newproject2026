<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class ASliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('id','desc')->get();
        return view('admin.sliders', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'image'=>'required|image'
        ]);

        $imgName = null;
        if($request->hasFile('image')){
            $img = $request->file('image');
            $imgName = time().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('uploads/sliders'), $imgName);
        }

        Slider::create([
            'title'=>$request->title,
            'subtitle'=>$request->subtitle,
            'image'=>$imgName,
            'button_text'=>$request->button_text,
            'button_link'=>$request->button_link,
            'status'=>$request->status
        ]);

        return back()->with('success','Slider Added');
    }

    public function update(Request $request)
    {
        $slider = Slider::find($request->id);

        if($request->hasFile('image')){
            if($slider->image && file_exists(public_path('uploads/sliders/'.$slider->image))){
                unlink(public_path('uploads/sliders/'.$slider->image));
            }
            $img = $request->file('image');
            $imgName = time().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('uploads/sliders'), $imgName);
            $slider->image = $imgName;
        }

        $slider->update([
            'title'=>$request->title,
            'subtitle'=>$request->subtitle,
            'button_text'=>$request->button_text,
            'button_link'=>$request->button_link,
            'status'=>$request->status
        ]);

        return back()->with('success','Slider Updated');
    }

    public function delete($id)
    {
        $slider = Slider::find($id);
        if($slider->image && file_exists(public_path('uploads/sliders/'.$slider->image))){
            unlink(public_path('uploads/sliders/'.$slider->image));
        }
        $slider->delete();
        return back()->with('success','Slider Deleted');
    }
}
