<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use App\Models\EstimateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class EstimateRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = EstimateRequest::select('id', 'space_id', 'company', 'created_at', 'message')->with('space:id,name')->orderBy('id', 'DESC');

        if (!$request->input('type') || $request->input('type') === 'pending')
            $requests = $requests->pending();


        return view('admin.requests.index')->with(['requests' => $requests->paginate(20), 'type' => ($request->input('type', 'pending'))]);
    }

    public function show(Request $request, EstimateRequest $estreq)
    {
        return view('admin.requests.show')->with(['request' => $estreq]);
    }

    public function close(Request $request, EstimateRequest $estreq)
    {
        $estreq->closeRequest();

        return redirect()->route('admin.estimate-requests.index')->with(['success' => 'La requête a bien été clôturée']);
    }

    public function createEstimate(EstimateRequest $estreq)
    {
        $user = User::where('email', $estreq->email)->first();
        if (!$user)
        {
            if (str_contains($estreq->name, ' '))
            {
                $index = strpos($estreq->name, ' ');
                $firstName = substr($estreq->name, 0, $index);
                $lastName = substr($estreq->name, $index);
            } else
            {
                $firstName = $estreq->name;
                $lastName = '';
            }
            $user = UserController::createUser($estreq->company, $firstName, $lastName, $estreq->email, $estreq->phone);
        }
        $estimate = Estimate::create([
            'user_id' => $user->id,
            'organization_id' => $user->organization_id,
            'estimate_request_id' => $estreq->id,
        ]);

        foreach ($estreq->agendaElements as $agendaElement)
        {
            $agendaElement->estimate_id = $estimate->id;
            $agendaElement->status = 'option';
            $agendaElement->save();
            $agendaElement->agenda->flushCache();
        }

        $estreq->status = 'converted';
        $estreq->save();

        return redirect()->route('admin.estimates.edit', $estimate);
    }
}
