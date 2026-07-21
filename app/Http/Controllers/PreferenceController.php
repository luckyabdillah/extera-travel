<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Helpers\PreferenceHelper;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    /**
     * Show the form for editing preferences.
     */
    public function edit()
    {
        $keys = [
            'mail_info',
            'whatsapp_number',
            'email',
            'address',
            'facebook_account',
            'instagram_account',
            'tiktok_account',
            'package_inclusions_template',
            'package_exclusions_template',
            'package_requirements_template',
        ];

        $preferences = [];
        foreach ($keys as $key) {
            $preferences[$key] = PreferenceHelper::get($key);
        }

        return view('admin.preferences.edit', compact('preferences'));
    }

    /**
     * Update preferences in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'mail_info' => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'facebook_account' => 'nullable|string|max:255',
            'instagram_account' => 'nullable|string|max:255',
            'tiktok_account' => 'nullable|string|max:255',
            'package_inclusions_template' => 'nullable|string',
            'package_exclusions_template' => 'nullable|string',
            'package_requirements_template' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            PreferenceHelper::store($key, $value);
        }

        return redirect()->route('admin.settings.preferences')->with('success', 'Preferensi berhasil diperbarui.');
    }
}