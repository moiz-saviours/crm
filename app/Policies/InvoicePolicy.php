<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Check if a user can edit an invoice.
     */
        public function edit(User $user, Invoice $invoice)
        {
            if (!$invoice->id) return Response::denyWithStatus(404, 'Oops! Invoice not found.');
            if ($invoice->status == 1) return Response::denyWithStatus(400, 'Oops! The Invoice is already paid.');
            // Refunded invoices (status 2)
            if ($invoice->status == 2) return Response::denyWithStatus(400, 'This invoice has been refunded and cannot be modified.');
            // Chargeback invoices (status 3)
            if ($invoice->status == 3) return Response::denyWithStatus(400, 'This invoice has a chargeback and cannot be modified.');
            if ($invoice->creator_type == 'App\Models\Admin') return Response::deny("You don't have permission to perform this action.");
            // Check if user is the agent (matching ID + type)
            if ($invoice->agent && $invoice->agent->is($user)) return Response::allow();
            // Check if user is the creator (matching ID + type)
            if ($invoice->creator && $invoice->creator->is($user)) return Response::allow();
            // Check if user is the team lead
            if ($invoice->team_key && Team::where('team_key', $invoice->team_key)->where('lead_id', $user->id)->exists()) return Response::allow();
            return Response::deny("You don't have permission to perform this action.");
        }

    /**
     * Check if a user can update an invoice.
     */
    public function update(User $user, Invoice $invoice)
    {
        return $this->edit($user, $invoice);
    }
}
