<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    /**
     * Get all addresses for the logged-in user.
     */
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($addresses);
    }

    /**
     * Store a new address.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'phone'      => 'required|string',
            'address'    => 'required|string',
            'city'       => 'required|string',
        ]);

        // If this is set as default, remove default from others
        if ($request->is_default) {
            UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $addr = UserAddress::create([
            'user_id'    => Auth::id(),
            'label'      => $request->label ?? 'Rumah',
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name ?? '',
            'phone'      => $request->phone,
            'address'    => $request->address,
            'city'       => $request->city,
            'zip'        => $request->zip ?? '',
            'lat'        => $request->lat ?? null,
            'lng'        => $request->lng ?? null,
            'is_default' => $request->is_default ?? false,
        ]);

        return response()->json(['success' => true, 'address' => $addr]);
    }

    /**
     * Delete an address.
     */
    public function destroy($id)
    {
        $addr = UserAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $addr->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Set an address as default.
     */
    public function setDefault($id)
    {
        UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        UserAddress::where('id', $id)->where('user_id', Auth::id())->update(['is_default' => true]);
        return response()->json(['success' => true]);
    }
}
