<?php

namespace App\Observers;

use App\Models\ClientContact;

class ClientContactObserver
{
    /**
     * Handle the ClientContact "created" event.
     */
    public function created(ClientContact $clientContact): void
    {
        //
    }
    
    /**
     * Handle the ClientContact "updating" event.
     *
     * This method triggers before a ClientContact is updated in the database.
     * It cascades status changes to related companies and their accounts.
     *
     * @param ClientContact $clientContact The ClientContact instance being updated
     */
    public function updating(ClientContact $clientContact): void
    {
        if ($clientContact->isDirty('status')) {
            $clientContact->companies()->each(function ($clientCompany) use ($clientContact) {
                if ($clientContact->status == 0) {
                    $clientCompany->update(['status' => $clientContact->status]);
                    $clientCompany->client_accounts()->each(function ($merchant) use ($clientContact) {
                        $merchant->update(['status' => $clientContact->status ? 'active' : 'inactive']);
                    });
                }
            });
        }
    }

    /**
     * Handle the ClientContact "updated" event.
     */
    public function updated(ClientContact $clientContact): void
    {
        //
    }

    /**
     * Handle the ClientContact "deleted" event.
     */
    public function deleted(ClientContact $clientContact): void
    {
        if ($clientContact->trashed()) {
            $clientContact->companies()->each(function ($clientCompany) use ($clientContact) {
                $clientCompany->delete();
                $clientCompany->client_accounts()->each(function ($merchant) use ($clientCompany) {
                    $merchant->delete();
                });
            });
        }
    }

    /**
     * Handle the ClientContact "restored" event.
     */
    public function restored(ClientContact $clientContact): void
    {
        //
    }

    /**
     * Handle the ClientContact "force deleted" event.
     */
    public function forceDeleted(ClientContact $clientContact): void
    {
        //
    }
}
