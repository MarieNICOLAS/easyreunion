<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $teamMembers = $request->user()->selectedPartner()->users;

        return view('partners.users.index')->with('teamMembers', $teamMembers);
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|min:2|max:80',
            'last_name' => 'required|min:2|max:80',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (! $user) {
            $password = Str::random();
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($password),
                'rank' => 'partner',
            ]);

            Mail::to($request->input('email'))->send(new AccountCreatedMail($user, $password));
        }

        $request->user()->selectedPartner()->users()->sync($user, false);

        return redirect()->back();
    }

    public function removeUser(Request $request, User $user)
    {
        // You can't detach yourself.
        if ($user->id === $request->user()->id) {
            abort(403);
        }

        $request->user()->selectedPartner()->users()->detach($user);

        return redirect()->back();
    }
}
