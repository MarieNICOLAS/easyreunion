<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PKCEService;
use App\Services\SellsyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SellsyController extends Controller
{
    public function requestAuthCode()
    {
        $code = new PKCEService();

        Cache::put('sellsy-challenge', $code->verifier);

        $url = 'https://login.sellsy.com/oauth2/authorization?response_type=code&client_id='
            . urlencode(config('services.sellsy.key'))
            . '&redirect_uri=' . urlencode(route('api.sellsy.connect'))
            . '&code_challenge=' . $code->challengeCode . '&code_challenge_method=S256';

        return redirect($url);
    }

    public function connect(Request $request)
    {


        Cache::put('sellsy-auth-code', $request->input('code'), 600);

        $service = new SellsyService(true);
        $service->getBearerFromAuthCode();

        return redirect()->route('admin.dashboard');
    }


}
