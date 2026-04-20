<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = $this->currentUser();
        if (! $user) {
            abort(401);
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $this->currentUser();
        if (! $user) {
            abort(401);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->getKey() . ',user_id'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        // keep compatibility with current app session logic (some views/controllers rely on this)
        session(['user' => $user]);

        return redirect()->route('profile.edit')->with('success', 'Cập nhật profile thành công.');
    }

    private function currentUser(): ?User
    {
        // Prefer Laravel Auth if working; fallback to session('user') used by AuthController
        $authUser = Auth::user();
        if ($authUser instanceof User) {
            return $authUser;
        }

        $sessionUser = session('user');
        if ($sessionUser instanceof User) {
            return $sessionUser;
        }

        return null;
    }
}
