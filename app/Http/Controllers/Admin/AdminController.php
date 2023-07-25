<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstimateFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Cache::has('sellsy-refresh-token') == false && (env('SELLSY_ACTIVATED' == true)))
            return redirect()->route('admin.sellsy-admin-login');

        return view('admin.dashboard');
    }

    public function search(Request $request, $req)
    {
        $results = [];

        // Searching for companies
        foreach (User::whereRaw("( concat(first_name, ' ', last_name) like '%".strtolower($req)."%' ")
                     ->orWhereRaw("concat(first_name, ' ', last_name) like '%".ucfirst($req)."%' ) ")
                     ->whereRaw(" suppressed = 0")
                     ->limit(8)->get() as $user) {
            $results[] = [
                'name' => $user->name,
                'route' => route('admin.users.show', $user),
            ];
        }

        return response()->json($results);
    }

    public function viewFile(EstimateFile $file)
    {
        return response()->file(storage_path('app/'.$file->filename));
    }

    public function downloadFile(EstimateFile $file)
    {
        return response()->download(storage_path('app/'.$file->filename));
    }
}
