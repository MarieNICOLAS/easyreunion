<?php

namespace App\Mail;

use App\Models\EstimateRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstimateRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $company;
    public $phone;
    public $email;
    public $start;
    public $end;
    public $space;
    public $time;
    public $comment;
    public $estimateRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EstimateRequest $estimateRequest)
    {
        $this->estimateRequest = $estimateRequest;
        $this->name = $estimateRequest->name;
        $this->company = $estimateRequest->company;
        $this->phone = $estimateRequest->phone;
        $this->email = $estimateRequest->email;
        $this->start = $estimateRequest->start;
        $this->end = $estimateRequest->end;
        $this->space = $estimateRequest->space;
        $this->time = __('forms.time.' . $estimateRequest->time);
        $this->comment = $estimateRequest->comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.estimate-request')->subject('[Easy Réunion] Nouvelle demande de devis');
    }
}
