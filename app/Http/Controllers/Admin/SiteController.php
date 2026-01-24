<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    // Show site settings form
    public function index()
    {
        $site = SiteSetting::first();
        return view('admin.site-settings', compact('site'));
    }

    // Update site settings
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_1' => 'nullable|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'map_location' => 'nullable|url|max:500',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'pinterest' => 'nullable|url|max:255',
            'email_support' => 'nullable|email|max:100',
            'email_business' => 'nullable|email|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get or create site settings
        $site = SiteSetting::first();
        
        if (!$site) {
            $site = new SiteSetting();
        }

        // Update all fields
        $site->fill($request->all());
        $site->save();

        return redirect()->route('admin.site-settings')
            ->with('success', 'Site settings updated successfully!');
    }
}