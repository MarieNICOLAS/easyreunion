<?php

namespace App\Services;

use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;

class RecaptchaService
{
    static function validateRequest(Request $request)
    {
        if (config('app.env') === 'testing')
            return true;

        $token = $request->input('g-recaptcha-response');
        $action = $request->input('action');

        $recaptcha = new ReCaptcha(config('services.recaptcha.secret_key'));
        $resp = $recaptcha->setExpectedAction($action)
            ->setScoreThreshold(0.5)
            ->verify($token, $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

        // verify the response
        if (!$resp->isSuccess())
        {
            abort(403);
        }

        return true;
    }
}
