<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreatedMail;
use App\Mail\PartnerRequestApprovedMail;
use App\Mail\PartnerRequestRefusedMail;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index()
    {
        return view('admin.partners.index');
    }

    public function show(Partner $partner)
    {
        return view('admin.partners.show')->with('partner', $partner);
    }

    public function getRequests(Request $request)
    {
        $partners = Partner::where('is_validated', false)->get();

        return view('admin.partners.requests')->with('partners', $partners);
    }

    public function approveRequest(Request $request, Partner $partner)
    {
        if ($partner->is_validated)
        {
            abort(403);
        }

        $partner->is_validated = true;
        $partner->save();
        $user = $partner->users()->first();
        $user->rank = 'partner';
        $user->save();

        Mail::to($user->email)->send(new PartnerRequestApprovedMail());

        return redirect()->route('admin.partners.requests.index');
    }

    public function deleteRequest(Request $request, Partner $partner)
    {
        if ($partner->is_validated)
        {
            abort(403);
        }

        Mail::to($partner->users)->send(new PartnerRequestRefusedMail());

        $partner->delete();

        return redirect()->back();
    }

    public function getPartners(Request $request)
    {
        $paginator = Partner::select('id', 'company', 'type', 'plan');

        if ($request->input('plan') && $request->input('plan') !== 'all')
        {
            if ($request->input('plan') === 'null')
            {
                $paginator->whereNull('plan');
            } else
            {
                $paginator->where('plan', $request->input('plan'));
            }
        }
        if ($request->input('type') && $request->input('type') !== 'all')
        {
            $paginator->where('type', $request->input('type'));
        }

        return response()->json($paginator->paginate(10));
    }

    public function addUser(Request $request, Partner $partner)
    {
        if ($request->input('admin'))
        {
            $request->validate(['admin' => 'required|exists:users,id']);
            $partner->users()->syncWithoutDetaching(User::find($request->input('admin')));
        } else
        {
            $request->validate(['email' => 'required|email']);
            $user = User::where('email', $request->input('email'))->first();
            if (!$user)
            {
                $request->validate(['first_name' => 'required', 'last_name' => 'required']);
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
            $partner->users()->syncWithoutDetaching($user);
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $result = Partner::select('id', 'name')->where('name', 'like', '%' . $request->input('query') . '%')->get();

        return response()->json($result);
    }

    public function delete(Request $request, Partner $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partners.index');
    }
}
