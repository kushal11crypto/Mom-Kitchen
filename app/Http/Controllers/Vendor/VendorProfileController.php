<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VendorProfileController extends Controller
{
    /**
     * Show the form for editing the vendor profile.
     */
    public function edit()
    {
        return view('vendor.profile', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the vendor's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation for vendor fields
        $request->validate([
            'phone_number' => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:255',
            'bio'          => 'nullable|string|max:500',
        ]);

        // Mass assignment of fields
        $user->update($request->only('phone_number', 'address', 'bio'));

        // Redirect back with a success status
        return Redirect::route('vendor.profile.edit')->with('status', 'vendor-profile-updated');
    }
}
