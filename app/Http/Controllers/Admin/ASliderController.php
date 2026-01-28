<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ASliderController extends Controller
{
    // Display all sliders in one page with forms
    public function index()
    {
        $sliders = Slider::orderBy('id', 'desc')->get();
        return view('admin.sliders', compact('sliders'));
    }

    // Handle adding new slider
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imgName = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = 'slider_' . time() . '_' . Str::random(10) . '.' . $img->getClientOriginalExtension();

            // Ensure directory exists
            $uploadPath = public_path('uploads/sliders');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $img->move($uploadPath, $imgName);
        }

        // Create slider
        Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imgName,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'status' => $request->status ?? 'active',
        ]);

        return back()->with('success', 'Slider added successfully!');
    }

    // Handle updating existing slider
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sliders,id',
            'title' => 'required|string|max:255',
        ]);

        $slider = Slider::find($request->id);

        // Handle new image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
                unlink(public_path('uploads/sliders/' . $slider->image));
            }

            // Upload new image
            $img = $request->file('image');
            $imgName = 'slider_' . time() . '_' . Str::random(10) . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/sliders'), $imgName);
            $slider->image = $imgName;
        }

        // Update slider data
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->button_text = $request->button_text;
        $slider->button_link = $request->button_link;
        $slider->status = $request->status;
        $slider->save();

        return back()->with('success', 'Slider updated successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $slider = Slider::findOrFail($id);
        $slider->status = $request->status;
        $slider->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    // Handle deleting slider
    public function delete($id)
    {
        $slider = Slider::find($id);

        // Delete image file
        if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
            unlink(public_path('uploads/sliders/' . $slider->image));
        }

        $slider->delete();

        return back()->with('success', 'Slider deleted successfully!');
    }
}
