<?php

namespace App\Observers;

use App\Models\Shop\Customer;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        if ($customer->hasStripeId()) {
            $customer->syncOrCreateStripeCustomer();
        }
    }

    /**
     * Handle the Customer "deleting" event.
     */
    public function deleting(Customer $customer): void
    {
        $customer->subscription()?->cancelNow();
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
