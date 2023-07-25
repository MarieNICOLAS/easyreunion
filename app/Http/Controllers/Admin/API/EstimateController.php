<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\API\APIController;
use App\Mail\EstimateSignatureRequestMail;
use App\Models\Estimate;
use App\Models\EstimateActivity;
use App\Models\EstimateFile;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EstimateController extends APIController
{
    public function index(Request $request)
    {
        $estimatesQuery = Estimate::select('id', 'amount_total', 'booking_date', 'user_id', 'updated_at', 'organization_id', 'er_referent_id')
            ->where('signed', false)
            ->orderBy('id', 'DESC')
            ->with('user:id,first_name,last_name', 'organization:id,name', 'referent');

        if ($request->input('start') && $request->input('end'))
        {
            $estimatesQuery = $estimatesQuery->whereDate('created_at', '>=', $request->input('start'))
                ->whereDate('created_at', '<=', $request->input('end'));
        }

        if ($request->input('referent'))
        {
            $estimatesQuery = $estimatesQuery->where('er_referent_id', $request->input('referent'));
        }

        if ($request->input('spaces'))
        {
            $spaces = explode(',', $request->input('spaces'));
            $estimatesQuery = $estimatesQuery->whereHas('lines', function ($q) use ($spaces)
            {
                $q->whereIn('space_id', $spaces);
            });
        }

        return $this->success($estimatesQuery->paginate(10));
    }

    public function show(Request $request, Estimate $estimate)
    {
        return $this->success([
            'id' => $estimate->id,
            'amount_total' => $estimate->amount_total,
            'booking_date' => $estimate->booking_date ? date('d/m/y', strtotime($estimate->booking_date)) : null,
            'user' => [
                'id' => $estimate->user_id,
                'name' => $estimate->user->name,
                'first_name' => $estimate->user->first_name,
                'last_name' => $estimate->user->last_name,
                'phone' => $estimate->user->phone,
                'email' => $estimate->user->email,
                'sellsy_url' => $estimate->user->sellsy_url,
            ],
            'lines' => $estimate->lines,
            'activities' => $estimate->activities,
            'auto_deposit' => $estimate->auto_deposit,
            'agenda_elements' => $estimate->agendaElements->append(['space', 'has_conflicts', 'date']),
            'created_at' => date('d/m/Y', strtotime($estimate->created_at)),
            'starts_at' => $estimate->calculateStartDate()?->format('d/m/Y'),
            'ends_at' => $estimate->calculateEndDate()?->format('d/m/Y'),
            'request' => $estimate->initialRequest,
            'internalNote' => $estimate->internal_note,
            'files' => $estimate->files,
            'organization' => $estimate->organization,
            'referent' => $estimate->referent,
            'status' => $estimate->agendaElements->first()?->status,
            'available_spaces' => Space::select('id', 'name')->with('agenda:id,space_id,name')->where('space_group_id', $estimate->agendaElements->first()?->space?->space_group_id)->get(),
        ]);
    }


    public function markAsSigned(Request $request, Estimate $estimate)
    {
        $estimate->signed = true;
        $estimate->amount_total = $estimate->totalCost();
        $estimate->save();

        $booking = $estimate->createBooking();

        if ($estimate->auto_deposit)
            $booking->generateInvoice(.5);

        return $this->success(['url' => route('admin.bookings.show', $booking)]);
    }

    public function updateNote(Request $request, Estimate $estimate)
    {
        $request->validate(['note' => 'required']);

        $estimate->internal_note = $request->input('note');
        $estimate->save();

        return $this->success([]);
    }

    public function updateOptions(Request $request, Estimate $estimate)
    {
        $estimate->auto_deposit = (bool)$request->input('auto_deposit');
        $estimate->save();


        return $this->success([]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'type' => 'required',
            'estimate_id' => 'nullable|exists:estimates,id',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);

        $name = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->store('files');

        return $this->success(EstimateFile::create([
            'filename' => $path,
            'name' => $name,
            'type' => $request->input('type'),
            'estimate_id' => $request->input('estimate_id') ?? null,
            'booking_id' => $request->input('booking_id') ?? null,
        ]));
    }

    public function deleteFile(Request $request, EstimateFile $file)
    {
        Storage::delete('files/'.$file->filename);
        $file->delete();

        return $this->success([]);
    }
}
