<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\API\APIController;
use App\Models\Setting;
use App\Models\Space;
use App\Models\SpaceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends APIController
{
    public function index()
    {
        return $this->success(Setting::getHomePageSettings());
    }

    public function availableSpaces()
    {
        $spaces = Space::select('id', 'name')->get()->append('key');
        $groups = SpaceGroup::select('id', 'name')->get()->append('key');
        return $this->success(['spaces' => $spaces, 'groups' => $groups]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|exists:settings,key',
            'value' => 'required'
        ]);

        Setting::where('key', $request->input('key'))->update(['value' => $request->input('value')]);

        Cache::forget('homepage-content');
        return $this->success([]);
    }
}
