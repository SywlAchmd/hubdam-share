<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
	/**
	 * Display the user's profile form.
	 * @return Response
	 */
	public function edit(): Response
	{
		return Inertia::render('Profile/Edit', ['baseUrl' => config('app.url')]);
	}

	/**
	 * Update the user's profile information.
	 * @param UpdateProfileRequest $request
	 * @return RedirectResponse
	 */
	public function update(UpdateProfileRequest $request): RedirectResponse
	{
		$user = auth()->user();

		$data = $request->only('name', 'username', 'email', 'staff');

		if ($request->filled('password')) {
			$data['password'] = bcrypt($request->password);
		}

		if ($request->hasFile('image')) {
			$disk = Storage::disk('public');

			if ($user->image && $disk->exists($user->image)) {
				$disk->delete($user->image);
			}

			$filename = Str::uuid()->toString();
			$extension = $request->file('image')->getClientOriginalExtension();
			$filename = substr($filename, 0, 26) . '.' . $extension;

			$fileUrl = $request->file('image')->storeAs('user-images', $filename, 'public');
			$data['image'] = $fileUrl;
		}

		$user->update($data);

		session()->flash('success', 'Profil berhasil diperbarui.');

		return redirect()->route('profile.edit');
	}
}
