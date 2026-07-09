<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email'],
            'facebook_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'footer_text' => ['nullable', 'string'],
        ]);

        foreach ($data as $key => $value) {
            setting()->set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }
}
