<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IdentityController extends Controller
{
    public function edit()
    {
        $identity = Identity::first() ?? new Identity();

        return view('admin.identity.edit', compact('identity'));
    }

    public function update(Request $request)
    {
        $identity = Identity::first() ?? new Identity();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'headline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:10240'],
            'cv_creative' => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // 10MB
            'cv_formal' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],   // 10MB
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
        ]);

        if ($request->hasFile('photo')) {
            if ($identity->photo) {
                Storage::disk('public')->delete($identity->photo);
            }
            $validated['photo'] = $request->file('photo')->store('identity', 'public');
        }

        // CV uploads: 'cv_creative' / 'cv_formal' are form fields, the DB columns are *_path
        foreach (['creative', 'formal'] as $type) {
            $field = "cv_{$type}";
            $column = "cv_{$type}_path";
            unset($validated[$field]);

            if ($request->hasFile($field)) {
                if ($identity->{$column}) {
                    Storage::disk('public')->delete($identity->{$column});
                }
                $validated[$column] = $request->file($field)->store('cv', 'public');
            }
        }

        $identity->fill($validated);
        $identity->save();

        return redirect()
            ->route('admin.identity.edit')
            ->with('status', 'Profile updated successfully.');
    }
}
