<?php
// Put this file at: backend/app/Http/Controllers/UserProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    // Preset mascot avatars (files must exist in backend/public/images/)
    private const PRESETS = [
        'images/dog.jpg',
        'images/Doge.webp',
    ];

    public function show()
    {
        return view('profile', [
            'user' => Auth::user(),
            'presets' => self::PRESETS,
        ]);
    }

    public function update(Request $request)
    {
      /** @var \App\Models\User $user */
$user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'digits:11'],
            'address' => ['nullable', 'string', 'max:255'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'preset_avatar' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:6'],
        ]);

        $user->name = $data['name'];
        $user->phone = $data['phone'] ?? null;
        $user->address = $data['address'] ?? null;

        // Profile picture: uploaded file wins, otherwise a preset
        if ($request->hasFile('avatar_file')) {
            $this->deleteOldUpload($user->avatar);
            $user->avatar = $request->file('avatar_file')->store('avatars', 'public');
        } elseif (!empty($data['preset_avatar']) && in_array($data['preset_avatar'], self::PRESETS, true)) {
            $this->deleteOldUpload($user->avatar);
            $user->avatar = $data['preset_avatar'];
        }

        if (!empty($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
        }

        $user->save();

        return back()->with('status', 'Profile updated successfully!');
    }

    // Only delete files that were uploaded (not the preset images)
    private function deleteOldUpload(?string $path): void
    {
        if ($path && str_starts_with($path, 'avatars/')) {
            Storage::disk('public')->delete($path);
        }
    }
}