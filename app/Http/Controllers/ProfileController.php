<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile');
    }

    public function update(Request $request)
{
    // Validate input fields
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        'password' => 'nullable|string|min:8',
    ]);

    // Get the authenticated user
    $user = Auth::user();

    if ($user) { // Check if user is authenticated
        // Check if there are any changes to name or email
        $updateMade = false;

        if ($user->name !== $request->name || $user->email !== $request->email) {
            $updateMade = true;
        }

        // Check if password is filled and changed
        if ($request->filled('password') && !Hash::check($request->password, $user->password)) {
            $updateMade = true;
        }

        // If no updates were made, redirect with a 'no update' message
        if (!$updateMade) {
            return redirect()->route('profile')->with('no_update', 'Tidak ada perubahan yang dilakukan!');
        }

        // Update the user's data if changes were made
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


        $user->save();


        return redirect()->route('profile')->with('success', 'Profile berhasil diupdate!');
    }

    // If user is not authenticated, redirect to the login page
    return redirect()->route('login')->with('error', 'Please login to access your profile.');
}


public function updateImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambahkan aturan validasi yang sesuai
    ]);

    $user = Auth::user();

    // Tentukan folder berdasarkan role
    $folder = $user->role === 'mahasiswa' ? 'mahasiswa' : 'dosen';

    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($user->image && $user->image !== 'default.jpg') {
            $oldImagePath = public_path("images/{$folder}/" . $user->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Proses upload gambar baru
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path("images/{$folder}"), $imageName); // Simpan gambar di folder yang sesuai

        $user->image = $imageName; // Simpan nama gambar baru di database
        $user->save();
    }

    return redirect()->back()->with('success', 'Foto profil berhasil diupdate.');
}


public function destroyImage(Request $request)
{
    $user = Auth::user();

    // Check if the user has an existing image
    if ($user->image && $user->image !== 'default.jpg') {
        // Remove the existing image file from storage
        $imagePath = public_path('images/mahasiswa/' . $user->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Set image to default in the database
        $user->image = 'default.jpg'; // Set to default image name
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
    }

    return redirect()->back()->with('error', 'Tidak ada foto profil untuk dihapus.');
}


}
