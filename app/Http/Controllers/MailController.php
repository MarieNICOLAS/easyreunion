<?php

namespace App\Http\Controllers;
use App\Mail\EstimateRequestMail;
use App\Models\EstimateRequest;

use App\Services\RecaptchaService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;




use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Illuminate\Support\Facades\Session;

class MailController extends Controller
{
    use ApiResponser;

    public function sendContactMessage(Request $request)
    {
        RecaptchaService::validateRequest($request);

        $dest = env('CONTACT_MAIL');

        $request->validate([
            'name' => 'required|min:3|string|max:10000',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required|min:3|string|max:10000',
        ]);


        $estimateRequest = EstimateRequest::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        // send email
        Mail::to(config('mail.contact_mail'))->send(new EstimateRequestMail($estimateRequest));

        return redirect()->to(route('welcome') . '#contact')->with(['success' => 'Votre message a bien été envoyé !']);
    }
}
