<?php

namespace App\Observers;

use App\Models\ClientCompany;

class ClientCompanyObserver
{
    /**
     * Handle the ClientCompany "created" event.
     */
    public function created(ClientCompany $clientCompany): void
    {
        //
    }

    /**
     * Handle the ClientCompany "updating" event.
     *
     * Cascades status changes from the company to all its related client accounts.
     * Only processes when status changes to inactive (0) to prevent unnecessary updates.
     *
     * @param ClientCompany $clientCompany The ClientCompany instance being updated
     * @return void
     */
    public function updating(ClientCompany $clientCompany)
    {
        if ($clientCompany->isDirty('status')) {
            if ($clientCompany->status == 0) {
                $clientCompany->client_accounts()->each(function ($merchant) use ($clientCompany) {
                    $merchant->update(['status' => $clientCompany->status ? 'active' : 'inactive']);
                });
            }
        }
    }

    /**
     * Handle the ClientCompany "updated" event.
     */
    public function updated(ClientCompany $clientCompany): void
    {
        //
    }

    /**
     * Handle the ClientCompany "deleted" event.
     */
    public function deleted(ClientCompany $clientCompany): void
    {
        if ($clientCompany->trashed()) {
            $clientCompany->client_accounts()->each(function ($merchant) use ($clientCompany) {
                $merchant->delete();
            });
        }
    }

    /**
     * Handle the ClientCompany "restored" event.
     */
    public function restored(ClientCompany $clientCompany): void
    {
        //
    }

    /**
     * Handle the ClientCompany "force deleted" event.
     */
    public function forceDeleted(ClientCompany $clientCompany): void
    {
        //
    }
}
