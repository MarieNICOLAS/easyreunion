<?php

namespace App\Http\Controllers;

use App\Mail\RecoverPasswordMail;
use App\Mail\WelcomeMail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\RecaptchaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginPage(Request $request)
    {
        if (! session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required', 'password' => 'required']);
        $credentials['active'] = 1;
        $credentials['suppressed'] = 0;

        // Then log in
        if (Auth::attempt($credentials, $request->input('remember-me'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();

            if (session()->has('url.intended')) {
                $intended = session('url.intended');
                session()->forget('url.intended');

                return redirect()->to($intended);
            }

            return redirect()->route('welcome');
        }

        return back()->withErrors([
            'credentials' => __('auth.failed'),
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('auth.login-page');
    }

    public function register(Request $request)
    {
        RecaptchaService::validateRequest($request);

        $request->validate([
            'first_name' => 'required|min:2|max:80',
            'last_name' => 'required|min:2|max:80',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6|max:200',
            'cgu' => 'required',
        ]);

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        Mail::to($user)->send(new WelcomeMail($user));
        Auth::login($user);

        if (session()->has('url.intended')) {
            $intended = session('url.intended');
            session()->forget('url.intended');

            return redirect()->to($intended);
        }

        return redirect()->route('welcome')->with('success', __('auth.welcome'));
    }

    public function recover(Request $request)
    {
        $request->validate(['email' => 'required']);

        if (User::where('email', $request->input('email'))->exists()) {
            $token = Str::random(130);

            PasswordReset::create([
                'email' => $request->input('email'),
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            Mail::to($request->input('email'))->send(new RecoverPasswordMail($token, $request->input('email')));
        }

        return back()->with('success', __('passwords.sent'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'min:6|max:200',
            'token' => 'required',
            'email' => 'required',
        ]);

        $passwordReset = PasswordReset::where(['email' => $request->input('email'), 'token' => $request->input('token')])->first();
        if (! $passwordReset) {
            return back()->withErrors(['token' => __('passwords.token')]);
        }

        $user = User::where('email', $request->input('email'))->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        PasswordReset::where(['email' => $request->input('email'), 'token' => $request->input('token')])->delete();

        return redirect()->route('welcome')->with('success', __('passwords.reset'));
    }

    public function verifyEmail($token)
    {
        $uncryptedEmail = Crypt::decryptString($token);
        $user = User::where('email', $uncryptedEmail)->first();

        if ($user->email_verified_at) {
            return redirect()->route('welcome')->with('success', __('auth.email_already_verified'));
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect()->route('welcome')->with('success', __('auth.email_verified'));
    }
}
