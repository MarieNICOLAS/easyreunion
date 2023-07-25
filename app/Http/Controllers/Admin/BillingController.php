<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class BillingController extends Controller
{
    public function partnersIndex()
    {
        return view('admin.billing.partners.index');
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->status = 'paid';
        $invoice->save();

        $invoice->partner->balance -= $invoice->ttc_total;
        $invoice->partner->save();

        return redirect()->back();
    }
}
