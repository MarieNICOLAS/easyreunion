<?php

namespace App\Http\Controllers;

use App\Mail\EstimateRequestMail;
use App\Models\EstimateRequest;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Space;
use App\Models\SpaceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Services\RecaptchaService;


class StaticPageController extends Controller
{
    public function welcome()
    {

        $key = 'homepage-content';
        if (!Cache::has($key) || config('app.env') !== 'production')
        {
            Cache::put($key, Setting::getHomePageSettings());
        }
        $content = Cache::get($key);

        return view('guest.welcome', [
            'content'      => $content
        ] );
    }


    public function requestQuotePage(Request $request)
    {
        $space = Space::where('slug', $request->input('space'))->firstOrFail();

        return view('guest.request-quote')->with(['space' => $space]);
    }

    public function requestQuote(Request $request)
    {
        RecaptchaService::validateRequest($request);

        $request->validate([
            'name' => 'required|max:100|min:3',
            'company' => 'required|max:100|min:3',
            'phone' => 'required|max:20|min:5',
            'email' => 'required|email',
            'start' => 'required|date',
            'end' => 'required|date',
            'space' => 'required',
            'time' => 'required|in:day,am,pm,evening',
            'message' => 'required|min:10|max:10000'
        ]);

        // Parsing space
        $type = substr($request->input('space'), 0, 2);
        $id = substr($request->input('space'), 3);
        if ($type === 'sg')
        {
            $space = SpaceGroup::select('id', 'name')->find($id);
        } else
        {
            $space = Space::select('id', 'name')->find($id);
        }

        $estimateRequest = EstimateRequest::create([
            'name' => $request->input('name'),
            'company' => $request->input('company'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'space_id' => $space->id,
            'time' => $request->input('time'),
            'message' => $request->input('message'),
        ]);

        Mail::to(config('mail.contact_mail'))->send(new EstimateRequestMail($estimateRequest));


        return redirect()->back()->with('success', 'La demande a bien été envoyée');
    }

    public function page(Request $request, Page $page)
    {
        return view('guest.page')->with(['page' => $page]);
    }
}
