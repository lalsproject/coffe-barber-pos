<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first();

        return view('master.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'button_color' => 'required|string|max:7',
            'background_color' => 'required|string|max:7',
            'input_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'icon_color' => 'required|string|max:7',
            'navbar_background' => 'required|string|max:7',
            'sidebar_background' => 'required|string|max:7',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $settings = Setting::first();

        $image = $request->file('logo');

        if ($request->hasFile('logo')) {
            if ($image->isValid())
            {
                $destinationPath = public_path() . '/files/logo/';
                $imageFile = time() . '-' . Str::random(15) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageFile);
                $imageName = '/files/logo/'.$imageFile;
            }
        } else {
            $imageName = $settings->logo;
        }

    
        $settings->update([
            'logo' => $imageName,
            'button_color' =>  $request->button_color_code, 
            'background_color' => $request->background_color_code, 
            'input_color' => $request->input_color_code, 
            'text_color' => $request->text_color_code, 
            'icon_color' => $request->icon_color_code, 
            'navbar_background' => $request->navbar_background_code, 
            'sidebar_background' => $request->sidebar_background_code
        ]);
    
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
    
}
