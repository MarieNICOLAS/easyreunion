<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('user.settings');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'password' => 'nullable|min:6|max:200',
            'email' => 'required|unique:users,email,' . $user->id,
        ]);

        $user->email = $request->input('email');
        if ($request->input('password'))
        {
            $user->password = Hash::make($request->input('password'));
        }
        $user->email_notifications = $request->has('email_notifications');

        $user->save();

        return redirect()->back()->with(['success' => 'Paramètres bien mis à jour']);
    }

    public function deleteAccount(Request $request)
    {
        $request->user()->delete();

        return redirect()->route('welcome');
    }
}
