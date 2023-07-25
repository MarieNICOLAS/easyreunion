<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Front\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index()
    {
        $jobs = JobOffer::all();

        return view('admin.jobs.index')->with(['jobs' => $jobs]);
    }

    public function store(Request $request)
    {
        $request->validate(JobOffer::$validation);

        $job = JobOffer::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'active' => (boolean)$request->input('active'),
        ]);

        return redirect()->route('admin.job-offers.show', $job)->with(['success' => "L'annonce a bien été créée"]);
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function show(Request $request, JobOffer $jobOffer)
    {
        return view('admin.jobs.show')->with(['job' => $jobOffer]);
    }

    public function edit(JobOffer $jobOffer)
    {
        return view('admin.jobs.edit')->with(['job' => $jobOffer]);
    }

    public function update(Request $request, JobOffer $jobOffer)
    {
        $request->validate(JobOffer::$validation);

        $jobOffer->title = $request->input('title');
        $jobOffer->description = $request->input('description');
        $jobOffer->active = filter_var($request->input('active'), FILTER_VALIDATE_BOOLEAN);
        $jobOffer->save();

        return redirect()->route('admin.job-offers.show', $jobOffer)->with(['success' => "L'annonce a bien été mise à jour"]);
    }

    public function delete(JobOffer $job)
    {
        $job->delete();

        return redirect()->route('admin.job-offers.index')->with(['success' => 'L\'annonce a bien été supprimé']);
    }
}
