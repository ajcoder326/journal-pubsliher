<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppearanceController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.appearance.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $request->validate(['site_logo' => 'image|mimes:png,jpg,jpeg,svg,webp|max:2048']);
            $path = $request->file('site_logo')->store('branding', 'public');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        // Handle footer logo upload
        if ($request->hasFile('footer_logo')) {
            $request->validate(['footer_logo' => 'image|mimes:png,jpg,jpeg,svg,webp|max:2048']);
            $path = $request->file('footer_logo')->store('branding', 'public');
            Setting::updateOrCreate(['key' => 'footer_logo'], ['value' => $path]);
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $request->validate(['site_favicon' => 'image|mimes:png,ico,svg|max:512']);
            $path = $request->file('site_favicon')->store('branding', 'public');
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => $path]);
        }

        // Remove logo if requested
        if ($request->has('remove_logo')) {
            $current = Setting::where('key', 'site_logo')->first();
            if ($current && $current->value) {
                Storage::disk('public')->delete($current->value);
            }
            Setting::where('key', 'site_logo')->delete();
        }

        if ($request->has('remove_footer_logo')) {
            $current = Setting::where('key', 'footer_logo')->first();
            if ($current && $current->value) {
                Storage::disk('public')->delete($current->value);
            }
            Setting::where('key', 'footer_logo')->delete();
        }

        // Save all other appearance settings
        $fields = [
            // Theme colors
            'theme_primary_color', 'theme_secondary_color', 'theme_accent_color',
            'theme_text_color', 'theme_bg_color',
            // Header
            'header_top_bar_text', 'header_brand_name', 'header_brand_subtitle',
            'header_issn', 'header_frequency',
            // Footer
            'footer_about_text', 'footer_publisher_name', 'footer_address',
            'footer_country', 'footer_email', 'footer_phone',
            'footer_copyright_text', 'footer_license_text',
            // Hero section
            'hero_badge_text', 'hero_title', 'hero_subtitle', 'hero_description',
            'hero_btn1_text', 'hero_btn1_url', 'hero_btn2_text', 'hero_btn2_url',
            // Custom CSS
            'custom_css',
            // Custom head code (analytics etc)
            'custom_head_code',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::updateOrCreate(['key' => $field], ['value' => $request->input($field)]);
            }
        }

        return redirect()->route('admin.appearance.index')->with('success', 'Appearance settings updated successfully.');
    }
}
