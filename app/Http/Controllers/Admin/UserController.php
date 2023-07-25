<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreatedMail;
use App\Models\Organization;
use App\Models\User;
use App\Services\SellsyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function index(Request $request)
    {
        if( $request->route()->getName() == "admin.users.index" ) {
            $status = "all";
        } else {
            $base_url = config('app.url');
            $status = str_replace($base_url.'/admin/users/status/', '', $request->url());
        }

        if($status == "all") {
            $users = User::whereRaw('suppressed = 0')->with('organization')->orderBy('id', 'DESC')->paginate(10);
        } else {
            if($status == 'active') $val = 1;
            if($status == 'unactive') $val = 0;
            $users = User::whereRaw('suppressed = 0 and active = '.$val)->with('organization')->orderBy('id', 'DESC')->paginate(10);
        }

        $admins = User::getAdmins();
        return view('admin.users.index')->with(['users' => $users, 'admins' => $admins, 'status' => $status]);
    }

    public function hijack(User $user)
    {
        Auth::login($user);

        return redirect($user->home_url);
    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|min:2|max:80',
            'last_name' => 'required|min:2|max:80',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user)
        {
            $password = Str::random();
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($password),
                'rank' => 'admin',
            ]);

            Mail::to($request->input('email'))->send(new AccountCreatedMail($user, $password));
        }

        return redirect()->back();
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|min:2|max:80',
            'last_name' => 'required|min:2|max:80',
            'company_name' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user)
        {
            $user = self::createUser($request->input('company_name'), $request->input('first_name'), $request->input('last_name'), $request->input('email'));
        }

        return response()->json($user);
    }

    public static function createUser($orgName, $firstName, $lastName, $email, $phone = null)
    {
        $password = Str::random();

        $company = Organization::create([
            'type' => 'company',
            'name' => $orgName
        ]);
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => Hash::make($password),
            'organization_id' => $company->id,
            'phone' => $phone
        ]);

        // Linking those in sellsy
        $sellsy = new SellsyService();
        $sellsy->linkContactCompany($user->sellsy_id, $company->sellsy_id);

        return $user;
    }

    public function desactive(User $user){
        $user->active = 0;
        $user->save();
        return redirect()->back();
    }

    public function active(User $user){
        $user->active = 1;
        $user->save();
        return redirect()->back();
    }

    public function suppressed(User $user){
        $user->suppressed = 1;
        $user->active = 0;
        $user->save();
        return redirect()->route('admin.users.index');
    }


    public function removeAdmin(User $user)
    {
        $user->rank = 'user';
        $user->save();

        return redirect()->back();
    }
}
