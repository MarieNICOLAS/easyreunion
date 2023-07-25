<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->addresses);
    }

    public function store(Request $request)
    {
        $request->validate(Address::$rules);

        $address = Address::create([
            'user_id' => $request->user()->id,
            'address_name' => $request->input('address_name'),
            'customer_name' => $request->input('customer_name'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'zipcode' => $request->input('zipcode'),
            'country' => $request->input('country'),
        ]);

        return response()->json($address);
    }

    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);
        $request->validate(Address::$rules);

        $address->update([
            'address_name' => $request->input('address_name'),
            'customer_name' => $request->input('customer_name'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'zipcode' => $request->input('zipcode'),
            'country' => $request->input('country'),
        ]);

        return response()->json($address);
    }

    public function delete(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $address->delete();

        return response()->json('OK');
    }
}
