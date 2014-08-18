<?php
namespace Acme\Subscription\State;

class AbstractState {

    public function cancelSubscription()
    {
        // update seats
        // remove (delete) subscription
        echo 'removing from database';
    }

} 