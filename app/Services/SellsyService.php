<?php

namespace App\Services;

use App\Models\Estimate;
use App\Models\Organization;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class SellsyService
{
    protected Client $client;

    protected array $headers;

    public function __construct($init = false)
    {
        if (!config('services.sellsy.activated'))
            return;
        if (!$init)
        {
            $this->client = new Client([
                'base_uri' => 'https://api.sellsy.com/v2/',
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getBearerToken(),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);
        }
    }

    private function getBearerToken()
    {
        if (!config('services.sellsy.activated'))
            return;
        return Cache::get('sellsy-access-token') ?? $this->refreshTokens();
    }

    public function getBearerFromAuthCode()
    {
        if (!config('services.sellsy.activated'))
            return;
        $code = Cache::get('sellsy-auth-code');

        $client = new Client();
        $res = $client->post('https://login.sellsy.com/oauth2/access-tokens', [
            'form_params' => [
                "grant_type" => "authorization_code",
                "client_id" => config('services.sellsy.key'),
                "redirect_uri" => config('services.sellsy.redirect_url'),
                "code_verifier" => Cache::get('sellsy-challenge'),
                "code" => $code
            ]
        ]);
        $res = json_decode($res->getBody()->getContents(), true);

        Cache::put('sellsy-access-token', $res['access_token'], 86400);
        Cache::put('sellsy-refresh-token', $res['refresh_token'], 5184000);
    }

    public function refreshTokens()
    {
        if (!config('services.sellsy.activated'))
            return;
        $code = Cache::get('sellsy-refresh-token');

        $client = new Client();
        $res = $client->post('https://login.sellsy.com/oauth2/access-tokens', [
            'form_params' => [
                "grant_type" => "refresh_token",
                "client_id" => config('services.sellsy.key'),
                "client_secret" => config('services.sellsy.secret'),
                "refresh_token" => $code,
            ]
        ]);
        $res = json_decode($res->getBody()->getContents(), true);

        Cache::put('sellsy-access-token', $res['access_token'], 86400);
        Cache::put('sellsy-refresh-token', $res['refresh_token'], 5184000);

        return $res['access_token'];
    }

    public function getEstimates()
    {
        if (!config('services.sellsy.activated'))
            return [];
        $req = $this->client->get('estimates');
        return $req->getBody()->getContents();
    }

    public function createCustomer(User $user)
    {
        if (!config('services.sellsy.activated'))
            return "";
        $data = [];
        $data["first_name"] = $user->first_name;
        $data["last_name"] = $user->last_name;
        $data['email'] = $user->email;
        if ($user->phone)
        {
            $data['phone'] = $user->phone;
        }

        $req = $this->client->request('POST', 'contacts', [
            'body' => json_encode($data),
        ]);

        $res = json_decode($req->getBody()->getContents(), true);
        return $res['id'];

    }

    public function createCompany($name)
    {
        if (!config('services.sellsy.activated'))
            return "";
        $data = [
            'type' => 'prospect',
            "name" => $name,
        ];

        $req = $this->client->request('POST', 'companies', [
            'body' => json_encode($data),
        ]);

        $res = json_decode($req->getBody()->getContents(), true);

        return $res['id'];
    }

    public function linkContactCompany($contactId, $companyId)
    {
        if (!config('services.sellsy.activated'))
            return "";
        $this->client->post('/companies/' . $companyId . '/contacts/' . $contactId);
    }

    public function createEstimate(Estimate $estimate)
    {
        if (!config('services.sellsy.activated'))
            return "";
        $data = [
            'related' => [],
            'contact_id' => (int)$estimate->user->sellsy_id,
        ];

        if ($estimate->user->organization)
        {
            $data['related'][] = [
                "type" => "company",
                "id" => (int)$estimate->user->organization->sellsy_id
            ];
        } else
        {
            $data['related'][] = [
                "type" => "individual",
                "id" => (int)$estimate->user->sellsy_id
            ];
        }

        $req = $this->client->request('POST', 'estimates', [
            'body' => json_encode($data),
        ]);

        $res = json_decode($req->getBody()->getContents(), true);
        return $res['id'];
    }

    public function updateEstimate(Estimate $estimate)
    {
        if (!config('services.sellsy.activated'))
            return "";
        $data = [];
        $data['rows'] = $estimate->getSellsyLinesRepresentation();

        $req = $this->client->request('PUT', 'estimates/' . $estimate->sellsy_id, [
            'body' => json_encode($data)
        ]);

        $res = json_decode($req->getBody()->getContents(), true);

        return $res;
    }

    public function retrieveClient($sellsyClientId)
    {
        if (!config('services.sellsy.activated'))
            return "";

        $req = $this->client->get('companies/' . $sellsyClientId);
        $res = json_decode($req->getBody()->getContents(), true);
        return $res;
    }

    public function retrieveContact($sellsyContactId)
    {
        if (!config('services.sellsy.activated'))
            return "";

        $req = $this->client->get('contacts/' . $sellsyContactId);
        $res = json_decode($req->getBody()->getContents(), true);
        return $res;
    }

    public function retrieveCompany($sellsyCompanyId)
    {
        if (!config('services.sellsy.activated'))
            return "";

        $req = $this->client->get('companies/' . $sellsyCompanyId);
        $res = json_decode($req->getBody()->getContents(), true);
        return $res;
    }

    // Returns the sellsy contact id if there is a match, otherwise null
    public function searchContactSellsy($email): int|null
    {
        if (!config('services.sellsy.activated'))
            return null;

        $req = $this->client->request('POST', 'contacts/search', [
            'body' => json_encode(['filters' => [
                'email' => $email
            ]]),
        ]);
        $res = json_decode($req->getBody()->getContents(), true);

        if (count($res['data']) < 1)
            return null;

        return $res['data'][0]['id'];
    }

    public function importUserFromSellsy($sellsyUser)
    {
        $sellsyOrgId = $this->searchCompanySellsy($sellsyUser['id']);
        if ($sellsyOrgId)
        {
            $sellsyCompany = $this->retrieveCompany($sellsyOrgId);
            $org = Organization::create([
                'sellsy_id' => $sellsyCompany['id'],
                'name' => $sellsyCompany['name'],
                'type' => 'company'
            ]);
            $orgId = $org->id;
        } else $orgId = null;


        return User::create([
            'first_name' => $sellsyUser['first_name'] ?? '',
            'last_name' => $sellsyUser['last_name'],
            'email' => $sellsyUser['email'],
            'sellsy_id' => $sellsyUser['id'],
            'password' => Hash::make(rand(1000, 10000000)),
            'phone' => $sellsyUser['mobile_number'] ?? $sellsyUser['phone_number'],
            'organization_id' => $orgId,
        ]);
    }

    // Returns the sellsy company id if there is a match, otherwise null
    public function searchCompanySellsy($sellsyContactId): int|null
    {
        if (!config('services.sellsy.activated'))
            return "";

        $req = $this->client->request('POST', 'companies/search', [
            'body' => json_encode(['filters' => [
                'contacts' => [$sellsyContactId]
            ]]),
        ]);

        $res = json_decode($req->getBody()->getContents(), true);

        if (count($res['data']) < 1)
            return null;

        return $res['data'][0]['id'];
    }

}
