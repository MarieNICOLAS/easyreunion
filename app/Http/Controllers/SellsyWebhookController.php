<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Services\SellsyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SellsyWebhookController extends Controller
{
    public function receiveEvent(Request $request)
    {
        Log::info($request);
        $notification = json_decode($request->input('notif'), true);

        if ($notification['eventType'] === "thirdLog" && $notification['thirdtype'] === 'client')
        {
            switch ($notification['event'])
            {
                case 'created':
                case 'updated':
                    $this->createOrUpdateCustomerFromSellsyClientId($notification['relatedid']);
            }
        } else if ($notification['eventType'] === "peopleLog" && $notification['relatedtype'] === 'people')
        {
            switch ($notification['event'])
            {
                case 'created':
                case 'updated':
                    $this->updateContactFromSellsyId($notification['relatedid']);
            }
        }
    }

    public function updateContactFromSellsyId($id)
    {
        $sellsy = new SellsyService();
        $sellsyUser = $sellsy->retrieveContact($id);

        // If no email was specified, we cannot do anything
        if (!$sellsyUser['email'])
            return;

        $user = User::where('sellsy_id', $sellsyUser['id'])->first();

        if (!$user)
        {
            $user = User::where('email', $sellsyUser['email'])->first();
            if ($user)
            {
                $user->sellsy_id = $sellsyUser['id'];
            } else
            {
                $sellsy->importUserFromSellsy($sellsyUser);
            }
        }

        if ($user)
        {
            // Everything is alright, we have the user and the organization, we can update them
            $user->email = $sellsyUser['email'];
            $user->phone = $sellsyUser['mobile_number'] ?? $sellsyUser['phone_number'];
            $user->first_name = $sellsyUser['first_name'];
            $user->last_name = $sellsyUser['last_name'];
            $user->save();
        }
    }

    public function createOrUpdateCustomerFromSellsyClientId($id)
    {
        $sellsy = new SellsyService();

        $sellsyCompany = $sellsy->retrieveClient($id);
        $sellsyUser = $sellsy->retrieveContact($sellsyCompany['main_contact_id']);

        // If no email was specified, we cannot do anything
        if (!$sellsyUser['email'])
            return;

        // Otherwise we check if it's an update or a creation
        $org = Organization::where('sellsy_id', $sellsyCompany['id'])->first();

        if (!$org)
        {
            $user = User::where('email', $sellsyUser['email'])->first();
            // If there already is a user, link it to its sellsy account
            if ($user)
            {
                $user->sellsy_id = $sellsyUser['id'];
                $user->save();

                $org = $user->organization;
                if ($org)
                {
                    $org->id = $sellsyCompany['id'];
                    $org->save();
                }
            } else
            {
                $org = Organization::create([
                    'sellsy_id' => $sellsyCompany['id'],
                    'name' => $sellsyCompany['name'],
                    'type' => 'company'
                ]);

                User::create([
                    'first_name' => $sellsyUser['first_name'] ?? '',
                    'last_name' => $sellsyUser['last_name'],
                    'email' => $sellsyUser['email'],
                    'sellsy_id' => $sellsyUser['id'],
                    'organization_id' => $org->id,
                    'password' => Hash::make(rand(1000, 10000000)),
                    'phone' => $sellsyUser['mobile_number'] ?? $sellsyUser['phone_number']
                ]);
            }
        }
        $user = User::where('sellsy_id', $sellsyUser['id'])->first();

        if ($user)
        {
            // Everything is alright, we have the user and the organization, we can update them
            $user->email = $sellsyUser['email'];
            $user->phone = $sellsyUser['mobile_number'] ?? $sellsyUser['phone_number'];
            $user->first_name = $sellsyUser['first_name'];
            $user->last_name = $sellsyUser['last_name'];
            $user->save();
        }
        if ($org)
        {
            $org->name = $sellsyCompany['name'];
            $org->save();
        }

    }
}
